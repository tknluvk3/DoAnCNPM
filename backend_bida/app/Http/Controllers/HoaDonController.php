<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\Ban;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createHoaDon(Request $request)
    {
        $defaultNhanVienId = 1; // ID của nhân viên mặc định
        $data = HoaDon::create([
            'ban_id' => $request->ban_id,
            'nhan_vien_id' => $request->nhan_vien_id ?? $defaultNhanVienId, // Sử dụng giá trị mặc định nếu không có
            'start_time' => $request->start_time ?? now(), // Thời gian bắt đầu mặc định là hiện tại
            'end_time' => $request->end_time,
            'total_hours' => $request->total_hours ?? 0, // Mặc định là 0 giờ
            'total_amount' => $request->total_amount ?? 0, // Mặc định là 0
            'status' => $request->status ?? 1, // Mặc định là trạng thái 1
            'payment_method' => $request->payment_method ?? 'cash', // Mặc định là thanh toán bằng tiền mặt
        ]);

        return response()->json([
            'message' => 'Hóa đơn đã được tạo thành công',
            'data' => $data,
        ]);
    }
    public function getHoaDon(Request $request)
    {
        $data = HoaDon::All();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function updateHoaDon(Request $request)
    {
        HoaDon::where('hoa_don_id', $request->hoa_don_id)->update([

            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_hours' => $request->total_hours,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
        ]);
        return response()->json([
            'message' => 'Hóa đơn đã được cập nhật thành công',
            'status' => 1,
        ]);
    }
    public function deleteHoaDon(Request $request)
    {
        HoaDon::where('hoa_don_id', $request->hoa_don_id)->delete();
        return response()->json([
            'message' => 'Hóa đơn đã được xóa thành công',
            'status' => 1,
        ]);
    }
    public function updateStatus(Request $request)
    {
        $data = Ban::find($request->ban_id);

        if (!$data) {
            return response()->json(['message' => 'Không tìm thấy bàn'], 404);
        }

        $data->status = $request->status;
        $data->save();

        return response()->json(['message' => 'Cập nhật trạng thái bàn thành công']);
    }
    public function updateEndTime(Request $request)
    {
        $data = HoaDon::find($request->hoa_don_id);
        if ($data) {
            $data->end_time = $request->end_time;
            $data->save();
            return response()->json(['message' => 'Cập nhật end_time thành công']);
        }
        return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
    }
    public function getBillByBanId(Request $request)
    {
        $ban_id = $request->ban_id;
        $bill = \App\Models\HoaDon::where('ban_id', $ban_id)
            ->where('status', 'chưa thanh toán')
            ->orderBy('hoa_don_id', 'desc')
            ->first();

        return response()->json(['data' => $bill ? [$bill] : []]);
    }
}
