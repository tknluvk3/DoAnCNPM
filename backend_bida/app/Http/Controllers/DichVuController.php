<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DichVu;

class DichVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getDichVu(Request $request){
        $data = DichVu::all();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function createDichVu(Request $request){
        DichVu::create([
            'dich_vu_name' => $request->dich_vu_name,
            'loai_dich_vu' => $request->loai_dich_vu,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'Tạo dịch vụ thành công!',
        ]);
    }
    public function updateDichVu(Request $request){
        DichVu::where('dich_vu_id', $request->dich_vu_id)->update([
            'dich_vu_name' => $request->dich_vu_name,
            'loai_dich_vu' => $request->loai_dich_vu,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật dịch vụ thành công!',
        ]);
    }
    public function deleteDichVu(Request $request){
        DichVu::where('dich_vu_id', $request->dich_vu_id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Xóa dịch vụ thành công!',
        ]);
    }

}
