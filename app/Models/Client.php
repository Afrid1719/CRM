<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'clients';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = ['name', 'email', 'vat', 'address'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'assigned_client');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'related_to_client');
    }
}
