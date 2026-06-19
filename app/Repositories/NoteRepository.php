<?php

namespace App\Repositories;

use App\Models\Note;
use App\Repositories\Contracts\NoteRepositoryInterface;

class NoteRepository implements NoteRepositoryInterface
{
    public function getAll(int $perPage = 10)
    {
        return Note::latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Note
    {
        return Note::find($id);
    }

    public function create(array $data): Note
    {
        return Note::create($data);
    }

    public function update(Note $note, array $data): bool
    {
        return $note->update($data);
    }

    public function delete(Note $note): bool
    {
        return $note->delete();
    }
}