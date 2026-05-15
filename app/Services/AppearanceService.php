<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AppearanceService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function updateAppearance(int $userId, array $data) {
        // Bạn có thể xử lý thêm logic ở đây, ví dụ: 
        // Nếu người dùng chọn màu quá sáng, bạn tự động chỉnh lại...
        
        return $this->userRepository->update($userId, $data);
    }
}