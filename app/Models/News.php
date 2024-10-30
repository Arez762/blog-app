<?php

namespace App\Models;

use Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'category_id',
        'user_id',
        'upload_time',
        'addImage',
        'status',
    ];

    protected $casts = [
        'addImage' => 'array', // Casts addImage to an array to store multiple images
        'upload_time' => 'datetime', // Casts upload_time to a datetime
    ];

    // Automatically set the slug when creating or updating the title
    public static function boot()
    {
        parent::boot();

        static::saving(function ($news) {
            $news->slug = Str::slug($news->title);
        });
    }

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
