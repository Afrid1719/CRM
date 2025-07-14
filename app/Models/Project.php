<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'assigned_user',
        'assigned_client',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    protected function deadline(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date('d/n/Y', strtotime($value))
        );
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'assigned_client');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'related_to_project');
    }
}
