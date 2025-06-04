<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pest\Arch\Objects\FunctionDescription;

class Comment extends Model
{
    use HasUlids, HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "comment",
        "article_id",
        "user_id"
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
