<template>
    <div class="ban-detail">
        <div class="card" style="height: 80vh;">
            <div class="card-header bg-white">
                <h4 class="mb-0">Thông tin Bill</h4>
                <div class="text-muted">
                    <p class="mb-1">Bàn: {{ selectedBan.name }} (ID: {{ selectedBan.id }})</p>
                    <p class="mb-0" v-if="hoaDon">ID Hóa đơn: {{ hoaDon.hoa_don_id }}</p>
                    <p class="mb-0" v-else>Chưa có hóa đơn</p>
                </div>
            </div>
            <div class="card-body">
                <div v-if="chiTietHoaDon.length === 0" class="text-center text-muted">
                    <p>Chưa có dịch vụ nào trong hóa đơn</p>
                </div>
                <div v-else>
                    <!-- Hiển thị tiền giờ chơi -->
                    <div v-for="item in chiTietHoaDon" :key="item.id"
                        class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                        <div>
                            <h6 class="mb-1">{{ item.dich_vu_name || 'Món #' + item.dich_vu_id }}</h6>
                            <small class="text-muted d-block">Đơn giá: {{ item.price?.toLocaleString() }}đ</small>
                            <small class="text-muted d-block">Thời gian: {{ formatTime(hoaDon?.start_time) }}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary btn-sm me-2" @click="decreaseQuantity(item)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="mx-2">{{ item.quantity }}</span>
                            <button class="btn btn-outline-primary btn-sm me-2" @click="increaseQuantity(item)">
                                <i class="fas fa-plus"></i>
                            </button>
                            <span class="text-primary fw-bold">{{ (item.price * item.quantity).toLocaleString() }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <h5 class="me-3">Tổng tiền:</h5>
                    <h3>{{ calculateTotal().toLocaleString() }}đ</h3>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-primary me-2">
                        <h4><i class="fa-solid fa-print"></i> In tạm tính</h4>
                    </button>
                    <button class="btn btn-primary py-2 d-grid col-6" @click="payBill">
                        <h4><i class="fa-solid fa-dollar-sign"></i> Thanh toán (F9)</h4>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        selectedBan: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            hoaDon: null,
            chiTietHoaDon: []
        };
    },
    watch: {
        'selectedBan.id': {
            immediate: true,
            handler(newId) {
                if (newId) {
                    this.getHoaDonDetail(); // Lấy thông tin hóa đơn khi bàn được chọn
                }
            }
        }
    },
    methods: {
        formatTime(time) {
            if (!time) return '';
            const date = new Date(time);
            return date.toLocaleString('vi-VN');
        },
        getHoaDonDetail() {
            if (!this.selectedBan) return;
            
            // Lấy hóa đơn chưa thanh toán của bàn
            axios.get(`http://127.0.0.1:8000/api/admin/hoa-don/get-data?ban_id=${this.selectedBan.id}&trang_thai=1`)
                .then((res) => {
                    console.log('Response from get-data:', res.data.data);
                    if (res.data.data && res.data.data.length > 0) {
                        // Tìm hóa đơn của đúng bàn đang xem
                        const currentHoaDon = res.data.data.find(hd => hd.ban_id === this.selectedBan.id);
                        if (currentHoaDon) {
                            this.hoaDon = currentHoaDon;
                            console.log('Current hoa don for ban', this.selectedBan.id, ':', this.hoaDon);
                            this.getChiTietHoaDon();
                        } else {
                            console.log('No active bill found for ban', this.selectedBan.id);
                            this.hoaDon = null;
                            this.chiTietHoaDon = [];
                        }
                    } else {
                        this.hoaDon = null;
                        this.chiTietHoaDon = [];
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi lấy hóa đơn:', error);
                });
        },

        getChiTietHoaDon() {
            if (this.hoaDon) {
                const hoaDonId = this.hoaDon.hoa_don_id;
                console.log('Getting chi tiet for hoa don:', hoaDonId);
                axios.get(`http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/get-data?hoa_don_id=${hoaDonId}`)
                    .then((res) => {
                        console.log('Chi tiet response:', res.data);
                        if (res.data.data) {
                            this.chiTietHoaDon = res.data.data.map(item => ({
                                ...item,
                                quantity: item.so_luong || 1,
                                dich_vu_name: item.ten_dich_vu || `Dịch vụ #${item.dich_vu_id}`
                            }));
                        } else {
                            this.chiTietHoaDon = [];
                        }
                    })
                    .catch((error) => {
                        console.error('Lỗi khi lấy chi tiết hóa đơn:', error);
                    });
            }
        },
        increaseQuantity(item) {
            item.quantity++;
            this.updateChiTietHoaDon(item);
        },
        decreaseQuantity(item) {
            if (item.quantity > 1) {
                item.quantity--;
                this.updateChiTietHoaDon(item);
            }
        },
        updateChiTietHoaDon(item) {
            axios.post(`http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/update-data`, {
                chi_tiet_hoa_don_id: item.chi_tiet_hoa_don_id,
                so_luong: item.quantity,
                price: item.price
            })
                .then(() => {
                    this.getChiTietHoaDon(); // Refresh data
                })
                .catch((error) => {
                    console.error('Lỗi khi cập nhật số lượng:', error);
                });
        },
        calculateTotal() {
            return this.chiTietHoaDon.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        },
        payBill() {
            if (this.hoaDon) {
                // Implement payment logic here
            }
        }
    }
};
</script>

<style scoped>
.ban-detail {
    min-height: 400px;
    position: sticky;
    top: 0;
}

.card {
    border: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>