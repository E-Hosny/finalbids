<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartBid extends Model
{
    use HasFactory;
    protected $table ='start_bid';
    protected $fillable = [
       'product_id',
       'project_id',
       'status',
    ];
}
