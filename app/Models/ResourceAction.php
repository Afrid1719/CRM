<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceAction extends Model
{
    use HasFactory;

    protected $table = 'resource_actions';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'value'
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }
}
