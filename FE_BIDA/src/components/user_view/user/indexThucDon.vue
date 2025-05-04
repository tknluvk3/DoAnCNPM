<template>
    <div class="container mt-3">
        <form class="container-fluid justify-content-start mb-3">
            <button v-for="(label, key) in categories" :key="key" class="btn me-2 rounded-pill"
                :class="{ 'btn-outline-success active': selectedCategory === key, 'btn-outline-secondary': selectedCategory !== key }"
                type="button" @click="filterDichVu(key)">
                {{ label }}
            </button>
        </form>
        <div class="row">
            <template v-for="(value, index) in paginatedDichVu" :key="index">
                <div class="col-lg-2 mb-3">
                    <div class="card card-hover" style="cursor: pointer;" @click="openModal(value)">
                        <div class="card-body text-center bg-primary-subtle pt-5" style="height: 120px;">
                            <i class="fa-solid fa-champagne-glasses fs-3"></i>
                            <h4 class="fs-5 mt-3 m-0 fst-italic text-danger">{{ formatPrice(value.price) }}</h4>
                        </div>
                        <div class="card-footer" style="height: 60px;">
                            <h6 class="text-center">{{ value.name }}</h6>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            <button class="btn btn-outline-secondary me-2" :disabled="currentPage === 1" @click="prevPage">Trang trước</button>
            <span>Trang {{ currentPage }} / {{ totalPages }}</span>
            <button class="btn btn-outline-secondary ms-2" :disabled="currentPage === totalPages" @click="nextPage">Trang sau</button>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="modal d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chọn số lượng</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Dịch vụ:</strong> {{ selectedService.name }}</p>
                        <p><strong>Giá:</strong> {{ formatPrice(selectedService.price) }}</p>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" id="quantity" v-model="quantity" class="form-control" min="1" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Đóng</button>
                        <button type="button" class="btn btn-primary" @click="addToCart">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            thucDonList: [], // Danh sách thực đơn
            filteredThucDon: [], // Danh sách thực đơn đã lọc
            categories: {
                'all': 'Tất cả',
                'nuoc': 'Nước',
                'an': 'Ăn',
                'khac': 'Khác'
            },
            selectedCategory: 'all',
            showModal: false,
            selectedThucDon: null,
            quantity: 1,
            currentPage: 1,
            itemsPerPage: 12
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredThucDon.length / this.itemsPerPage);
        },
        paginatedThucDon() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredThucDon.slice(start, end);
        }
    },
    methods: {
        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(price);
        },
        filterThucDon(category) {
            this.selectedCategory = category;
            if (category === 'all') {
                this.filteredThucDon = this.thucDonList;
            } else {
                this.filteredThucDon = this.thucDonList.filter(item => item.category === category);
            }
            this.currentPage = 1; // Reset trang khi lọc
        },
        openModal(thucDon) {
            this.selectedThucDon = thucDon;
            this.quantity = 1;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        addToCart() {
            if (!this.selectedThucDon) return;
            
            const item = {
                ...this.selectedThucDon,
                quantity: parseInt(this.quantity)
            };
            
            // Gửi sự kiện thêm thực đơn lên component cha
            this.$emit('add-thucdon', item);
            
            this.closeModal();
        }
    },
    mounted() {
        // Gọi API để lấy danh sách thực đơn từ backend
        this.$axios.get('http://127.0.0.1:8000/api/admin/thucdon/get-data')
            .then(response => {
                this.thucDonList = response.data.data;
                this.filteredThucDon = this.thucDonList;
            })
            .catch(error => {
                console.error('Lỗi khi lấy dữ liệu thực đơn:', error);
            });
    }
}
</script>

<style scoped>
.card-hover:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.modal {
    display: block;
}

.modal-backdrop {
    display: none;
}
</style>