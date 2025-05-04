<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_dons';
    protected $primaryKey = 'hoa_don_id';
    public $timestamps = true;

    protected $fillable = [
        'ban_id',
        'nhan_vien_id',
        'start_time',
        'end_time',
        'total_hours',
        'charge',
        'total_amount',
        'status',
        'payment_method',
    ];
}
