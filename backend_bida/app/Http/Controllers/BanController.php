<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ban;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Get the ban data.
     */
    public function getBan(Request $request)
    {
        $data = Ban::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createBan(Request $request)
    {
        Ban::create([
            'ban_id' => $request->ban_id,
            'ban_name' => $request->ban_name,
            'loai_ban' => $request->loai_ban,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Bàn đã được tạo thành công',
        ]);
    }
    public function updateBan(Request $request)
    {
        Ban::where('ban_id', $request->ban_id)->update([
            'ban_name' => $request->ban_name,
            'loai_ban' => $request->loai_ban,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Bàn đã được cập nhật thành công',
            'status' => 1,
        ]);
    }
    public function deleteBan(Request $request)
    {
        Ban::where('ban_id', $request->ban_id)->delete();
        return response()->json([
            'message' => 'Bàn đã được xóa thành công',
            'status' => 1,
        ]);
    }
}
