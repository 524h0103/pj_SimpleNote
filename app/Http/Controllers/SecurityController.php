<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSecurityRequest;
use App\Services\SecurityService;
use Illuminate\Support\Facades\Auth;
use Exception;

class SecurityController extends Controller
{
    protected $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    public function update(UpdateSecurityRequest $request)
    {
        try {
            $this->securityService->updateAccountPassword(Auth::id(), $request->validated());
            return back()->with('status', 'Cập nhật mật khẩu tài khoản thành công!');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['current_password' => $e->getMessage()]);
        }
    }
}