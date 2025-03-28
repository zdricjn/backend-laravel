<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'name', 'description', 'status', 'due_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}