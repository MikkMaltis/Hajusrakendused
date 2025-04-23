<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',  // Make sure this matches your database column
        'email',
        'content',
        'is_approved',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
