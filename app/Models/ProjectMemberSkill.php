<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMemberSkill extends Pivot
{
    protected $table = 'project_member_skills';

    public $timestamps = false;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function projectMember(): BelongsTo
    {
        return $this->belongsTo(ProjectMember::class);
    }
}
