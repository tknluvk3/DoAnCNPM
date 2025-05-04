<template>
    <div class="wrapper">
        <TopView></TopView>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-7">
                    <!-- Hiển thị danh sách bàn -->
                    <router-view></router-view>
                </div>
                <div class="col-lg-5">
                    <!-- Hiển thị thông tin bàn đang chọn hoặc form đặt bàn -->
                    <div class="card">
                        <div class="card-body">
                            <router-view name="detail" :selected-ban="selectedBan"></router-view>
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