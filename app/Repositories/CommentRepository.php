<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function create(array $data)
    {
        return Comment::create($data);
    }
    public function getAll(array $where)
    {
        return Comment::where($where)->get();
    }
    public function getById($id)
    {
        return Comment::where("id", $id)->first();
    }
    public function update(array $where, array $data)
    {
        return Comment::where($where)->update($data);
    }
    public function delete($id)
    {
        return Comment::where("id", $id)->delete();
    }
}
