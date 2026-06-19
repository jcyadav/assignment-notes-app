<?php

namespace App\Repositories\Contracts;

use App\Models\Note;

interface NoteRepositoryInterface
{
    public function getAll(int $perPage = 10);

    public function findById(int $id): ?Note;

    public function create(array $data): Note;

    public function update(Note $note, array $data): bool;

    public function delete(Note $note): bool;
}