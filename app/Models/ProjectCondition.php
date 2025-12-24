<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCondition extends Model
{
    use HasFactory;

    protected $table = 'project_conditions';

    public $timestamps = false; // Based on Go struct lacking CreatedAt/UpdatedAt, only ID, ProjectID, Description

    protected $fillable = [
        'project_id',
        'description',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
