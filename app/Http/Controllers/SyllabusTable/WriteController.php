<?php

namespace App\Http\Controllers\SyllabusTable;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WriteController extends Controller
{
    public function addTopic(Request $request)
    {
        try {
            $validated = $request->validate([
                'session' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^\d{4}-\d{4}$/',
                ],

                'semester' => 'required|integer|min:1|max:8',

                'topic' => 'required|string|max:255',

                'total_lectures' => 'nullable|integer|min:0',

                'author' => 'nullable|string|max:255',

                'description' => 'nullable|string',
            ]);

            Syllabus::create($validated);

            return redirect()
                ->route('syllabus.create')
                ->with('success', 'Topic added successfully');
        } catch (Exception $e) {

            Log::error('Add syllabus error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to add syllabus');
        }
    }
}
