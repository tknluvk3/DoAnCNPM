<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietHoaDon;

class ChiTietHoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){

    }
    public function createChiTietHoaDon(Request $request){
        $chiTietHoaDon = ChiTietHoaDon::create([
            'dich_vu_id' => $request->dich_vu_id,
            'hoa_don_id' => $request->hoa_don_id,
            'quantity' => $request->so_luong,
            'price' => $request->price,
            'total' => $request->price * $request->so_luong
        ]);
        return response()->json([
            "message" => "Chi tiết hóa đơn đã được tạo thành công",
            "data" => $chiTietHoaDon
        ]);
    }
    public function updateChiTietHoaDon(Request $request){
        $chiTietHoaDon = ChiTietHoaDon::where('chi_tiet_hoa_don_id', $request->id)->update([
            'quantity' => $request->so_luong,
            'total' => $request->price * $request->so_luong
        ]);
        return response()->json([
            "message" => "Chi tiết hóa đơn đã được cập nhật thành công",
            "data" => $chiTietHoaDon
        ]);
    }
    public function deleteChiTietHoaDon(Request $request){
        ChiTietHoaDon::where('chi_tiet_hoa_don_id', $request->chi_tiet_hoa_don_id)->delete();
        return response()->json([
            "message" => "Chi tiết hóa đơn đã được xóa thành công",
        ]);
    }
    public function getChiTietHoaDon(Request $request){
        $data = ChiTietHoaDon::with('dichVu')
            ->where('hoa_don_id', $request->hoa_don_id)
            ->get()
            ->map(function($item) {
                return [
                    'chi_tiet_hoa_don_id' => $item->chi_tiet_hoa_don_id,
                    'dich_vu_id' => $item->dich_vu_id,
                    'dich_vu_name' => $item->dichVu->dich_vu_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total
                ];
            });
        return response()->json([
            "data" => $data
        ]);
    }
}
