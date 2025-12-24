<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectRole extends Model
{
    use HasFactory;

    protected $table = 'project_roles';

    protected $fillable = [
        'project_id',
        'name',
        'slots_available',
        'description',
    ];

    protected $casts = [
        'slots_available' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function requiredSkills(): HasMany
    {
        return $this->hasMany(ProjectRoleSkill::class);
    }
}
