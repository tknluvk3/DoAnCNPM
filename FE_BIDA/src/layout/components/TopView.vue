<template>
    <header>
        <nav class="navbar bg-dark pb-0 pt-3">
            <div class="col-lg-7">
                <ul class="nav nav-tabs ps-3">
                    <li class="nav-item">
                        <router-link to="/user/dat-ban" class="nav-link text-white"
                            :class="{ 'active bg-dark': $route.path === '/user/dat-ban' }">
                            <strong><i class="fa-solid fa-table-cells-large"></i> Phòng bàn</strong>
                        </router-link>
                    </li>
                    <li class="nav-item ms-3 me-3 ">
                        <router-link to="/user/thuc-don" class="nav-link text-white"
                            :class="{ 'active bg-dark': $route.path === '/user/thuc-don' }">
                            <strong><i class="fa-solid fa-utensils me-2"></i> Thực đơn</strong>
                        </router-link>
                    </li>


                </ul>
            </div>
            <div class="col-lg-5 d-flex justify-content-between">
                <ul class="">

                </ul>
                <div class="me-3 mt-1">
                    <span class="text-white">thungan</span>
                    <button class="navbar-toggler bg-body-tertiary p-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-white"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">MENU</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <router-link to="/user" class="nav-link"
                                        :class="{ 'active': $route.path === '/' }">Home</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/admin/" class="nav-link"
                                    :class="{ 'active': $route.path === '/admin/' }">Quản lý</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/admin/ban" class="nav-link"
                                        :class="{ 'active': $route.path === '/admin/ban' }">Quản lý
                                        bàn</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/admin/dich-vu" class="nav-link"
                                        :class="{ 'active': $route.path === '/admin/dich-vu' }">Quản lý
                                        dịch vụ</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    data() {
        return {
            selectedTable: null,
        };
    },
    methods: {
        selectTable(table) {
            this.selectedTable = table;
        }
    }
};
</script>
