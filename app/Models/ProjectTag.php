<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTag extends Pivot
{
    protected $table = 'project_tags';

    public $timestamps = false;

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
