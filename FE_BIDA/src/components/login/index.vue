<template>
    <div id="body" class="d-flex justify-content-center align-items-center">
        <div class="card bg-transparent-card p-4 shadow-lg border-0" style="max-width: 450px; width: 100%;">
            <h3 class="text-center mb-4">ĐĂNG NHẬP</h3>
            <form>
                <div class="mb-3 border-bottom">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInputGroup1">
                            <label for="floatingInputGroup1">Tên đăng nhập</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 border-bottom">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingInputGroup2">
                            <label for="floatingInputGroup2">Mật khẩu</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3 small">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ</label>
                    </div>
                    <a href="#">Quên mật khẩu?</a>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <router-link to="/admin/dashboard" class="text-decoration-none">
                            <button type="button" class="btn btn-primary w-100">
                                <i class="fa-solid fa-user-tie me-2"></i>Quản lý
                            </button>
                        </router-link>
                    </div>
                    <div class="col-6">
                        <router-link to="/user/dat-ban" class="text-decoration-none">
                            <button type="button" class="btn btn-success w-100">
                                <i class="fa-solid fa-cash-register me-2"></i>Bán hàng
                            </button>
                        </router-link>
                    </div>
                </div>
            </form>
            <p class="text-center mt-4 small text-muted"> 2025 Mini Billiards</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoginPage'
}
</script>

<style scoped>
#body {
    background-image: url('https://wallpaper.forfun.com/fetch/bd/bde7eac9a18117733c7c7e3ec08c10df.jpeg');
    min-height: 100vh;
    background-size: cover;
    background-position: center;
}

.bg-transparent-card {
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.input-group-text {
    background-color: transparent;
    border: none;
    color: #6c757d;
}

.form-control {
    border: none;
    border-radius: 0;
    background-color: transparent;
}

.form-control:focus {
    box-shadow: none;
    background-color: transparent;
}

.btn {
    padding: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.border-bottom {
    border-color: #dee2e6 !important;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

a {
    color: #6c757d;
    text-decoration: none;
}

a:hover {
    color: #198754;
}
</style>