<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\DichVuController;

Route::post("/admin/ban/create-data", [BanController::class, "createBan"]);
Route::get("/admin/ban/get-data", [BanController::class, "getBan"]);
Route::post("/admin/ban/update-data", [BanController::class, "updateBan"]);
Route::post("/admin/ban/delete-data", [BanController::class, "deleteBan"]);

Route::post("/admin/dich-vu/create-data", action: [DichVuController::class, "createDichVu"]);
Route::get("/admin/dich-vu/get-data", [DichVuController::class, "getDichVu"]);
Route::post("/admin/dich-vu/update-data", [DichVuController::class, "updateDichVu"]);
Route::post("/admin/dich-vu/delete-data", [DichVuController::class, "deleteDichVu"]);
