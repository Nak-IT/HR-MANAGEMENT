<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function show()
    {
        return view('skills.skill');
    }

    /**
     * Get all skills.
     */
    public function getSkills()
    {
        $skills = Skill::all();
        return response()->json($skills);
    }

    /**
     * Add a new skill.
     */
    public function addSkill(Request $request)
    {
        $request->validate([
            'SkillName' => 'required|string|max:100',
        ]);

        $skill = Skill::create([
            'SkillName' => $request->SkillName,
        ]);

        return response()->json(['success' => 'Skill saved successfully.', 'skill' => $skill]);
    }

    /**
     * Get a skill by ID.
     */
    public function getById($id)
    {
        $skill = Skill::find($id);
        
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }
        
        return response()->json($skill);
    }

    /**
     * Update a skill.
     */
    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::find($id);
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        $request->validate([
            'SkillName' => 'required|string|max:100',
        ]);

        $skill->update([
            'SkillName' => $request->SkillName,
        ]);

        return response()->json(['success' => 'Skill updated successfully.', 'skill' => $skill]);
    }

    /**
     * Delete a skill.
     */
    public function deleteSkill($id)
    {
        $skill = Skill::find($id);
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        $skill->delete();
        return response()->json(['success' => 'Skill deleted successfully']);
    }
}
