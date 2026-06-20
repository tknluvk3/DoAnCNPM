<template>
    <div class="container">
        <div class="card border-top border-primary">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Quản Lý Dịch Vụ</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDichVuModal">Thêm Dịch Vụ</button>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên Dịch Vụ</th>
                            <th class="text-center">Giá Dịch Vụ</th>
                            <th class="text-center">Loại Dịch Vụ</th>
                            <th class="text-center">Mô Tả</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in services" :key="index">
                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ value.dich_vu_name }}</td>
                            <td class="text-center">{{ value.price }}</td>
                            <td class="text-center">{{ value.loai_dich_vu }}</td>
                            <td class="text-center">{{ value.description }}</td>
                            <td class="text-center">
                                <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#updateDichVuModal"
                                    v-on:click="Object.assign(update_dich_vu, value)">Sửa</button>
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteDichVuModal"
                                    v-on:click="Object.assign(delete_dich_vu, value)">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addDichVuModal" tabindex="-1" aria-labelledby="addDichVuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDichVuModalLabel">Thêm dịch vụ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="dich_vu_name" class="form-label">Tên dịch vụ</label>
                            <input type="text" class="form-control" id="dich_vu_name" v-model="create_dich_vu.dich_vu_name">
                        </div>
                        <div class="mb-3">
                            <label for="dich_vu_price" class="form-label">Giá dịch vụ</label>
                            <input type="text" class="form-control" id="dich_vu_price" v-model="create_dich_vu.price">
                        </div>
                        <div class="mb-3">
                            <label for="dich_vu_description" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="dich_vu_description"
                                v-model="create_dich_vu.description">
                        </div>
                        <div class="mb-3">
                            <label for="loai_dich_vu" class="form-label">Loại dịch vụ</label>
                            <input type="text" class="form-control" id="loai_dich_vu" v-model="create_dich_vu.loai_dich_vu">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="createDichVu()">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteDichVuModal" tabindex="-1" aria-labelledby="deleteDichVuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteDichVuModalLabel">Xóa dịch vụ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <p> Bạn có chắc chắn muốn xóa dịch vụ <b>{{ delete_dich_vu.dich_vu_name }}</b> không?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="deleteDichVu()">Xóa</button>
                </div>
            </div>
        </div>
    </div> 
    <!-- Modal -->
    <div class="modal fade" id="updateDichVuModal" tabindex="-1" aria-labelledby="updateDichVuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateDichVuModalLabel">Cập nhật dịch vụ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="dich_vu_name" class="form-label">Tên dịch vụ</label>
                            <input type="text" class="form-control" id="dich_vu_name" v-model="update_dich_vu.dich_vu_name">
                        </div>
                        <div class="mb-3">
                            <label for="dich_vu_price" class="form-label">Giá dịch vụ</label>
                            <input type="text" class="form-control" id="dich_vu_price" v-model="update_dich_vu.price">
                        </div>
                        <div class="mb-3">
                            <label for="dich_vu_description" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="dich_vu_description" v-model="update_dich_vu.description">
                        </div>
                        <div class="mb-3">
                            <label for="loai_dich_vu" class="form-label">Loại dịch vụ</label>
                            <input type="text" class="form-control" id="loai_dich_vu" v-model="update_dich_vu.loai_dich_vu">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="updateDichVu()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div> 
</template>
<script>
import axios from 'axios'
export default {
    // Khai báo dữ liệu
    data() {
        return {
            services: [], // Mảng chứa danh sách dịch vụ
            create_dich_vu: { // Object chứa thông tin dịch vụ mới
                dich_vu_name: '',
                loai_dich_vu: '',
                price: '',
                description: '',
            },
            update_dich_vu: { // Object chứa thông tin dịch vụ cần cập nhật
                dich_vu_name: '',
                loai_dich_vu: '',
                price: '',
                description: '',
            },
            delete_dich_vu: { // Object chứa thông tin dịch vụ cần xóa
                dich_vu_name: '',
                loai_dich_vu: '',
                price: '',
                description: '',
            },
        }
    },
    methods: {
        // Lấy danh sách dịch vụ từ API
        getServices() {
            axios.get('http://127.0.0.1:8000/api/admin/dich-vu/get-data')
                .then((res) => {
                    console.log('Get services response:', res.data);
                    this.services = res.data.data;
                })
                .catch((error) => {
                    console.error('Get services error:', error);
                });
        },

        // Tạo dịch vụ mới
        createDichVu() {
            axios.post('http://127.0.0.1:8000/api/admin/dich-vu/create-data', this.create_dich_vu)
                .then((res) => {
                    if (res.data.status) {
                        this.getServices(); // Cập nhật lại danh sách sau khi tạo thành công
                        // Reset form
                        this.create_dich_vu = {
                            dich_vu_name: '',
                            loai_dich_vu: '',
                            price: '',
                            description: '',
                            };
                        alert(res.data.message);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        // Cập nhật thông tin dịch vụ
        updateDichVu() {
            axios.post('http://127.0.0.1:8000/api/admin/dich-vu/update-data', this.update_dich_vu)
                .then((res) => {
                    if (res.data.status) {
                        this.getServices(); // Cập nhật lại danh sách sau khi sửa thành công
                        alert(res.data.message);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Update error:', error);
                });
        },

        // Xóa dịch vụ
        deleteDichVu() {
            axios.post('http://127.0.0.1:8000/api/admin/dich-vu/delete-data', this.delete_dich_vu)
                .then((res) => {
                    if(res.data.status){
                        this.getServices(); // Cập nhật lại danh sách sau khi xóa thành công
                        alert(res.data.message);
                    }else{
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    // Gọi API lấy danh sách dịch vụ khi component được tạo
    mounted() {
        this.getServices();
    }
}
</script>
<style>
    
</style>