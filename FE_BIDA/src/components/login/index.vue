<template>
    <div id="body" class="d-flex justify-content-center align-items-center">
        <div class="card bg-transparent-card p-4 shadow-lg border-0" style="max-width: 450px; width: 100%;">
            <h3 class="text-center mb-4">ĐĂNG NHẬP</h3>
            <form>
                <div class="mb-3 border-bottom">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username">
                            <label for="floatingInputGroup1">Tên đăng nhập</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 border-bottom">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingInputGroup2" placeholder="Username">
                            <label for="floatingInputGroup1">Mật khẩu</label>
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
                <router-link to="/user/dat-ban">
                    <button type="submit" class="btn btn-login w-100 mb-3 text-white">Đăng nhập</button>
                </router-link>
            </form>
            <p class="text-center mt-4 small">© 2025 Mini Billiards</p>
        </div>
    </div>
    
</template>
<script>
export default {
    
}
</script>
<style>
        div#body {
            background-image: url('https://wallpaper.forfun.com/fetch/bd/bde7eac9a18117733c7c7e3ec08c10df.jpeg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .bg-transparent-card {
            background-color: rgba(0, 0, 0, 0.4);
            /* Nền đen trong suốt */
            border: 0px solid rgba(255, 255, 255, 0);
            border-radius: 1rem;
            color: #fff;
        }

        .form-control {
            background-color: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0);
        }
        .input-group-text{
            background-color: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0);
        }
        .form-control:focus {
            background-color: transparent;
            color: #fff;
            box-shadow: none;
            border-color: #fff;
        }

        .btn-login {
            background-color: #ff4d6d;
            border: none;
        }

        .btn-login:hover {
            background-color: #ff2e52;
        }

        a {
            color: #fff;
        }

        a:hover {
            color: #ff4d6d;
        }

</style>