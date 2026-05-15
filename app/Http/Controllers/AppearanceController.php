<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppearanceRequest;
use App\Services\AppearanceService;
use Illuminate\Support\Facades\Auth;

class AppearanceController extends Controller {
    protected $appearanceService;

    public function __construct(AppearanceService $appearanceService) {
        $this->appearanceService = $appearanceService;
    }

    public function update(UpdateAppearanceRequest $request) {
        // Controller chỉ làm đúng 1 việc: Gọi Service xử lý dữ liệu đã được validate
        $this->appearanceService->updateAppearance(Auth::id(), $request->validated());

        return back()->with('status', 'Đã lưu cấu hình giao diện!');
    }
}