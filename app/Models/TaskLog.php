<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use HasFactory;

    protected $table = 'task_logs';

    // Disable updated_at karena hanya membutuhkan created_at
    public $timestamps = false;

    protected $dates = ['created_at'];

    protected $fillable = [
        'task_submission_id',
        'user_id',
        'activity',
        'notes',
        'created_at',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function submission()
    {
        return $this->belongsTo(TaskSubmission::class, 'task_submission_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
