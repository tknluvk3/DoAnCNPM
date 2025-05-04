<template>
    <div class="ban-detail">
        <div v-if="selectedBan">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Chi tiết {{ selectedBan.name }}</h5>
                <div>
                    <button v-if="selectedBan.time === 0" 
                            class="btn btn-primary"
                            @click="datBan">
                        Đặt bàn
                    </button>
                    <button v-else 
                            class="btn btn-success"
                            @click="thanhToan">
                        Thanh toán
                    </button>
                </div>
            </div>
            
            <!-- Thông tin bàn -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3">Thông tin bàn</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Trạng thái:</strong>
                                <span :class="selectedBan.time > 0 ? 'text-success' : 'text-danger'">
                                    {{ selectedBan.time > 0 ? 'Đang sử dụng' : 'Trống' }}
                                </span>
                            </p>
                            <p class="mb-2" v-if="selectedBan.time > 0">
                                <strong>Thời gian:</strong> {{ selectedBan.time }} phút
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Giá:</strong> {{ formatPrice(selectedBan.price) }}/giờ
                            </p>
                            <p class="mb-2" v-if="selectedBan.time > 0">
                                <strong>Tiền giờ:</strong> {{ formatPrice(tinhTienGio()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dịch vụ đã gọi -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-subtitle mb-0">Dịch vụ đã gọi</h6>
                        <button class="btn btn-primary btn-sm" @click="themDichVu" v-if="selectedBan.time > 0">
                            <i class="bx bx-plus"></i> Thêm dịch vụ
                        </button>
                    </div>
                    
                    <div class="table-responsive" v-if="selectedBan.dichvu && selectedBan.dichvu.length > 0">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dv in selectedBan.dichvu" :key="dv.id">
                                    <td>{{ dv.name }}</td>
                                    <td class="text-center">
                                        <div class="input-group input-group-sm justify-content-center">
                                            <button class="btn btn-outline-secondary btn-sm" @click="giamSoLuong(dv)">-</button>
                                            <input type="number" class="form-control form-control-sm text-center" style="width: 60px"
                                                v-model="dv.quantity" min="1">
                                            <button class="btn btn-outline-secondary btn-sm" @click="tangSoLuong(dv)">+</button>
                                        </div>
                                    </td>
                                    <td class="text-end">{{ formatPrice(dv.price) }}</td>
                                    <td class="text-end">{{ formatPrice(dv.price * dv.quantity) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" @click="xoaDichVu(dv)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center text-muted py-3">
                        Chưa có dịch vụ nào được gọi
                    </div>
                </div>
            </div>

            <!-- Tổng tiền -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Tiền giờ:</strong> {{ formatPrice(tinhTienGio()) }}</p>
                            <p class="mb-2"><strong>Tiền dịch vụ:</strong> {{ formatPrice(tinhTienDichVu()) }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="mb-0">Tổng tiền: {{ formatPrice(calculateTotal()) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center text-muted py-5">
            Chọn một bàn để xem chi tiết
        </div>
    </div>
</template>

<script>
export default {
    name: 'BanDetail',
    props: {
        selectedBan: {
            type: Object,
            default: null
        }
    },
    methods: {
        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(price);
        },
        tinhTienGio() {
            return this.selectedBan.time * (this.selectedBan.price / 60);
        },
        tinhTienDichVu() {
            return this.selectedBan.dichvu.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        },
        calculateTotal() {
            return this.tinhTienGio() + this.tinhTienDichVu();
        },
        datBan() {
            // Xử lý logic đặt bàn ở đây
            this.$emit('dat-ban', this.selectedBan);
        },
        thanhToan() {
            // Xử lý logic thanh toán ở đây
        },
        themDichVu() {
            // Xử lý logic thêm dịch vụ ở đây
        },
        giamSoLuong(dv) {
            if (dv.quantity > 1) {
                dv.quantity--;
            }
        },
        tangSoLuong(dv) {
            dv.quantity++;
        },
        xoaDichVu(dv) {
            // Xử lý logic xóa dịch vụ ở đây
        }
    }
}
</script>

<style scoped>
.ban-detail {
    min-height: 400px;
}
</style>