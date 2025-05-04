<template>
    <div class="ban-detail">
        <div v-if="selectedBan">
            <div v-if="hoaDon">
                <!-- Hiển thị thông tin hóa đơn -->
                <div class="card">
                    <div class="card-header">
                        <h5>Hóa đơn cho bàn: {{ selectedBan.name }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Thời gian bắt đầu:</strong> {{ hoaDon.start_time }}</p>
                        <p><strong>Trạng thái:</strong> {{ hoaDon.status === 1 ? 'Đang sử dụng' : 'Đã thanh toán' }}</p>
                        <p><strong>Tổng tiền:</strong> {{ hoaDon.total_amount.toLocaleString() }} đ</p>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>Không tìm thấy hóa đơn cho bàn này.</p>
            </div>
        </div>
        <div v-else class="text-center text-muted py-5">
            <div class="card text-center">
                <div class="card-header bg-white border-0">
                    <nav class="navbar bg-body-tertiary">
                        <form class="container-fluid justify-content-end">
                            <button class="btn btn-outline-dark rounded-pill me-2" type="button"><i
                                    class="fa-solid fa-arrow-down-wide-short"></i></button>
                        </form>
                    </nav>
                </div>
                <div class="card-body text-muted d-flex flex-column justify-content-center align-items-center"
                    style="height: 600px;">
                    <i class="fa-solid fa-burger fa-4x mb-3 text-primary"></i>
                    <h5 class="card-title">Chưa có món trong đơn</h5>
                    <p class="card-text">Vui lòng chọn món trong thực đơn bên trái màn hình</p>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <h5 class="me-3 ">Tổng tiền:</h5>
                        <h3>0</h3>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-primary me-2">
                            <h4><i class="fa-solid fa-print"></i> In tạm tính</h4>
                        </button>
                        <button class="btn btn-primary py-2 d-grid col-6" @click="payBill(index)">
                            <h4><i class="fa-solid fa-dollar-sign"></i> Thanh toán (F9)</h4>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            selectedBan: null,
            hoaDon: null
        };
    },
    mounted() {
        this.getBanDetail();
    },
    methods: {
        getBanDetail() {
            // Lấy thông tin bàn
            axios.get(`http://127.0.0.1:8000/api/admin/ban/get-data?ban_id=${this.id}`)
                .then((res) => {
                    this.selectedBan = res.data.data;
                })
                .catch((error) => {
                    console.error('Lỗi khi lấy thông tin bàn:', error);
                });

            // Lấy thông tin hóa đơn
            axios.get(`http://127.0.0.1:8000/api/admin/hoa-don/get-data?ban_id=${this.id}`)
                .then((res) => {
                    if (res.data.data && res.data.data.length > 0) {
                        this.hoaDon = res.data.data[0];
                    } else {
                        this.hoaDon = null;
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi lấy hóa đơn:', error);
                });
        }
    }
};
</script>

<style scoped>
.ban-detail {
    min-height: 400px;
}
</style>