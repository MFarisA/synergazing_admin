<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRequiredSkill extends Pivot
{
    protected $table = 'project_required_skills';

    public $timestamps = false;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
