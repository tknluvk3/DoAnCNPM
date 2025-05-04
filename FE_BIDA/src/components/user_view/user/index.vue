<template>
    <div class="container-fluid">
        <!-- Phần thống kê -->
        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                <div class="card radius-10 bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-white">
                                <p class="mb-0">Tổng số bàn</p>
                                <h4 class="my-1 text-white">{{ allCount() }}</h4>
                            </div>
                            <div class="ms-auto text-white fs-3"><i class="bx bx-table"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10 bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-white">
                                <p class="mb-0">Bàn đang sử dụng</p>
                                <h4 class="my-1 text-white">{{ usedCount() }}</h4>
                            </div>
                            <div class="ms-auto text-white fs-3"><i class="bx bx-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10 bg-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="text-white">
                                <p class="mb-0">Bàn trống</p>
                                <h4 class="my-1 text-white">{{ emptyCount() }}</h4>
                            </div>
                            <div class="ms-auto text-white fs-3"><i class="bx bx-x-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần lọc bàn theo tầng -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <h5 class="mb-0">Danh sách bàn</h5>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" @click="filterTang(null)">Tất cả</button>
                            <button class="btn btn-outline-primary" @click="filterTang(1)">Tầng 1</button>
                            <button class="btn btn-outline-primary" @click="filterTang(2)">Tầng 2</button>
                        </div>
                    </div>
                </div>

                <!-- Danh sách bàn -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    <div v-for="ban in filteredTang" :key="ban.id" class="col">
                        <div class="card" :class="{ 'bg-light-success': ban.time > 0, 'bg-light-danger': ban.time === 0 }">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-0">{{ ban.name }}</h5>
                                        <p class="mb-0" v-if="ban.time > 0">Thời gian: {{ ban.time }} phút</p>
                                        <p class="mb-0" v-else>Trạng thái: Trống</p>
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn btn-primary btn-sm p-1" @click="showBill(ban)">
                                            <i class="bx bx-detail"></i> <span>Xem</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between px-2"
                                :class="ban.time > 0 ? 'bg-dark text-white' : ''">
                                <p class="small mb-0">{{ formatTime(ban.time) }}</p>
                                <div>
                                    <p class="small mb-0">{{ formatPrice(calculateTotal(ban)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal hiển thị chi tiết hóa đơn -->
        <div class="modal fade" id="billModal" tabindex="-1" v-if="selectedBan">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết bàn {{ selectedBan.name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Thông tin bàn -->
                        <div class="mb-3">
                            <h6>Thông tin bàn</h6>
                            <p>Thời gian sử dụng: {{ selectedBan.time }} phút</p>
                            <p>Giá: {{ formatPrice(selectedBan.price) }}</p>
                        </div>

                        <!-- Danh sách dịch vụ đã gọi -->
                        <div class="mb-3">
                            <h6>Dịch vụ đã gọi</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên dịch vụ</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="dichvu in selectedBan.dichvu" :key="dichvu.id">
                                        <td>{{ dichvu.name }}</td>
                                        <td>{{ dichvu.quantity }}</td>
                                        <td>{{ formatPrice(dichvu.price) }}</td>
                                        <td>{{ formatPrice(dichvu.price * dichvu.quantity) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tổng tiền -->
                        <div class="text-end">
                            <h5>Tổng tiền: {{ formatPrice(calculateTotal()) }}</h5>
                        </div>
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
            tableList: [], // Danh sách bàn
            filteredTang: [], // Danh sách bàn đã lọc
            selectedBan: null, // Bàn được chọn để xem chi tiết
            listDichVu: [], // Danh sách dịch vụ
            filteredDichVu: [], // Danh sách dịch vụ đã lọc
            loading: false // Trạng thái loading
        }
    },
    mounted() {
        this.getBanData();
        
        this.listDichVu = [
            { id: 1, name: 'Coca Cola', loai: 'nuoc-ngot', price: 15000 },
            { id: 2, name: 'Bia Tiger', loai: 'bia', price: 20000 },
        ];
        this.filteredDichVu = this.listDichVu;
    },
    methods: {
        getBanData() {
            this.loading = true;
            axios.get('http://127.0.0.1:8000/api/admin/ban/get-data')
                .then((res) => {
                    console.log('Dữ liệu bàn:', res.data);
                    if (res.data.data) {
                        // Chuyển đổi dữ liệu từ API để phù hợp với cấu trúc hiện tại
                        this.tableList = res.data.data.map(item => ({
                            id: item.id,
                            name: item.ban_name,
                            tang: 1, // Mặc định tầng 1 nếu API không có thông tin tầng
                            time: item.status === 1 ? 60 : 0, // Nếu status = 1 thì đang sử dụng
                            price: parseFloat(item.price_per_hour),
                            dichvu: []
                        }));
                        this.filteredTang = this.tableList;
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi lấy dữ liệu bàn:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        filterTang(tang) {
            if (tang) {
                this.filteredTang = this.tableList.filter(item => item.tang === tang);
            } else {
                this.filteredTang = this.tableList;
            }
        },
        filterDichVu(loai) {
            if (loai) {
                this.filteredDichVu = this.listDichVu.filter(item => item.loai === loai);
            } else {
                this.filteredDichVu = this.listDichVu;
            }
        },
        allCount() {
            return this.tableList.length;
        },
        usedCount() {
            return this.tableList.filter(value => value.time > 0).length;
        },
        emptyCount() {
            return this.tableList.filter(value => value.time === 0).length;
        },
        showBill(ban) {
            this.selectedBan = ban;
            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('billModal'));
            modal.show();
        },
        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
        },
        calculateTotal() {
            if (!this.selectedBan) return 0;
            const tienBan = this.selectedBan.time * (this.selectedBan.price / 60); // Giá bàn tính theo phút
            const tienDichVu = this.selectedBan.dichvu.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
            return tienBan + tienDichVu;
        },
        formatTime(minutes) {
            if (minutes === 0) return 'Trống';
            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;
            return `${hours}:${mins.toString().padStart(2, '0')}`;
        }
    }
}
</script>

<style scoped>
.card {
    border: none;
    margin-bottom: 1.5rem;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
    transition: all .2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
}

.bg-light-success {
    background-color: rgba(25,135,84,.1);
}

.bg-light-danger {
    background-color: rgba(220,53,69,.1);
}

.btn-group {
    gap: 0.5rem;
}

.modal-dialog {
    max-width: 800px;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid rgba(0,0,0,.125);
    padding: 0.5rem;
}
</style>