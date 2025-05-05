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
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tên dịch vụ</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in chiTietHoaDon" :key="item.chi_tiet_hoa_don_id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.dich_vu_name || 'Món #' + item.dich_vu_id }}</td>
                                <td>{{ item.price?.toLocaleString() }}đ</td>
                                <td v-if="item.loai_dich_vu === 'gio'">
                                    <div class="timer-box bg-success bg-opacity-10 d-flex align-items-center position-relative">
                                        <!-- Đồng hồ đếm thời gian thực -->
                                        <span class="badge bg-success position-absolute top-0 end-0" style="font-size: 0.6rem;">
                                            {{ formatElapsed(item) }}
                                        </span>
                                        <!-- Nút dừng/tiếp tục -->
                                        <button class="btn btn-link p-0 me-2" @click="toggleTimer(item)">
                                            <i :class="item.isRunning ? 'fa-solid fa-pause' : 'fa-solid fa-play'"></i>
                                        </button>
                                        <!-- Số giờ làm tròn 0.5h -->
                                        <span class="fs-5 fw-bold mx-2">{{ item.elapsedHourDisplay }}</span>
                                    </div>
                                </td>
                                <td v-else>
                                    <button class="btn btn-outline-primary btn-sm me-2" @click="decreaseQuantity(item)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="mx-2">{{ item.quantity }}</span>
                                    <button class="btn btn-outline-primary btn-sm ms-2" @click="increaseQuantity(item)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                                <td class="fw-bold text-primary">
                                    <template v-if="item.loai_dich_vu === 'gio'">
                                        {{ (item.price * item.elapsedHour).toLocaleString() }}đ
                                    </template>
                                    <template v-else>
                                        {{ (item.price * item.quantity).toLocaleString() }}đ
                                    </template>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteChiTietHoaDon(item)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <h5 class="me-3">Tổng tiền:</h5>
                    <h3>{{ calculateTotal().toLocaleString() }}đ</h3>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary py-2 d-grid col-6" @click="handlePayBill">
                        <h4><i class="fa-solid fa-dollar-sign"></i> Thanh toán (F9)</h4>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Thanh toán -->
    <div class="offcanvas offcanvas-end custom-width" tabindex="-1" id="offcanvasPayBill" aria-labelledby="offcanvasPayBillLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasPayBillLabel">
                Phiếu thanh toán - {{ selectedBan.name }} <span v-if="selectedBan.location">/ {{ selectedBan.location }}</span>
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span><i class="fa-regular fa-user"></i> Khách lẻ</span>
            </div>
            <!-- Danh sách dịch vụ chia nhóm -->
            <div class="mb-2">
                <div class="fw-bold bg-light px-2 py-1">Đồ uống</div>
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr v-for="(item, idx) in chiTietHoaDon.filter(i => i.loai_dich_vu === 'nuoc')" :key="item.chi_tiet_hoa_don_id">
                            <td>{{ idx + 1 }}</td>
                            <td>{{ item.dich_vu_name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.price.toLocaleString() }}</td>
                            <td>{{ (item.price * item.quantity).toLocaleString() }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="fw-bold bg-light px-2 py-1 mt-2">Khác</div>
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr v-for="(item, idx) in chiTietHoaDon.filter(i => i.loai_dich_vu !== 'nuoc')" :key="item.chi_tiet_hoa_don_id">
                            <td>{{ idx + 1 }}</td>
                            <td>
                                {{ item.dich_vu_name }}
                                <span v-if="item.loai_dich_vu === 'gio'" class="text-primary ms-2">
                                    <i class="fa-regular fa-clock"></i>
                                    Từ {{ formatTime(item.start_time, 'HH:mm') }}
                                    <template v-if="item.end_time">
                                        đến {{ formatTime(item.end_time, 'HH:mm') }}
                                    </template>
                                </span>
                            </td>
                            <td>
                                <template v-if="item.loai_dich_vu === 'gio'">{{ item.elapsedHourDisplay }}</template>
                                <template v-else>{{ item.quantity }}</template>
                            </td>
                            <td>{{ item.price.toLocaleString() }}</td>
                            <td>
                                <template v-if="item.loai_dich_vu === 'gio'">{{ (item.price * item.elapsedHour).toLocaleString() }}</template>
                                <template v-else>{{ (item.price * item.quantity).toLocaleString() }}</template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Tổng tiền, giảm giá, khách cần trả -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="fw-bold">Tổng tiền hàng</span>
                <span class="fw-bold fs-5">{{ calculateTotal().toLocaleString() }}đ</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span>Giảm giá</span>
                <span>0</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Khách cần trả</span>
                <span class="fw-bold text-primary fs-4">{{ calculateTotal().toLocaleString() }}đ</span>
            </div>
            <!-- Phương thức thanh toán -->
            <div class="my-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pttt" id="tienmat" checked>
                    <label class="form-check-label" for="tienmat">Tiền mặt</label>
                </div>
            </div>
            <!-- Nút xác nhận thanh toán -->
            <button class="btn btn-success w-100 mt-3" @click="confirmPayBill">
                <i class="fa-solid fa-dollar-sign"></i> Thanh toán (Enter)
            </button>
        </div>
    </div>

    <!-- Modal xác nhận dừng thời gian -->
    <div class="modal fade" id="modalStopTimer" tabindex="-1" aria-labelledby="modalStopTimerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalStopTimerLabel">Xác nhận dừng thời gian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    Một hoặc nhiều dịch vụ tính giờ vẫn đang chạy.<br>
                    Bạn có muốn dừng thời gian lại trước khi thanh toán không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" @click="confirmStopTimer">Dừng thời gian & tiếp tục</button>
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
            chiTietHoaDon: [],
            timerIntervals: {}
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
        formatTime(time, format = 'full') {
            if (!time) return '';
            const date = new Date(time);
            if (format === 'HH:mm') {
                return date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
            }
            return date.toLocaleString('vi-VN');
        },
        getHoaDonDetail() {
            if (!this.selectedBan) return;
            axios.get(`http://127.0.0.1:8000/api/admin/hoa-don/get-bill-by-ban-id?ban_id=${this.selectedBan.id}`)
                .then((res) => {
                    if (res.data.data && res.data.data.length > 0) {
                        this.hoaDon = res.data.data[0];
                        this.getChiTietHoaDon();
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
                axios.get(`http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/get-data?hoa_don_id=${hoaDonId}`)
                    .then((res) => {
                        if (res.data.data) {
                            this.chiTietHoaDon = res.data.data.map(item => {
                                // Xử lý cho loại giờ
                                if (item.loai_dich_vu === 'gio') {
                                    const startTime = new Date(item.start_time);
                                    const now = new Date();
                                    const elapsed = (now - startTime) / 3600000; // số giờ
                                    const elapsedHour = Math.round(elapsed * 10) / 10; // làm tròn 1 chữ số sau dấu phẩy
                                    return {
                                        ...item,
                                        elapsedHour,
                                        elapsedHourDisplay: elapsedHour.toFixed(1),
                                        isRunning: true
                                    };
                                }
                                // Các loại khác giữ nguyên
                                return {
                                    ...item,
                                    quantity: item.so_luong || 1,
                                    dich_vu_name: item.dich_vu_name || `Dịch vụ #${item.dich_vu_id}`,
                                    loai_dich_vu: item.loai_dich_vu
                                };
                            });
                            // Khởi động timer cho các dịch vụ giờ
                            this.startAllTimers();
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
                // Không cần gọi lại getChiTietHoaDon vì đã cập nhật trực tiếp trên item
            })
            .catch((error) => {
                console.error('Lỗi khi cập nhật số lượng:', error);
                // Nếu lỗi thì load lại dữ liệu từ server
                this.getChiTietHoaDon();
            });
        },
        calculateTotal() {
            return this.chiTietHoaDon.reduce((total, item) => {
                if (item.loai_dich_vu === 'gio') {
                    return total + (item.price * item.elapsedHour);
                }
                return total + (item.price * item.quantity);
            }, 0);
        },
        payBill() {
            if (this.hoaDon) {
                // Implement payment logic here
            }
        },
        formatElapsed(item) {
            if (!item.start_time || !item.elapsedHour) return '';
            const startDate = new Date(item.start_time);
            const endDate = new Date();
            const elapsedTime = Math.floor((endDate - startDate) / 1000);
            const elapsedHours = Math.floor(elapsedTime / 3600);
            const remainingMinutes = Math.floor((elapsedTime % 3600) / 60);
            return `${elapsedHours} giờ ${remainingMinutes} phút`;
        },
        toggleTimer(item) {
            item.isRunning = !item.isRunning;
            if (item.isRunning) {
                this.startTimer(item);
                // Nếu tiếp tục, cập nhật end_time về null
                axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-end-time', {
                    hoa_don_id: this.hoaDon.hoa_don_id,
                    end_time: null
                })
                .then(() => {
                    item.end_time = null;
                })
                .catch((error) => {
                    console.error('Lỗi khi cập nhật end_time:', error);
                });
            } else {
                this.stopTimer(item);
                // Khi dừng, cập nhật end_time là thời điểm hiện tại
                axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-end-time', {
                    hoa_don_id: this.hoaDon.hoa_don_id,
                    end_time: this.formatDateTime(new Date())
                })
                .then(() => {
                    item.end_time = this.formatDateTime(new Date());
                })
                .catch((error) => {
                    console.error('Lỗi khi cập nhật end_time:', error);
                });
            }
        },
        startAllTimers() {
            this.chiTietHoaDon.forEach(item => {
                if (item.loai_dich_vu === 'gio' && item.isRunning) {
                    this.startTimer(item);
                }
            });
        },
        startTimer(item) {
            if (this.timerIntervals[item.chi_tiet_hoa_don_id]) return;
            this.timerIntervals[item.chi_tiet_hoa_don_id] = setInterval(() => {
                const now = new Date();
                const startTime = new Date(item.start_time);
                const elapsed = (now - startTime) / 3600000;
                item.elapsedHour = Math.round(elapsed * 10) / 10;
                item.elapsedHourDisplay = item.elapsedHour.toFixed(1);
            }, 1000);
        },
        stopTimer(item) {
            clearInterval(this.timerIntervals[item.chi_tiet_hoa_don_id]);
            this.timerIntervals[item.chi_tiet_hoa_don_id] = null;
        },
        deleteChiTietHoaDon(item) {
            if (confirm('Bạn có chắc muốn xóa dịch vụ này khỏi hóa đơn?')) {
                axios.post('http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/delete-data', {
                    chi_tiet_hoa_don_id: item.chi_tiet_hoa_don_id
                })
                .then(() => {
                    this.getChiTietHoaDon();
                })
                .catch((error) => {
                    alert('Lỗi khi xóa dịch vụ!');
                    console.error(error);
                });
            }
        },
        handlePayBill() {
            // Kiểm tra có dịch vụ giờ nào đang chạy không
            const isAnyTimerRunning = this.chiTietHoaDon.some(
                item => item.loai_dich_vu === 'gio' && item.isRunning
            );
            if (isAnyTimerRunning) {
                // Hiện modal xác nhận
                const modal = new bootstrap.Modal(document.getElementById('modalStopTimer'));
                modal.show();
            } else {
                // Mở offcanvas luôn nếu không có timer đang chạy
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasPayBill'));
                offcanvas.show();
            }
        },
        confirmStopTimer() {
            // Dừng tất cả timer dịch vụ giờ đang chạy
            this.chiTietHoaDon.forEach(item => {
                if (item.loai_dich_vu === 'gio' && item.isRunning) {
                    this.stopTimer(item);
                    item.isRunning = false;
                }
            });
            // Cập nhật end_time cho hóa đơn
            axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-end-time', {
                hoa_don_id: this.hoaDon.hoa_don_id,
                end_time: this.formatDateTime(new Date())
            })
            .then(() => {
                // Có thể reload lại chi tiết hóa đơn nếu muốn cập nhật giao diện
                this.getChiTietHoaDon();
            })
            .catch((error) => {
                console.error('Lỗi khi cập nhật end_time:', error);
            });

            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalStopTimer'));
            modal.hide();
            // Mở offcanvas
            setTimeout(() => {
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasPayBill'));
                offcanvas.show();
            }, 300);
        },
        formatDateTime(date) {
            const pad = n => n < 10 ? '0' + n : n;
            return date.getFullYear() + '-' +
                pad(date.getMonth() + 1) + '-' +
                pad(date.getDate()) + ' ' +
                pad(date.getHours()) + ':' +
                pad(date.getMinutes()) + ':' +
                pad(date.getSeconds());
        },
        confirmPayBill() {
            axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-data', {
                hoa_don_id: this.hoaDon.hoa_don_id,
                total_amount: this.calculateTotal(),
                status: 2 // Đã thanh toán
            })
            .then(() => {
                // Cập nhật trạng thái bàn về trống (status = 0)
                return axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-status', {
                    ban_id: this.selectedBan.id,
                    status: 1
                });
            })
            .then(() => {
                alert('Thanh toán thành công!');
                this.getHoaDonDetail(); // Reload lại hóa đơn
                // Nếu muốn reload lại danh sách/trạng thái bàn ở component cha thì emit event
                if (typeof this.$emit === 'function') {
                    this.$emit('reloadBan');
                }
                // Đóng offcanvas nếu muốn
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasPayBill'));
                if (offcanvas) offcanvas.hide();
            })
            .catch((error) => {
                alert('Lỗi khi thanh toán hoặc cập nhật trạng thái bàn!');
                console.error(error);
            });
        }
    }
};
</script>

<style scoped>
.offcanvas-end.custom-width {
    width: 800px; /* hoặc bất kỳ giá trị nào bạn muốn */
  }
.ban-detail {
    min-height: 400px;
    position: sticky;
    top: 0;
}

.card {
    border: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.bg-success.bg-opacity-10 {
    background-color: #d1e7dd !important;
}

.timer-box {
    background: #fff;
    border-radius: 1.5rem;
    border: 1px solid #198754;
    padding: 2px 12px;
    min-width: 90px;
    display: flex;
    align-items: center;
    font-weight: 500;
}
.price-box {
    background: #fff;
    border-radius: 1.5rem;
    padding: 2px 18px;
    min-width: 80px;
    text-align: center;
    font-weight: 500;
}

.offcanvas.offcanvas-end {
    height: 100vh !important;
    max-height: 100vh !important;
    top: 0 !important;
}
</style>