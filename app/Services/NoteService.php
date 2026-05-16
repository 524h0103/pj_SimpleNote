<?php

namespace App\Services;

use App\Repositories\NoteRepository;
use App\Models\Note;
use Exception;
use Illuminate\Support\Facades\Hash;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getUserNotes(int $userId)
    {
        return $this->noteRepository->getByUserId($userId);
    }

    public function searchNotes(int $userId, ?string $keyword)
    {
        if (empty(trim($keyword))) {
            return $this->noteRepository->getByUserId($userId);
        }
        return $this->noteRepository->search($userId, trim($keyword));
    }

    public function getNotesByLabel(int $labelId, int $userId)
    {
        return $this->noteRepository->getByLabelId($labelId, $userId);
    }

    //bóc ra 1 gchu cụ thể
    public function getNoteDetail(int $id, int $userId, ?string $confirmPassword = null)
    {
        //tránh xem chéo note nên cần truyền thêm id vào để check
        $note = $this->noteRepository->findById($id, $userId);

        if (!$note) {
            throw new Exception("Ghi chú không tồn tại hoặc bạn không có quyền truy cập.");
        }

        //khóa note
        if ($note->is_locked) {
            if (!$confirmPassword || !Hash::check($confirmPassword, $note->note_password)) {
                throw new Exception("password_required"); // Bắn tín hiệu bắt Frontend hiện Modal nhập pass
            }
        }

        return $note;
    }

    public function createNote(int $userId, array $data)
    {
        $data['user_id'] = $userId;
        $data['note_color'] = $data['note_color'] ?? '#ffffff';
        return $this->noteRepository->create($data);
    }

    //cập nhật gchu
    public function updateNote(int $id, int $userId, array $data)
    {
        // khi mở modal cập nhật/xóa sửa, phải check note trc
        $note = $this->noteRepository->findById($id, $userId);
        if (!$note) {
            throw new Exception("Ghi chú không tồn tại.");
        }

        //xử lý bật/tắt pass note
        if (isset($data['action_password'])) {
            if ($data['action_password'] === 'set') {
                $note->note_password = Hash::make($data['note_password']);
                $note->is_locked = true;
            } elseif ($data['action_password'] === 'unset') {
                //muốn tắt pass thì phải nhập lại pass để xác nhận
                if (!isset($data['current_note_password']) || !Hash::check($data['current_note_password'], $note->note_password)) {
                    throw new Exception("Mật khẩu xác nhận để hủy bảo vệ không chính xác!");
                }
                $note->note_password = null;
                $note->is_locked = false;
            }
        }

        //note color
        $note->title = $data['title'] ?? $note->title;
        $note->content = $data['content'] ?? $note->content;
        $note->note_color = $data['note_color'] ?? $note->note_color;

        //ghim
        if (isset($data['is_pinned'])) {
            $note->is_pinned = (bool)$data['is_pinned'];
            $note->pinned_at = $note->is_pinned ? now() : null;
        }

        return $this->noteRepository->save($note);
    }
}