<template>
    <div class="admin-menu">
        <nav class="navbar navbar-expand-xl w-100">
            <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                <li class="nav-item">
                    <router-link class="nav-link" to="/admin/dashboard">
                        <div class="parent-icon">
                            <i class="bx bx-home-circle"></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/admin/ban">
                        <div class="parent-icon">
                            <i class="bx bx-table"></i>
                        </div>
                        <div class="menu-title">Quản lý bàn</div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/admin/dich-vu">
                        <div class="parent-icon">
                            <i class="bx bx-package"></i>
                        </div>
                        <div class="menu-title">Quản lý dịch vụ</div>
                    </router-link>
                </li>
				<li class="nav-item">
                    <router-link class="nav-link" to="/admin/doanh-thu">
                        <div class="parent-icon">
                            <i class="bx bx-bar-chart-alt"></i>
                        </div>
                        <div class="menu-title">Quản lý doanh thu</div>
                    </router-link>
                </li>
				<li class="nav-item">
                    <router-link class="nav-link" to="/">
                        <div class="parent-icon">
                            <i class="bx bx-left-arrow-alt"></i>
                        </div>
                        <div class="menu-title">Về User</div>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "MenuRocker"
}
</script>

<style scoped>
.admin-menu {
    background: #1a2232;
    padding: 10px;
}

.navbar {
    padding: 15px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    color: #fff;
    text-decoration: none;
}

.nav-link:hover {
    background: rgba(255,255,255,0.1);
    border-radius: 5px;
}

.parent-icon {
    margin-right: 10px;
}

.menu-title {
    font-size: 14px;
}
</style>