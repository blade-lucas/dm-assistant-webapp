<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    private const SKILLS = [
        // skill => governing ability
        'acrobatics' => 'dex',
        'animal_handling' => 'wis',
        'arcana' => 'int',
        'athletics' => 'str',
        'deception' => 'cha',
        'history' => 'int',
        'insight' => 'wis',
        'intimidation' => 'cha',
        'investigation' => 'int',
        'medicine' => 'wis',
        'nature' => 'int',
        'perception' => 'wis',
        'performance' => 'cha',
        'persuasion' => 'cha',
        'religion' => 'int',
        'sleight_of_hand' => 'dex',
        'stealth' => 'dex',
        'survival' => 'wis',
    ];

    private static function profBonus(int $level): int
    {
        // D&D 5e proficiency bonus progression
        return match (true) {
            $level >= 17 => 6,
            $level >= 13 => 5,
            $level >= 9  => 4,
            $level >= 5  => 3,
            default      => 2,
        };
    }

    public function index()
    {
        $characters = \App\Models\Character::query()
            ->orderByDesc('updated_at')
            ->get();

        return view('characters.index', [
            'characters' => $characters,
        ]);
    }

    public function create()
    {
        return view('characters.create', [
            'raceOptions' => ['Human','Elf','Dwarf','Halfling','Gnome','Half-Elf','Half-Orc','Tiefling','Dragonborn'],
            'classOptions' => ['Barbarian','Bard','Cleric','Druid','Fighter','Monk','Paladin','Ranger','Rogue','Sorcerer','Warlock','Wizard'],
            'alignmentOptions' => [
                'Lawful Good','Neutral Good','Chaotic Good',
                'Lawful Neutral','True Neutral','Chaotic Neutral',
                'Lawful Evil','Neutral Evil','Chaotic Evil',
            ],
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:120'],
            'role' => ['required','in:player,party_npc,generic_npc'],
            'race' => ['nullable','string','max:60'],
            'class' => ['nullable','string','max:60'],
            'alignment' => ['nullable','string','max:60'],
        ]);

        $character = \App\Models\Character::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'race' => $validated['race'] ?? null,
            'class' => $validated['class'] ?? null,
            'alignment' => $validated['alignment'] ?? null,
            'level' => 1,
            'data' => [
                // give your tabs a predictable starting structure
                'abilities' => ['str'=>10,'dex'=>10,'con'=>10,'int'=>10,'wis'=>10,'cha'=>10],
                'skills' => ['proficient' => []],
                'features' => [],
                'equipment' => [
                    'wallet' => ['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0],
                    'inventory' => [],
                ],
                'spells' => [
                    'known' => [],
                    'prepared' => [],
                ],
                'npc_traits' => [
                    'profession' => 'Shopkeeper',
                    'work_place' => '',
                    'family' => '',
                    'religion' => '',
                    'backstory' => '',
                ],
                'dm_notes' => [
                    'notes' => [],
                    'active_id' => null,
                ],
            ],
        ]);

        return redirect()->route('characters.basic.edit', $character);
    }

    public function destroy(\App\Models\Character $character)
    {
        $character->delete();

        return redirect()
            ->route('characters.index')
            ->with('status', 'Character deleted.');
    }

    private static function mod(int $score): int
    {
        return intdiv($score - 10, 2);
    }

    private static function speedForRace(?string $race): int
    {
        // Sprint 2: simple defaults. Expand later.
        return match ($race) {
            'Dwarf' => 25,
            'Halfling' => 25,
            default => 30,
        };
    }

    public function edit(Character $character)
    {
        $abilities = $character->abilities ?? ['str'=>10,'dex'=>10,'con'=>10,'int'=>10,'wis'=>10,'cha'=>10];
        $skills = $character->skills ?? ['proficient' => [], 'bonuses' => []];
        $features = $character->features ?? [];

        $options = [
            'races' => ['Human','Elf','Dwarf','Halfling','Gnome','Half-Elf','Half-Orc','Tiefling'],
            'classes' => ['Barbarian','Bard','Cleric','Druid','Fighter','Monk','Paladin','Ranger','Rogue','Sorcerer','Warlock','Wizard'],
            'alignments' => [
                'Lawful Good','Neutral Good','Chaotic Good',
                'Lawful Neutral','True Neutral','Chaotic Neutral',
                'Lawful Evil','Neutral Evil','Chaotic Evil'
            ],
            // Features dropdown sources (Sprint 2: placeholder lists; replace with your JSON tables later)
            'appearance' => ['Distinctive jewelry','Scarred','Immaculate','Rugged','Mysterious','Elegant'],
            'talents' => ['Plays an instrument','Great cook','Excellent liar','Painter','Gambler','Quick learner'],
            'mannerisms' => ['Taps fingers','Stares','Laughs often','Whispers','Paces','Chews lip'],
            'interaction' => ['Friendly','Suspicious','Blunt','Shy','Charming','Aggressive'],
            'ideals' => ['Freedom','Power','Justice','Tradition','Knowledge','Charity'],
            'bonds' => ['Family','Mentor','Guild','Homeland','Lost love','Oath'],
            'flaws' => ['Greedy','Stubborn','Hot-tempered','Cowardly','Naive','Vengeful'],
            'sex' => ['Male','Female','Non-binary','Other','Unknown'],
        ];

        return view('characters.edit_basic', [
            'character' => $character,
            'abilities' => $abilities,
            'skills' => $skills,
            'features' => $features,
            'skillMap' => self::SKILLS,
            'options' => $options,
        ]);
    }

    public function updateBasic(Request $request, Character $character)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:120'],
            'level' => ['required','integer','min:1','max:20'],
            'race' => ['nullable','string','max:80'],
            'class' => ['nullable','string','max:80'],
            'alignment' => ['nullable','string','max:80'],
            'role' => ['required','in:player,party_npc,generic_npc'],

            'abilities' => ['required','array'],
            'abilities.str' => ['required','integer','min:1','max:30'],
            'abilities.dex' => ['required','integer','min:1','max:30'],
            'abilities.con' => ['required','integer','min:1','max:30'],
            'abilities.int' => ['required','integer','min:1','max:30'],
            'abilities.wis' => ['required','integer','min:1','max:30'],
            'abilities.cha' => ['required','integer','min:1','max:30'],

            'skills' => ['nullable','array'],
            'skills.proficient' => ['nullable','array'],

            'features' => ['nullable','array'],
        ]);

        $level = (int)$validated['level'];
        $abilities = $validated['abilities'];
        $prof = self::profBonus($level);

        $proficient = $validated['skills']['proficient'] ?? [];
        $bonuses = [];

        foreach (self::SKILLS as $skill => $abilityKey) {
            $base = self::mod((int)$abilities[$abilityKey]);
            $isProf = !empty($proficient[$skill]);
            $bonuses[$skill] = $base + ($isProf ? $prof : 0);
        }

        // Derived quick stats (refine later with armor/equipment)
        $dexMod = self::mod((int)$abilities['dex']);
        $ac = 10 + $dexMod;
        $initiative = $dexMod;
        $speed = self::speedForRace($validated['race'] ?? null);

        $character->update([
            'name' => $validated['name'],
            'level' => $level,
            'race' => $validated['race'] ?? null,
            'class' => $validated['class'] ?? null,
            'alignment' => $validated['alignment'] ?? null,
            'role' => $validated['role'],

            'abilities' => $abilities,
            'skills' => [
                'proficient' => $proficient,
                'bonuses' => $bonuses,
            ],
            'features' => $validated['features'] ?? [],

            'ac' => max(1, $ac),
            'initiative' => $initiative,
            'speed' => max(0, $speed),
        ]);

        return redirect()
            ->route('characters.basic.edit', $character)
            ->with('status', 'Saved.');
    }

    public function editEquipment(\App\Models\Character $character)
    {
        $equipment = $character->data['equipment'] ?? [
            'wallet' => ['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0],
            'inventory' => [], // array of { id, name, type, qty, equipped, cost?, image? }
        ];

        // Sprint 2: stub catalog. Later: load from DB/JSON.
        $catalog = [
            'weapons' => [
                ['id'=>'club', 'name'=>'Club', 'cost'=>['sp'=>1], 'type'=>'Weapon', 'image'=>null],
                ['id'=>'dagger', 'name'=>'Dagger', 'cost'=>['gp'=>2], 'type'=>'Weapon', 'image'=>null],
            ],
            'armor' => [
                ['id'=>'leather', 'name'=>'Leather Armor', 'cost'=>['gp'=>10], 'type'=>'Armor', 'image'=>null],
                ['id'=>'shield', 'name'=>'Shield', 'cost'=>['gp'=>10], 'type'=>'Armor', 'image'=>null],
            ],
            'gear' => [
                ['id'=>'rope', 'name'=>'Hempen Rope (50 ft.)', 'cost'=>['gp'=>1], 'type'=>'Gear', 'image'=>null],
                ['id'=>'torch', 'name'=>'Torch', 'cost'=>['cp'=>1], 'type'=>'Gear', 'image'=>null],
            ],
            'other' => [
                ['id'=>'potion_healing', 'name'=>'Potion of Healing', 'cost'=>['gp'=>50], 'type'=>'Other', 'image'=>null],
            ],
        ];

        return view('characters.edit_equipment', [
            'character' => $character,
            'equipment' => $equipment,
            'catalog' => $catalog,
        ]);
    }

    public function updateEquipment(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'equipment' => ['required','array'],
            'equipment.wallet' => ['required','array'],
            'equipment.wallet.cp' => ['required','integer','min:0'],
            'equipment.wallet.sp' => ['required','integer','min:0'],
            'equipment.wallet.ep' => ['required','integer','min:0'],
            'equipment.wallet.gp' => ['required','integer','min:0'],
            'equipment.wallet.pp' => ['required','integer','min:0'],

            'equipment.inventory' => ['nullable','array'],
        ]);

        // Normalize inventory rows a bit
        $inventory = array_values($validated['equipment']['inventory'] ?? []);
        foreach ($inventory as &$row) {
            $row['qty'] = max(1, (int)($row['qty'] ?? 1));
            $row['equipped'] = !empty($row['equipped']);
        }

        $equipment = [
            'wallet' => $validated['equipment']['wallet'],
            'inventory' => $inventory,
        ];

        $data = $character->data ?? [];
        $data['equipment'] = $equipment;

        $character->update(['data' => $data]);

        return redirect()
            ->route('characters.equipment.edit', $character)
            ->with('status', 'Saved.');
    }

    public function purchaseEquipment(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'category' => ['required','in:weapons,armor,gear,other'],
            'item_id' => ['required','string','max:120'],
            'qty' => ['required','integer','min:1','max:99'],
        ]);

        // Same stub catalog as editEquipment (keep identical for now)
        $catalog = [
            'weapons' => [
                ['id'=>'club', 'name'=>'Club', 'cost'=>['sp'=>1], 'type'=>'Weapon', 'image'=>null],
                ['id'=>'dagger', 'name'=>'Dagger', 'cost'=>['gp'=>2], 'type'=>'Weapon', 'image'=>null],
            ],
            'armor' => [
                ['id'=>'leather', 'name'=>'Leather Armor', 'cost'=>['gp'=>10], 'type'=>'Armor', 'image'=>null],
                ['id'=>'shield', 'name'=>'Shield', 'cost'=>['gp'=>10], 'type'=>'Armor', 'image'=>null],
            ],
            'gear' => [
                ['id'=>'rope', 'name'=>'Hempen Rope (50 ft.)', 'cost'=>['gp'=>1], 'type'=>'Gear', 'image'=>null],
                ['id'=>'torch', 'name'=>'Torch', 'cost'=>['cp'=>1], 'type'=>'Gear', 'image'=>null],
            ],
            'other' => [
                ['id'=>'potion_healing', 'name'=>'Potion of Healing', 'cost'=>['gp'=>50], 'type'=>'Other', 'image'=>null],
            ],
        ];

        $item = collect($catalog[$validated['category']])->firstWhere('id', $validated['item_id']);
        if (!$item) {
            return back()->with('status', 'Item not found.');
        }

        $qty = (int)$validated['qty'];

        $data = $character->data ?? [];
        $equipment = $data['equipment'] ?? ['wallet'=>['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0],'inventory'=>[]];

        $wallet = $equipment['wallet'] ?? ['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0];
        $inventory = $equipment['inventory'] ?? [];

        // Cost check (simple: single-currency costs for now)
        $cost = $item['cost'] ?? [];
        $currencyKey = array_key_first($cost);
        $unitCost = $currencyKey ? (int)$cost[$currencyKey] : 0;
        $totalCost = $unitCost * $qty;

        if ($currencyKey && (($wallet[$currencyKey] ?? 0) < $totalCost)) {
            return back()->with('status', 'Not enough currency to purchase.');
        }

        if ($currencyKey) {
            $wallet[$currencyKey] = (int)$wallet[$currencyKey] - $totalCost;
        }

        // Add or increment inventory
        $found = false;
        foreach ($inventory as &$row) {
            if (($row['id'] ?? null) === $item['id']) {
                $row['qty'] = max(1, (int)($row['qty'] ?? 1)) + $qty;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $inventory[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'type' => $item['type'] ?? 'Item',
                'qty' => $qty,
                'equipped' => false,
                'image' => $item['image'] ?? null,
            ];
        }

        $data['equipment'] = [
            'wallet' => $wallet,
            'inventory' => array_values($inventory),
        ];
        $character->update(['data' => $data]);

        return back()->with('status', 'Purchased!');
    }

    public function editSpells(\App\Models\Character $character)
    {
        $spellsState = $character->data['spells'] ?? [
            'known' => [],
            'prepared' => [],
        ];

        // STUB catalog (swap to JSON/DB later)
        $catalog = [
            ['id'=>'blade_ward','name'=>'Blade Ward','level'=>0,'school'=>'Abjuration','cast_time'=>'1 Action','range'=>'Self','duration'=>'1 Round','components'=>'V, S','materials'=>'','desc'=>'You extend your hand and trace a sigil of warding in the air...'],
            ['id'=>'light','name'=>'Light','level'=>0,'school'=>'Evocation','cast_time'=>'1 Action','range'=>'Touch','duration'=>'1 Hour','components'=>'V, M','materials'=>'A firefly or phosphorescent moss','desc'=>'You touch one object that is no larger than 10 feet...'],
            ['id'=>'message','name'=>'Message','level'=>0,'school'=>'Transmutation','cast_time'=>'1 Action','range'=>'120 feet','duration'=>'1 Round','components'=>'V, S, M','materials'=>'A short piece of copper wire','desc'=>'You point your finger toward a creature within range...'],
            ['id'=>'cure_wounds','name'=>'Cure Wounds','level'=>1,'school'=>'Evocation','cast_time'=>'1 Action','range'=>'Touch','duration'=>'Instant','components'=>'V, S','materials'=>'','desc'=>'A creature you touch regains a number of hit points...'],
        ];

        $class = $character->class ?? '—';
        $level = (int)($character->level ?? 1);

        $slots = self::spellSlotsFor($class, $level);
        $maxKnown = self::maxLearnableFromSlots($slots);

        return view('characters.edit_spells', [
            'character' => $character,
            'catalog' => $catalog,
            'spellsState' => $spellsState,
            'magicSummary' => [
                'class' => $class,
                'level' => $level,
                'slots' => $slots,
                'max_known' => $maxKnown,
            ],
        ]);
    }

    public function updateSpells(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'spells' => ['required','array'],
            'spells.known' => ['nullable','array'],
            'spells.prepared' => ['nullable','array'],
            'spells.slots' => ['nullable','array'],
            'spells.max_known' => ['nullable','integer','min:0','max:99'],
        ]);

        $data = $character->data ?? [];
        $data['spells'] = [
            'known' => array_values($validated['spells']['known'] ?? []),
            'prepared' => array_values($validated['spells']['prepared'] ?? []),
            'slots' => $validated['spells']['slots'] ?? [],
            'max_known' => $validated['spells']['max_known'] ?? 0,
        ];

        $character->update(['data' => $data]);

        return back()->with('status', 'Saved.');
    }

    public function learnSpell(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'spell_id' => ['required','string','max:120'],
        ]);

        $data = $character->data ?? [];
        $spells = $data['spells'] ?? ['known'=>[],'prepared'=>[],'slots'=>[],'max_known'=>0];

        $known = $spells['known'] ?? [];
        if (!in_array($validated['spell_id'], $known, true)) {
            $known[] = $validated['spell_id'];
        }

        $spells['known'] = array_values($known);
        $data['spells'] = $spells;

        $character->update(['data' => $data]);

        return back()->with('status', 'Learned spell.');
    }

    private static function spellSlotsFor(string $class, int $level): array
    {
        // Sprint 2: implement level 1 accurately for common classes; expand later.
        $class = strtolower(trim($class));

        // Default: no spellcasting
        $slots = ['cantrips'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0];

        if ($level < 1) $level = 1;

        // Level 1 mappings (5e-ish). You can tune later to match your desktop logic exactly.
        return match ($class) {
            'bard'      => array_merge($slots, ['cantrips'=>2,'1'=>2]),
            'cleric'    => array_merge($slots, ['cantrips'=>3,'1'=>2]),
            'druid'     => array_merge($slots, ['cantrips'=>2,'1'=>2]),
            'sorcerer'  => array_merge($slots, ['cantrips'=>4,'1'=>2]),
            'warlock'   => array_merge($slots, ['cantrips'=>2,'1'=>1]), // pact slots (approx)
            'wizard'    => array_merge($slots, ['cantrips'=>3,'1'=>2]),
            'paladin'   => array_merge($slots, ['cantrips'=>0,'1'=>2]), // half-caster (simplified)
            'ranger'    => array_merge($slots, ['cantrips'=>0,'1'=>2]), // half-caster (simplified)
            default     => $slots,
        };
    }

    public function toggleSpell(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'spell_id' => ['required','string','max:120'],
        ]);

        $spellId = $validated['spell_id'];

        $data = $character->data ?? [];
        $spells = $data['spells'] ?? ['known'=>[],'prepared'=>[]];

        $known = array_values($spells['known'] ?? []);
        $prepared = array_values($spells['prepared'] ?? []);

        $class = $character->class ?? '—';
        $level = (int)($character->level ?? 1);
        $slots = self::spellSlotsFor($class, $level);
        $maxKnown = self::maxLearnableFromSlots($slots);

        $isKnown = in_array($spellId, $known, true);

        if ($isKnown) {
            // Forget: remove from known and prepared
            $known = array_values(array_filter($known, fn($x) => $x !== $spellId));
            $prepared = array_values(array_filter($prepared, fn($x) => $x !== $spellId));
            $msg = 'Forgot spell.';
        } else {
            if (count($known) >= $maxKnown) {
                return back()->with('status', 'You have reached the maximum number of learnable spells for your current spell slots.');
            }
            $known[] = $spellId;
            $msg = 'Learned spell.';
        }

        $spells['known'] = $known;
        $spells['prepared'] = $prepared;
        $data['spells'] = $spells;

        $character->update(['data' => $data]);

        return back()->with('status', $msg);
    }

    private static function maxLearnableFromSlots(array $slots): int
    {
        // Your desktop app uses spell slots as the "max learnable spells".
        // We'll interpret that as the sum of all slots INCLUDING cantrips.
        $total = 0;
        foreach ($slots as $k => $v) {
            $total += (int)($v ?? 0);
        }
        return max(0, $total);
    }

    public function editNpcTraits(\App\Models\Character $character)
    {
        $npc = $character->data['npc_traits'] ?? [
            'profession' => 'Shopkeeper',
            'work_place' => '',
            'family' => '',
            'religion' => '',
            'backstory' => '',
        ];

        // Sprint 2: simple profession list (swap/expand later)
        $professionOptions = [
            'Shopkeeper', 'Blacksmith', 'Innkeeper', 'Guard', 'Noble', 'Farmer',
            'Priest', 'Merchant', 'Sailor', 'Barkeep', 'Scholar', 'Thief',
            'Hunter', 'Healer', 'Bounty Hunter', 'Mercenary',
        ];

        return view('characters.edit_npc_traits', [
            'character' => $character,
            'npc' => $npc,
            'professionOptions' => $professionOptions,
        ]);
    }

    public function updateNpcTraits(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'npc_traits' => ['required','array'],
            'npc_traits.profession' => ['nullable','string','max:80'],
            'npc_traits.work_place' => ['nullable','string','max:120'],
            'npc_traits.family' => ['nullable','string','max:2000'],
            'npc_traits.religion' => ['nullable','string','max:120'],
            'npc_traits.backstory' => ['nullable','string','max:4000'],
        ]);

        $data = $character->data ?? [];
        $data['npc_traits'] = [
            'profession' => $validated['npc_traits']['profession'] ?? null,
            'work_place' => $validated['npc_traits']['work_place'] ?? '',
            'family' => $validated['npc_traits']['family'] ?? '',
            'religion' => $validated['npc_traits']['religion'] ?? '',
            'backstory' => $validated['npc_traits']['backstory'] ?? '',
        ];

        $character->update(['data' => $data]);

        return redirect()
            ->route('characters.npc_traits.edit', $character)
            ->with('status', 'Saved.');
    }

    public function editNotes(\App\Models\Character $character)
    {
        $dmNotes = $character->data['dm_notes'] ?? [
            'notes' => [],          // [{id,title,body,updated_at}]
            'active_id' => null,    // which note is selected
        ];

        // Ensure at least one note exists for usability
        if (empty($dmNotes['notes'])) {
            $id = (string) \Illuminate\Support\Str::uuid();
            $dmNotes['notes'] = [[
                'id' => $id,
                'title' => 'First Note',
                'body' => '',
                'updated_at' => now()->toISOString(),
            ]];
            $dmNotes['active_id'] = $id;

            $data = $character->data ?? [];
            $data['dm_notes'] = $dmNotes;
            $character->update(['data' => $data]);
        }

        return view('characters.edit_notes', [
            'character' => $character,
            'dmNotes' => $dmNotes,
        ]);
    }

    public function updateNotes(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'action' => ['required','in:save,new,select'],
            'active_id' => ['nullable','string','max:80'],
            'title' => ['nullable','string','max:120'],
            'body' => ['nullable','string','max:8000'],
            'select_id' => ['nullable','string','max:80'],
        ]);

        $data = $character->data ?? [];
        $dmNotes = $data['dm_notes'] ?? ['notes'=>[], 'active_id'=>null];

        $notes = $dmNotes['notes'] ?? [];
        $activeId = $dmNotes['active_id'] ?? null;

        if ($validated['action'] === 'new') {
            $id = (string) \Illuminate\Support\Str::uuid();
            $notes[] = [
                'id' => $id,
                'title' => 'New Note',
                'body' => '',
                'updated_at' => now()->toISOString(),
            ];
            $activeId = $id;
        }

        if ($validated['action'] === 'select') {
            $selectId = $validated['select_id'] ?? null;
            if ($selectId && collect($notes)->contains(fn($n) => ($n['id'] ?? null) === $selectId)) {
                $activeId = $selectId;
            }
        }

        if ($validated['action'] === 'save') {
            $activeId = $validated['active_id'] ?? $activeId;

            foreach ($notes as &$n) {
                if (($n['id'] ?? null) === $activeId) {
                    $n['title'] = $validated['title'] ?? ($n['title'] ?? 'Untitled');
                    $n['body'] = $validated['body'] ?? ($n['body'] ?? '');
                    $n['updated_at'] = now()->toISOString();
                    break;
                }
            }
        }

        // Sort newest updated first (easy to navigate)
        usort($notes, function ($a, $b) {
            return strcmp($b['updated_at'] ?? '', $a['updated_at'] ?? '');
        });

        $dmNotes['notes'] = array_values($notes);
        $dmNotes['active_id'] = $activeId;

        $data['dm_notes'] = $dmNotes;
        $character->update(['data' => $data]);

        return redirect()->route('characters.notes.edit', $character)->with('status', 'Saved.');
    }

    public function deleteNote(\Illuminate\Http\Request $request, \App\Models\Character $character)
    {
        $validated = $request->validate([
            'note_id' => ['required','string','max:80'],
        ]);

        $data = $character->data ?? [];
        $dmNotes = $data['dm_notes'] ?? ['notes'=>[], 'active_id'=>null];

        $notes = array_values(array_filter($dmNotes['notes'] ?? [], fn($n) => ($n['id'] ?? null) !== $validated['note_id']));

        // If deleted active, pick first remaining
        $activeId = $dmNotes['active_id'] ?? null;
        if ($activeId === $validated['note_id']) {
            $activeId = $notes[0]['id'] ?? null;
        }

        // Ensure at least one exists
        if (empty($notes)) {
            $id = (string) \Illuminate\Support\Str::uuid();
            $notes = [[
                'id' => $id,
                'title' => 'New Note',
                'body' => '',
                'updated_at' => now()->toISOString(),
            ]];
            $activeId = $id;
        }

        $dmNotes['notes'] = $notes;
        $dmNotes['active_id'] = $activeId;

        $data['dm_notes'] = $dmNotes;
        $character->update(['data' => $data]);

        return redirect()->route('characters.notes.edit', $character)->with('status', 'Deleted.');
    }
}
