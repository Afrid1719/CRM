<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attachments';
    protected $fillable = ['task_id', 'filename', 'path'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    // Add a softDeleted accessor to get all the deleted files and then
    // use its path to cleanup
    // public function getPath(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ()
    //     )
    // }
    public function scopeDeleted(Builder $query)
    {
        $query->whereNull('deleted_at');
    }
}
