<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'creator_id',
        'status',
        'completion_stage',
        'title',
        'project_type',
        'description',
        'picture_url',
        'duration',
        'total_team',
        'start_date',
        'end_date',
        'location',
        'budget',
        'registration_deadline',
        'time_commitment',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'completion_stage' => 'integer',
        'total_team' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(ProjectCondition::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(ProjectRole::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ProjectApplication::class);
    }

    // Direct Many-to-Many relationships for ease of access
    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class, 'project_benefits');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'project_tags');
    }

    // Relationships to Pivot/Detail Models (matching Go structs)
    public function projectBenefits(): HasMany
    {
        return $this->hasMany(ProjectBenefit::class);
    }

    public function projectTags(): HasMany
    {
        return $this->hasMany(ProjectTag::class);
    }

    public function projectTimelines(): HasMany
    {
        return $this->hasMany(ProjectTimeline::class);
    }

    public function requiredSkills(): HasMany
    {
        return $this->hasMany(ProjectRequiredSkill::class);
    }
}
