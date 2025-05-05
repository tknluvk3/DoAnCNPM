<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_hoa_dons';
    protected $primaryKey = 'chi_tiet_hoa_don_id';
    public $timestamps = true;

    protected $fillable = [
        'hoa_don_id',
        'dich_vu_id',
        'quantity',
        'price',
        'total',
    ];

    public function dichVu() {
        return $this->belongsTo(DichVu::class, 'dich_vu_id', 'dich_vu_id');
    }
}
