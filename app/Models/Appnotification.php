<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appnotification extends Model
{
    use HasFactory;

    protected $table ='app_notification';

    protected $fillable = [
        'title',
        'message',
        'type',
        'is_read',
        'user_id',
        'product_id',
        'project_id',
      
    ];

    public function project()
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }

}
