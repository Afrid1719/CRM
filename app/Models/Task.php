<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
        'for_client',
        'related_to_project',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'related_to_project');
    }

    public function user()
    {
        return $this->belongsTo(AppUser::class, 'assigned_to');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'for_client');
    }
}
