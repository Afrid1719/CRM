<?php

namespace App\Models;

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

    public function client()
    {
        return $this->belongsTo(Client::class, 'assigned_client');
    }

    public function user()
    {
        return $this->belongsTo(AppUser::class, 'assigned_user');
    }
}
