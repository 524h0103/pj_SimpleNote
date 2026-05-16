<?php

namespace App\Repositories;

use App\Models\Label;

class LabelRepository
{
    public function getByUserId(int $userId)
    {
        return Label::where('user_id', $userId)->get();
    }

    public function findById(int $id, int $userId): ?Label
    {
        return Label::where('id', $id)->where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Label::create($data);
    }

    public function save(Label $label): Label
    {
        $label->save();
        return $label;
    }

    public function delete(Label $label): bool
    {
        return $label->delete();
    }
}