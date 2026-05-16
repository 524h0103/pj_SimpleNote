<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AppearanceService {
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function updateAppearance(int $userId, array $data) {
        $user = $this->userRepository->findById($userId);
        if (!$user) return null;

        $user->theme = $data['theme'];
        $user->font_size = $data['font_size'];
        
        return $this->userRepository->save($user);
    }
}