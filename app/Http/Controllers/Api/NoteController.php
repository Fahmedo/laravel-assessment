<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the user's notes.
     */
    public function index(Request $request)
    {
        $notes = $request->user()
            ->notes()
            ->latest()
            ->paginate(10);

        return response()->json($notes);
    }

    /**
     * Store a newly created note.
     */
    public function store(StoreNoteRequest $request)
    {
        $note = $request->user()->notes()->create($request->validated());

        return response()->json([
            'message' => 'Note created successfully',
            'note' => $note
        ], 201);
    }

    /**
     * Display the specified note.
     */
    public function show(Request $request, Note $note)
    {
        $this->authorize('view', $note);

        return response()->json([
            'note' => $note
        ]);
    }

    /**
     * Update the specified note.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return response()->json([
            'message' => 'Note updated successfully',
            'note' => $note
        ]);
    }

    /**
     * Remove the specified note.
     */
    public function destroy(Request $request, Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return response()->json([
            'message' => 'Note deleted successfully'
        ]);
    }
}
