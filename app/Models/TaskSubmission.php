<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;

    protected $table = 'task_submissions';

    protected $fillable = [
        'task_id',
        'dealer_id',
        'drive_link',
        'status',
        'created_at',
        'updated_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'task_submission_id', 'id');
    }
}
