<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Services\UserInfoService;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    protected $userInfoService;

    public function __construct(UserInfoService $userInfoService)
    {
        $this->userInfoService = $userInfoService;
    }

    public function update(UpdateUserInfoRequest $request)
    {
        $result = $this->userInfoService->updateInfo(Auth::id(), $request->validated());

        if (!$result) {
            return back()->with('error_modal', 'Không tìm thấy thông tin tài khoản!');
        }

        return back()->with('status', 'Cập nhật thông tin cá nhân thành công!');
    }
}