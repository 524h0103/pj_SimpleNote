<?php

namespace App\Services;

use App\Repositories\NoteRepository;
use App\Models\Note;
use Exception;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /*ds gchu*/
    public function getUserNotes(int $userId)
    {
        return $this->noteRepository->getByUserId($userId);
    }

    /*tìm kiếm gchu*/
    public function searchNotes(int $userId, ?string $keyword)
    {
        if (empty(trim($keyword))) {
            return $this->noteRepository->getByUserId($userId);
        }

        return $this->noteRepository->search($userId, trim($keyword));
    }

    /*bóc ra 1 gchu cụ thể*/
    public function getNoteDetail(int $id, int $userId)
    {
        $note = $this->noteRepository->findById($id);

        if (!$note) {
            return null;
        }

        if ($note->user_id !== $userId) {
            throw new Exception("Bạn không có quyền truy cập ghi chú này.");
        }

        return $note;
    }

    /*tạo gchu mới*/
    public function createNote(int $userId, array $data)
    {
        $data['user_id'] = $userId;
        return $this->noteRepository->create($data);
    }

    /*cập nhật gchu*/
    public function updateNote(int $id, int $userId, array $data)
    {
        $note = $this->getNoteDetail($id, $userId);
        
        if (!$note) {
            return null;
        }

        $note->fill($data);
        return $this->noteRepository->save($note);
    }
}