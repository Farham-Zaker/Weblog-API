<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function create(array $data)
    {
        return Comment::create($data);
    }
    public function getById($id)
    {
        return Comment::where("id", $id)->first();
    }
}
