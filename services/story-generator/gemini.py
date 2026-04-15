"""
Gemini 1.5 Pro API service.

Handles building prompts and calling the REST API with an image + text payload.
The API key never leaves the server.
"""

import base64
import os

import httpx
from dotenv import load_dotenv
from fastapi import HTTPException

load_dotenv()

GEMINI_API_KEY = os.getenv("GEMINI_API_KEY", "")
GEMINI_URL = (
    "https://generativelanguage.googleapis.com/v1beta/models/"
    "gemini-1.5-pro:generateContent"
)

GENERATION_CONFIG = {
    "temperature": 0.95,
    "maxOutputTokens": 2048,
    "topP": 0.95,
}


# ── Prompt builders ────────────────────────────────────────────────────────────

def _initial_prompt() -> str:
    return (
        "You are a master Dungeons & Dragons worldbuilder and storyteller with decades of "
        "experience crafting rich campaign settings.\n\n"
        "Carefully examine this map image. Observe everything: terrain features, mountain "
        "ranges, forests, rivers, coastlines, deserts, swamps, settlements, cities, ruins, "
        "dungeon entrances, roads, borders, and any symbols, labels, or annotations visible.\n\n"
        "Based on your detailed analysis, craft an immersive D&D story and lore entry of "
        "approximately 500–700 words. Structure your response with:\n\n"
        "1. **[Region Name]** — Invent a compelling fantasy name for this region.\n"
        "2. A vivid **opening paragraph** that sets the atmosphere and geography.\n"
        "3. **History & Origins** — The ancient history, who founded it, any great wars or disasters.\n"
        "4. **The People & Creatures** — Who inhabits this land? Factions, races, notable NPCs?\n"
        "5. **Current Conflict or Adventure Hook** — What tension or quest draws adventurers here?\n"
        "6. **Notable Locations** — 2–3 specific places on the map with names and secrets.\n"
        "7. **Legends & Mysteries** — One tantalizing unsolved mystery or local legend.\n\n"
        "Write in an engaging, epic narrative style. Make it feel alive, dangerous, and full of wonder."
    )


def _regeneration_prompt(
    original_story: str,
    tone: str | None,
    enhancements: list[str] | None,
    feedback_text: str | None,
    reaction: str | None,
) -> str:
    lines = [
        "You previously generated the following D&D story/lore from a map:\n",
        "--- ORIGINAL STORY ---",
        original_story,
        "--- END ORIGINAL STORY ---\n",
        "The user wants you to refine and improve this story. Rewrite it incorporating "
        "the feedback below while preserving the best elements of the original:\n",
    ]

    if reaction == "up":
        lines.append("• The user liked the overall story — keep its strengths but push further.")
    elif reaction == "down":
        lines.append("• The user felt the story needed significant improvement — be bolder and more creative.")

    if tone:
        lines.append(f"• Tone: Rewrite with a distinctly **{tone}** tone throughout.")

    if enhancements:
        lines.append("• Enhancements requested:")
        for e in enhancements:
            lines.append(f"  - {e}")

    if feedback_text:
        lines.append(f'• Additional instructions: "{feedback_text}"')

    lines.append(
        "\nKeep the same general structure (region name, history, people, conflict, "
        "locations, mysteries) but make it substantially better. Aim for 500–700 words. "
        "Write in an engaging D&D narrative style."
    )

    return "\n".join(lines)


# ── Core API call ──────────────────────────────────────────────────────────────

async def generate_story(
    image_path: str,
    mime_type: str,
    *,
    original_story: str | None = None,
    tone: str | None = None,
    enhancements: list[str] | None = None,
    feedback_text: str | None = None,
    reaction: str | None = None,
) -> str:
    """
    Call Gemini with the map image and return the generated story text.

    Pass `original_story` (and optionally the feedback args) to trigger
    the refinement/regeneration path instead of the initial generation path.
    """
    if not GEMINI_API_KEY:
        raise HTTPException(status_code=500, detail="GEMINI_API_KEY is not configured on the server.")

    # Read and base64-encode the image
    with open(image_path, "rb") as f:
        image_b64 = base64.b64encode(f.read()).decode("utf-8")

    # Choose prompt
    if original_story:
        prompt = _regeneration_prompt(original_story, tone, enhancements, feedback_text, reaction)
    else:
        prompt = _initial_prompt()

    payload = {
        "contents": [
            {
                "role": "user",
                "parts": [
                    {"inline_data": {"mime_type": mime_type, "data": image_b64}},
                    {"text": prompt},
                ],
            }
        ],
        "generationConfig": GENERATION_CONFIG,
    }

    async with httpx.AsyncClient(timeout=60.0) as client:
        response = await client.post(
            GEMINI_URL,
            params={"key": GEMINI_API_KEY},
            json=payload,
        )

    if response.status_code != 200:
        detail = _extract_error(response)
        raise HTTPException(status_code=502, detail=f"Gemini API error: {detail}")

    data = response.json()
    text = data.get("candidates", [{}])[0].get("content", {}).get("parts", [{}])[0].get("text")

    if not text:
        raise HTTPException(status_code=502, detail="Gemini returned an empty response.")

    return text


def _extract_error(response: httpx.Response) -> str:
    try:
        return response.json().get("error", {}).get("message", response.text)
    except Exception:
        return response.text
