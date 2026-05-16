<?php

namespace App\Repositories;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements INoteRepository
{
    public function findById(int $id, int $userId): ?Note
    {
        return Note::where('id', $id)->where('user_id', $userId)->first();
    }

    //lấy data
    public function getByUserId(int $userId)
    {
        return Note::where('user_id', $userId)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    //tạo gchu mới etc
    public function create(array $data)
    {
        return Note::create($data);
    }

    public function save(Note $note): Note
    {
        $note->save();
        return $note;
    }

    public function delete(Note $note): bool
    {
        return $note->delete();
    }

    public function search(int $userId, string $keyword)
    {
        return Note::query()
            ->where('user_id', $userId)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('content', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function getByLabelId(int $labelId, int $userId)
    {
        return Note::where('user_id', $userId)
            ->whereHas('labels', function ($query) use ($labelId) {
                $query->where('labels.id', $labelId);
            })
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
