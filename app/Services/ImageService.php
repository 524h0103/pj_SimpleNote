<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function uploadImage(UploadedFile $file, string $folder = 'notes'): string
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        $destPath = public_path('uploads/' . $folder);        
        $file->move($destPath, $fileName);
        
        // 4. Trả về chuỗi đường dẫn sạch sẽ để các Service khác nạp vào DB
        return 'uploads/' . $folder . '/' . $fileName;
    }

    public function deleteImage(?string $path): bool
    {
        //check path & file trên ổ cứng
        if ($path && file_exists(public_path($path))) {
            return unlink(public_path($path));
        }
        
        return false;
    }
}