<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'contact_email',
        'contact_phone',
        'max_members',
        'image',
        'status',
    ];

    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}