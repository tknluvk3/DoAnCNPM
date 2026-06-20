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
    /**
     * Lấy danh sách tất cả dịch vụ
     * 
     * @param Request $request Request từ client
     * @return JsonResponse Trả về danh sách dịch vụ dạng JSON
     */
    public function getDichVu(Request $request){
        $data = DichVu::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Tạo mới một dịch vụ
     * 
     * @param Request $request Chứa thông tin dịch vụ cần tạo
     * @return JsonResponse Trả về thông báo kết quả
     */
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

    /**
     * Cập nhật thông tin dịch vụ
     * 
     * @param Request $request Chứa thông tin dịch vụ cần cập nhật
     * @return JsonResponse Trả về thông báo kết quả
     */
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

    /**
     * Xóa một dịch vụ
     * 
     * @param Request $request Chứa ID dịch vụ cần xóa
     * @return JsonResponse Trả về thông báo kết quả
     */
    public function deleteDichVu(Request $request){
        DichVu::where('dich_vu_id', $request->dich_vu_id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Xóa dịch vụ thành công!',
        ]);
    }

}
