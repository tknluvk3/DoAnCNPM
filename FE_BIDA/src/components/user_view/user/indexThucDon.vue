<template>
    <div class="container-fluid">
        <!-- Modal đặt món -->
        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel">Đặt món</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Tên món:</label>
                                <input type="text" class="form-control" :value="selectedItem?.dich_vu_name" readonly>
                                <small class="text-muted">ID: {{ selectedItem?.dich_vu_id }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giá:</label>
                                <input type="text" class="form-control" :value="selectedItem ? selectedItem.price.toLocaleString() + ' đ' : ''" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" v-model="quantity" min="1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chọn hóa đơn:</label>
                                <select class="form-select" v-model="selectedHoaDonId">
                                    <option v-for="hoaDon in danhSachHoaDon" 
                                            :key="hoaDon.hoa_don_id" 
                                            :value="hoaDon.hoa_don_id">
                                        Hóa đơn #{{ hoaDon.hoa_don_id }} - Bàn {{ hoaDon.ban_id }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" @click="confirmOrder()">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Phần lọc loại dịch vụ -->
        <div class="mb-4 d-flex justify-content-center">
            <button class="btn btn-outline-primary me-2" @click="filterLoaiDichVu('')"
                :class="{ active: selectedLoai === '' }">
                Tất cả
            </button>
            <button class="btn btn-outline-primary me-2" @click="filterLoaiDichVu('gio')"
                :class="{ active: selectedLoai === 'gio' }">
                Giờ
            </button>
            <button class="btn btn-outline-primary me-2" @click="filterLoaiDichVu('nuoc')"
                :class="{ active: selectedLoai === 'nuoc' }">
                Nước
            </button>
            <button class="btn btn-outline-primary" @click="filterLoaiDichVu('thucAn')"
                :class="{ active: selectedLoai === 'thucAn' }">
                Thức ăn
            </button>
        </div>

        <!-- Danh sách dịch vụ -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-5 g-4">
            <div v-for="item in filteredDichVu" :key="item.id" class="col">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <!-- Hiển thị icon dựa trên loại dịch vụ -->
                        <i v-if="item.loai_dich_vu === 'nuoc'" class="fa-solid fa-beer-mug-empty fa-3x text-primary mb-3"></i>
                        <i v-else-if="item.loai_dich_vu === 'gio'" class="fa-solid fa-clock fa-3x text-warning mb-3"></i>
                        <i v-else-if="item.loai_dich_vu === 'thucAn'" class="fa-solid fa-utensils fa-3x text-success mb-3"></i>
                        <h5 class="card-title text-danger">{{ item.price.toLocaleString() }} đ</h5>
                        <p class="card-text text-truncate">{{ item.dich_vu_name }}</p>
                        <button class="btn btn-primary w-100" @click="showOrderModal(item)">Đặt món</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            dich_vu: [], // Danh sách món ăn
            filteredDichVu: [], // Danh sách món ăn đã lọc
            selectedLoai: '', // Loại dịch vụ được chọn
            selectedItem: null, // Món được chọn để đặt
            quantity: 1, // Số lượng mặc định
            orderModal: null, // Biến để lưu instance của modal
            danhSachHoaDon: [], // Danh sách hóa đơn đang active
            selectedHoaDonId: null // Hóa đơn được chọn
        };
    },
    mounted() {
        this.getMenuData();
        this.getActiveHoaDon();
        // Khởi tạo modal
        this.orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    },
    methods: {
        getMenuData() {
            axios.get('http://127.0.0.1:8000/api/admin/dich-vu/get-data')
                .then((res) => {
                    this.dich_vu = res.data.data;
                    this.filteredDichVu = this.dich_vu;
                })
                .catch(error => {
                    console.error("Có lỗi xảy ra khi lấy dữ liệu:", error);
                });
        },
        getActiveHoaDon() {
            // Lấy danh sách hóa đơn đang active (status = 1)
            axios.get('http://127.0.0.1:8000/api/admin/hoa-don/get-data?status=1')
                .then((res) => {
                    this.danhSachHoaDon = res.data.data;
                })
                .catch(error => {
                    console.error("Lỗi khi lấy danh sách hóa đơn:", error);
                });
        },
        filterLoaiDichVu(loai) {
            this.selectedLoai = loai;
            if (loai) {
                this.filteredDichVu = this.dich_vu.filter(item => 
                    item.loai_dich_vu === loai
                );
            } else {
                this.filteredDichVu = this.dich_vu;
            }
        },
        showOrderModal(item) {
            this.selectedItem = item;
            this.quantity = 1;
            this.selectedHoaDonId = null; // Reset selected hóa đơn
            this.orderModal.show();
        },
        confirmOrder() {
            if (!this.selectedHoaDonId) {
                alert('Vui lòng chọn hóa đơn');
                return;
            }

            if (this.quantity < 1) {
                alert('Số lượng phải lớn hơn 0');
                return;
            }

            if (!this.selectedItem || !this.selectedItem.dich_vu_id) {
                alert('Không tìm thấy thông tin dịch vụ');
                return;
            }

            // Tạo chi tiết hóa đơn mới
            const data = {
                hoa_don_id: this.selectedHoaDonId,
                dich_vu_id: this.selectedItem.dich_vu_id,
                price: this.selectedItem.price,
                so_luong: parseInt(this.quantity),
                total: this.selectedItem.price * parseInt(this.quantity)
            };

            console.log('Data gửi đi:', data); // Log để kiểm tra

            axios.post('http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/create-data', data)
                .then(() => {
                    alert('Đã thêm món vào hóa đơn');
                    this.orderModal.hide();
                    // Emit event để thông báo cho component cha cập nhật dữ liệu
                    this.$emit('order-added');
                })
                .catch(error => {
                    console.error("Lỗi khi thêm món:", error);
                    alert('Không thể thêm món. Vui lòng thử lại.');
                });
        }
    }
};
</script>

<style scoped>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.active {
    background-color: #0d6efd;
    color: white;
}
</style>