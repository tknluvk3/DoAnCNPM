<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\HoaDonController;
use App\Models\Ban;
use App\Http\Controllers\ChiTietHoaDonController;
use App\Http\Controllers\NhanVienController;
Route::post("/admin/ban/create-data", [BanController::class, "createBan"]);
Route::get("/admin/ban/get-data", [BanController::class, "getBan"]);
Route::post("/admin/ban/update-data", [BanController::class, "updateBan"]);
Route::post("/admin/ban/delete-data", [BanController::class, "deleteBan"]);

Route::post("/admin/dich-vu/create-data", action: [DichVuController::class, "createDichVu"]);
Route::get("/admin/dich-vu/get-data", [DichVuController::class, "getDichVu"]);
Route::post("/admin/dich-vu/update-data", [DichVuController::class, "updateDichVu"]);
Route::post("/admin/dich-vu/delete-data", [DichVuController::class, "deleteDichVu"]);

Route::post("/admin/hoa-don/create-data", [HoaDonController::class, "createHoaDon"]);
Route::get("/admin/hoa-don/get-data", [HoaDonController::class, "getHoaDon"]);
Route::post("/admin/hoa-don/update-data", [HoaDonController::class, "updateHoaDon"]);
Route::post("/admin/hoa-don/delete-data", [HoaDonController::class, "deleteHoaDon"]);
Route::post("/admin/hoa-don/update-status", [HoaDonController::class, "updateStatus"]);
Route::post("/admin/hoa-don/update-end-time", [HoaDonController::class, "updateEndTime"]);
Route::get("/admin/hoa-don/get-bill-by-ban-id", [HoaDonController::class, "getBillByBanId"]);

Route::post("/admin/chi-tiet-hoa-don/create-data", [ChiTietHoaDonController::class, "createChiTietHoaDon"]);
Route::get("/admin/chi-tiet-hoa-don/get-data", [ChiTietHoaDonController::class, "getChiTietHoaDon"]);
Route::post("/admin/chi-tiet-hoa-don/update-data", [ChiTietHoaDonController::class, "updateChiTietHoaDon"]);
Route::post("/admin/chi-tiet-hoa-don/delete-data", [ChiTietHoaDonController::class, "deleteChiTietHoaDon"]);

Route::post("/admin/nhan-vien/create-data", [NhanVienController::class, "createNhanVien"]);
Route::get("/admin/nhan-vien/get-data", [NhanVienController::class, "getNhanVien"]);
Route::post("/admin/nhan-vien/update-data", [NhanVienController::class, "updateNhanVien"]);
Route::post("/admin/nhan-vien/delete-data", [NhanVienController::class, "deleteNhanVien"]);
Route::post('/login', [NhanVienController::class, 'login']);

