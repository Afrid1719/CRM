<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'filename', 'path'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
