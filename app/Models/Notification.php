<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table ='notifications';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'title',
        'message',
        'type',
        'is_read',
        'product_id',
        'project_id',
      
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'sender_id');
    }

    
    public function projects()
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

}
