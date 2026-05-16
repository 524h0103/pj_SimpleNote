<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserInfoService
{
    protected $userRepository;
    protected $imageService;

    public function __construct(UserRepository $userRepository, ImageService $imageService)
    {
        $this->userRepository = $userRepository;
        $this->imageService = $imageService;
    }

    public function updateInfo(int $userId, array $data)
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) return null;

        //up avt mới
        if (isset($data['avatar'])) {
            //xóa img avt cũ trong folder pub
            if ($user->avatar) {
                $this->imageService->deleteImage($user->avatar);
            }

            //upload img avt mới
            $avatarPath = $this->imageService->uploadImage($data['avatar'], 'avatars');
            
            //gán path vào data để bỏ vào folder pub
            $data['avatar'] = $avatarPath;
        }

        $user->fill($data);
        return $this->userRepository->save($user);
    }
}