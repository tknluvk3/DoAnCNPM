<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\HoaDonController;
use App\Models\Ban;
use App\Http\Controllers\ChiTietHoaDonController;

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

Route::post("/admin/chi-tiet-hoa-don/create-data", [ChiTietHoaDonController::class, "createChiTietHoaDon"]);
Route::get("/admin/chi-tiet-hoa-don/get-data", [ChiTietHoaDonController::class, "getChiTietHoaDon"]);
Route::post("/admin/chi-tiet-hoa-don/update-data", [ChiTietHoaDonController::class, "updateChiTietHoaDon"]);
Route::post("/admin/chi-tiet-hoa-don/delete-data", [ChiTietHoaDonController::class, "deleteChiTietHoaDon"]);
