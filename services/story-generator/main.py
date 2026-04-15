from pathlib import Path
import json
import os
import tempfile

from fastapi import FastAPI, File, Form, HTTPException, UploadFile, status
from fastapi.middleware.cors import CORSMiddleware

import gemini as gemini_service

app = FastAPI(title="D&D Story Generator", version="2.0.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

ALLOWED_MIME = {"image/png", "image/jpeg", "image/webp"}
MAX_FILE_SIZE = 10 * 1024 * 1024  # 10 MB


@app.post("/api/stories/generate")
async def generate_story(
    file: UploadFile = File(...),
    original_story: str | None = Form(default=None),
    tone: str | None = Form(default=None),
    enhancements: str | None = Form(default=None),
    feedback_text: str | None = Form(default=None),
    reaction: str | None = Form(default=None),
):
    if file.content_type not in ALLOWED_MIME:
        raise HTTPException(
            status_code=status.HTTP_415_UNSUPPORTED_MEDIA_TYPE,
            detail=f"Unsupported file type '{file.content_type}'. Allowed: PNG, JPEG, WEBP.",
        )

    contents = await file.read()
    if len(contents) > MAX_FILE_SIZE:
        raise HTTPException(
            status_code=status.HTTP_413_REQUEST_ENTITY_TOO_LARGE,
            detail="File exceeds the 10 MB limit.",
        )

    suffix = Path(file.filename or "image.png").suffix or ".png"

    with tempfile.NamedTemporaryFile(delete=False, suffix=suffix) as tmp:
        tmp.write(contents)
        tmp_path = tmp.name

    try:
        parsed_enhancements = json.loads(enhancements) if enhancements else None

        story_text = await gemini_service.generate_story(
            image_path=tmp_path,
            mime_type=file.content_type,
            original_story=original_story,
            tone=tone,
            enhancements=parsed_enhancements,
            feedback_text=feedback_text,
            reaction=reaction,
        )

        return {
            "story_text": story_text,
            "tone": tone,
            "enhancements": parsed_enhancements,
            "feedback_text": feedback_text,
            "reaction": reaction,
        }
    finally:
        try:
            os.remove(tmp_path)
        except OSError:
            pass
