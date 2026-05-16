<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    //ds gchu + tìm kiếm
    public function index(Request $request)
    {
        $userId = Auth::id();
        $keyword = $request->input('search');
        $notes = $this->noteService->searchNotes($userId, $keyword);

        return view('notes.index', compact('notes'));
    }

    //tạo gchu mới
    public function store(StoreNoteRequest $request)
    {
        $this->noteService->createNote(Auth::id(), $request->validated());

        return redirect()->route('notes.index')->with('status', 'Tạo ghi chú thành công!');
    }

    public function show($id, Request $request)
    {
        try {
            //nếu tạo xong lưu xong lần đầu click từ Dashboard, chưa có pass thì tham số thứ 3 sẽ là null
            $note = $this->noteService->getNoteDetail($id, Auth::id(), $request->input('note_password'));

            return view('notes.show', compact('note'));
        } catch (Exception $e) {
            //phản hồi yc pass
            if ($e->getMessage() === 'password_required') {
                //trở lại dashboard nhưng vẫn có modal nhập pass
                return back()->with('open_lock_modal', $id);
            }

            //check lỗi
            return redirect()->route('notes.index')->with('error_modal', $e->getMessage());
        }
    }

    //xác nhận pass
    public function unlock(Request $request, $id)
    {
        try {
            $this->noteService->getNoteDetail($id, Auth::id(), $request->input('note_password'));
            
            return redirect()->route('notes.show', ['note' => $id, 'note_password' => $request->input('note_password')]);
        } catch (Exception $e) {
            return back()->with('open_lock_modal', $id)->withErrors(['note_password' => 'Mật khẩu ghi chú không chính xác!']);
        }
    }

    //cập nhật
    public function update(UpdateNoteRequest $request, $id)
    {
        try {
            $this->noteService->updateNote($id, Auth::id(), $request->validated());
            return redirect()->route('notes.index')->with('status', 'Cập nhật ghi chú thành công!');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error_action' => $e->getMessage()]);
        }
    }
}