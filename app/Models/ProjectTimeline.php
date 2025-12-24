<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTimeline extends Pivot
{
    protected $table = 'project_timelines';

    public $timestamps = false;

    // project_id, timeline_id, timeline_status

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
