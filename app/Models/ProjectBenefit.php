<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectBenefit extends Pivot
{
    protected $table = 'project_benefits';

    public $timestamps = false;

    public function benefit(): BelongsTo
    {
        return $this->belongsTo(Benefit::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
