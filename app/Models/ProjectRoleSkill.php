<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRoleSkill extends Pivot
{
    protected $table = 'project_role_skills';

    public $timestamps = false;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function projectRole(): BelongsTo
    {
        return $this->belongsTo(ProjectRole::class);
    }
}
