<template>
    <div class="container-fluid">
        <!-- Phần lọc loại dịch vụ -->
        <div class="mb-4 d-flex justify-content-center">
            <button 
                class="btn btn-outline-primary me-2" 
                @click="filterLoaiDichVu('')"
                :class="{ active: selectedLoai === '' }"
            >
                Tất cả
            </button>
            <button 
                class="btn btn-outline-primary me-2" 
                @click="filterLoaiDichVu('gio')"
                :class="{ active: selectedLoai === 'gio' }"
            >
                Giờ
            </button>
            <button 
                class="btn btn-outline-primary me-2" 
                @click="filterLoaiDichVu('nuoc')"
                :class="{ active: selectedLoai === 'nuoc' }"
            >
                Nước
            </button>
            <button 
                class="btn btn-outline-primary" 
                @click="filterLoaiDichVu('thucAn')"
                :class="{ active: selectedLoai === 'thucAn' }"
            >
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
                        <button class="btn btn-primary w-100" @click="orderItem(item)">Đặt món</button>
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
            selectedLoai: '' // Loại dịch vụ được chọn
        };
    },
    mounted() {
        this.getMenuData();
    },
    methods: {
        getMenuData() {
            axios.get('http://127.0.0.1:8000/api/admin/dich-vu/get-data') // Đường dẫn API lấy danh sách dịch vụ
                .then((res) => {
                    this.dich_vu = res.data.data;
                    this.filteredDichVu = this.dich_vu; // Hiển thị tất cả dịch vụ ban đầu
                })
                .catch(error => {
                    console.error("Có lỗi xảy ra khi lấy dữ liệu:", error);
                });
        },
        filterLoaiDichVu(loai) {
            this.selectedLoai = loai;
            if (loai) {
                this.filteredDichVu = this.dich_vu.filter(item => item.loai_dich_vu === loai);
            } else {
                this.filteredDichVu = this.dich_vu; // Hiển thị tất cả nếu không chọn loại
            }
        },
        orderItem(item) {
            alert(`Bạn đã chọn món: ${item.dich_vu_name}`);
            // Thêm logic đặt món tại đây
        }
    },
}
</script>

<style scoped>
.card {
    border: none;
    background-color: #f8f9fa;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
}

.btn {
    font-size: 0.9rem;
    font-weight: bold;
}

.btn.active {
    background-color: #0d6efd;
    color: white;
}
</style>