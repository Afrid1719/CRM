<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'app_users';
    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = ['name', 'email', 'avatar'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->avatar) {
                $model->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($model->name) . '&size=100&background=random';
            }
        });
    }
}
