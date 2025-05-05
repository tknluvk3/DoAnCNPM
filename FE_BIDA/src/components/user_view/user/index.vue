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
                                <p class="mb-0">Bàn trống</p>
                                <h4 class="my-1 text-white">{{ emptyCount() }}</h4>
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
                                <p class="mb-0">Bàn đang sử dụng</p>
                                <h4 class="my-1 text-white">{{ usedCount() }}</h4>
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
                            <button class="btn btn-outline-primary" @click="filterTang(3)">Tầng 3</button>
                        </div>
                    </div>
                </div>

                <!-- Danh sách bàn -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    <div v-for="ban in filteredTang" :key="ban.id" class="col">
                        <div 
                            style="height: 130px;" 
                            class="card" 
                            :class="{ 'bg-light-success': ban.status === 1, 'bg-light-danger': ban.status === 2 }"
                        >
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-0">{{ ban.name }}</h5>
                                        <p class="mb-0" v-if="ban.status === 2">Trạng thái: Đang sử dụng</p>
                                        <p class="mb-0" v-else>Trạng thái: Trống</p>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    <button v-if="ban.status != 2" class="btn btn-success btn-sm" @click="addBill(ban)">
                                        Thêm Bill
                                    </button>
                                    <button v-else class="btn btn-primary btn-sm" @click="viewBill(ban)">
                                        Xem Bill
                                    </button>
                                </div>
                            </div>
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
            tableList: [], 
            filteredTang: [], 
            loading: false
        }
    },
    mounted() {
        this.getBanData();
    },
    methods: {
        getBanData() {
            this.loading = true;
            axios.get('http://127.0.0.1:8000/api/admin/ban/get-data')
                .then((res) => {
                    console.log('Dữ liệu bàn:', res.data);
                    if (res.data.data) {
                        this.tableList = res.data.data.map(item => ({
                            id: item.ban_id,
                            name: item.ban_name,
                            tang: item.loai_ban,
                            status: item.status,
                            hoa_don_id: item.hoa_don_id
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
        allCount() {
            return this.tableList.length;
        },
        usedCount() {
            return this.tableList.filter(value => value.status === 2).length;
        },
        emptyCount() {
            return this.tableList.filter(value => value.status === 1).length;
        },
        addBill(ban) {
            // Kiểm tra hóa đơn hiện tại của bàn
            axios.get(`http://127.0.0.1:8000/api/admin/hoa-don/get-bill-by-ban-id?ban_id=${ban.id}`)
                .then((res) => {
                    const hoaDonList = res.data.data || [];
                    const hasUnpaidBill = hoaDonList.length > 0;
                    if (hasUnpaidBill) {
                        alert('Bàn này đang có hóa đơn chưa thanh toán. Vui lòng thanh toán trước khi tạo hóa đơn mới!');
                        return;
                    }
                    // Tạo hóa đơn mới
                    const hoaDonData = {
                        ban_id: ban.id,
                        nhan_vien_id: 1,
                        start_time: new Date().toISOString().slice(0, 19).replace('T', ' '),
                        status: 'chưa thanh toán'
                    };
                    axios.post('http://127.0.0.1:8000/api/admin/hoa-don/create-data', hoaDonData)
                        .then((res) => {
                            if (res.data.data) {
                                const hoaDon = res.data.data;
                                // Tạo chi tiết hóa đơn cho tiền giờ
                                const chiTietData = {
                                    hoa_don_id: hoaDon.hoa_don_id,
                                    dich_vu_id: 1,
                                    price: 60000,
                                    so_luong: 1
                                };
                                return axios.post('http://127.0.0.1:8000/api/admin/chi-tiet-hoa-don/create-data', chiTietData);
                            }
                        })
                        .then(() => {
                            alert(`Hóa đơn mới đã được tạo cho bàn: ${ban.name}`);
                            // Cập nhật trạng thái bàn thành "đang sử dụng"
                            return axios.post('http://127.0.0.1:8000/api/admin/hoa-don/update-status', {
                                ban_id: ban.id,
                                status: 2 // Đang sử dụng
                            });
                        })
                        .then(() => {
                            this.getBanData();
                            this.$emit('select-ban', ban);
                        })
                        .catch((error) => {
                            console.error('Lỗi khi thêm hóa đơn hoặc cập nhật trạng thái bàn:', error);
                            alert('Không thể thêm hóa đơn hoặc cập nhật trạng thái bàn. Vui lòng thử lại.');
                        });
                })
                .catch((error) => {
                    console.error('Lỗi khi kiểm tra hóa đơn:', error);
                    alert('Không thể kiểm tra hóa đơn. Vui lòng thử lại.');
                });
        },
        viewBill(ban) {
            // Chỉ emit sự kiện để hiển thị panel xem bill
            this.$emit('select-ban', ban);
        },
        getHoaDonDetail() {
            if (!this.selectedBan) return;
            axios.get(`http://127.0.0.1:8000/api/admin/hoa-don/get-data?ban_id=${this.selectedBan.id}`)
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
</style>