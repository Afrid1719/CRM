<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'clients';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $casts = ['is_active' => 'boolean'];

    protected $fillable = ['name', 'email', 'vat', 'address'];

    protected $attributes = ['is_active' => true];

    public function scopeActive(Builder $query)
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query)
    {
        $query->where('is_active', false);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'assigned_client');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'related_to_client');
    }
}
