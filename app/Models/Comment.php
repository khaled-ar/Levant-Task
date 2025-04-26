<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'reply'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = ['user'];

    // Build belongs to one with users table.
    public function user() {
        return $this->belongsTo(User::class)
            ->select([
                'id',
                'name',
                'image',
            ]);
    }
}
