<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'profile_picture',
        'about_me',
        'location',
        'interests',
        'academic',
        'website_url',
        'github_url',
        'linkedin_url',
        'instagram_url',
        'portfolio_url',
        'cv_file',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
