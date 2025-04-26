<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        // I did not add "status" field for security reasons.
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'image'
    ];

    protected $with = ['comments'];

    protected $appends = [
        'image_url'
    ];

    // Get image url value using image value.
    public function getImageUrlAttribute() {
        return $this->image ? asset('posts') . '/' . $this->image : null;
    }


    // Global scpoe to check post status
    protected static function booted(): void {
        static::addGlobalScope('is_active', function(Builder $builder) {
            $builder->whereStatus('active');
        });
    }

    // Build one to many relationship with comments table.
    public function comments() {
        return $this->hasMany(Comment::class);
    }

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
