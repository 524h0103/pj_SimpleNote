<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function uploadImage(UploadedFile $file): string
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        $destPath = public_path('uploads/notes');
        
        $file->move($destPath, $fileName);
        
        // 4. Trả về đường dẫn ngắn gọn để lưu vào Database (ví dụ: uploads/notes/12345.jpg)
        return 'uploads/notes/' . $fileName;
    }

    public function deleteImage(?string $path): bool
    {
        if ($path && file_exists(public_path($path))) {
            return unlink(public_path($path));
        }
        
        return false;
    }
}