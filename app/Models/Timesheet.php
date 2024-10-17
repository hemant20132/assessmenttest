<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Timesheet extends Model
{
    use HasFactory;
    protected $table = 'Timesheet';
    protected $fillable = [
        'task_name',
        'user-id',
        'project_id',
        'date',
        'hours'
    ];

    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class, 'foreign_key');
    }

    public function project(): BelongsTo
    {
    return $this->belongsTo(Project::class, 'foreign_key');
    }

   
}
