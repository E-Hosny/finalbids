<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'subject_id',
        'phone',
        'message'
    ];

    public function subject(){
        return $this->belongsTo(ContactUsSubject::class, 'subject_id');
    }
}