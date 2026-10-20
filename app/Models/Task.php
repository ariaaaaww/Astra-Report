<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'department_id',
        'area_id',
        'due_at',
        'created_by',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class, 'task_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'task_id', 'id');
    }
}
