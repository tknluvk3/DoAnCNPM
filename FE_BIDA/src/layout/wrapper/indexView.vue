<template>
    <div class="wrapper">
        <TopView></TopView>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-7">
                    <!-- Hiển thị danh sách bàn -->
                    <router-view @select-ban="onSelectBan"></router-view>
                </div>
                <div class="col-lg-5" v-if="selectedBan">
                    <!-- Hiển thị thông tin bàn đang chọn hoặc form đặt bàn -->
                    <div class="card">
                        <div class="card-body">
                            <router-view name="detail" :selected-ban="selectedBan"></router-view>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" v-else>
                    <div class="card text-center">
                        <div class="card-header bg-white border-0">
                            <nav class="navbar bg-body-tertiary">
                                <form class="container-fluid justify-content-end">
                                    <button class="btn btn-outline-dark rounded-pill me-2" type="button">
                                        <i class="fa-solid fa-arrow-down-wide-short"></i>
                                    </button>
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
                                <h5 class="me-3">Tổng tiền:</h5>
                                <h3>0</h3>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary py-2 d-grid col-6" @click="payBill">
                                    <h4><i class="fa-solid fa-dollar-sign"></i> Thanh toán (F9)</h4>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BotView></BotView>
    </div>
</template>

<script>
import BotView from '../components/BotView.vue';
import TopView from '../components/TopView.vue';

export default {
    name: "UserLayout",
    data() {
        return {
            selectedBan: null // Lưu thông tin bàn đang được chọn
        }
    },
    methods: {
        onSelectBan(ban) {
            this.selectedBan = ban;
        }
    },
    components: {
        TopView,
        BotView
    }
}
</script>

<style scoped>
.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container-fluid {
    flex: 1;
}
</style>