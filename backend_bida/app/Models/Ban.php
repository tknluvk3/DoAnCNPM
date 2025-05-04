<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ban extends Model
{
    use HasFactory;
    protected $table = 'bans';
    protected $primaryKey = 'ban_id';
    public $timestamps = true;
    protected $fillable = [
        'ban_name',
        'status',
        'price_per_hour',
    ];
}
