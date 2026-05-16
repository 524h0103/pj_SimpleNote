<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;

class SecurityService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateAccountPassword(int $userId, array $data)
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new Exception("Tài khoản không tồn tại.");
        }

        //reset mk sau khi đã đn sẽ yêu cầu pass tk
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new Exception("Mật khẩu tài khoản hiện tại không đúng!");
        }

        $user->password = Hash::make($data['new_password']);
        return $this->userRepository->save($user);
    }
}