<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidRequest extends Model
{
    use HasFactory;
    protected $table ='bid_requests';
    protected $fillable = [
        'user_id',
        'project_id',
        'auction_type_id',
        'deposit_amount',
        'status'
       
    ];
    public function auctiontype()
    {
        return $this->belongsTo(Auctiontype::class,'auction_type_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
   

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

}
