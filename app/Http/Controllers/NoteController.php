<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    //ds gchu + chức năng tìm kiếm
    public function index(Request $request)
    {
        $userId = Auth::id();
        $keyword = $request->input('search');
        $notes = $this->noteService->searchNotes($userId, $keyword);

        return view('notes.index', compact('notes'));
    }

    public function store(StoreNoteRequest $request)
    {
        $this->noteService->createNote(Auth::id(), $request->validated());

        return redirect()->route('notes.index')->with('status', 'Tạo ghi chú thành công!');
    }

    //xem chi tiết gchu
    public function show($id)
    {
        $note = $this->noteService->getNoteDetail($id, Auth::id());

        if (!$note) {
            return back()->with('error_modal', 'Không tìm thấy ghi chú này!');
        }

        return view('notes.dashboard', compact('note'));
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        $note = $this->noteService->updateNote($id, Auth::id(), $request->validated());

        if (!$note) {
            return back()->with('error_modal', 'Không thể cập nhật do ghi chú không tồn tại!');
        }

        return redirect()->route('notes.index')->with('status', 'Cập nhật ghi chú thành công!');
    }
}