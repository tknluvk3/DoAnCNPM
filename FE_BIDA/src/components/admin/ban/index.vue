<template>
    <div>
        <div class="container">
            <div class="card border-top border-primary">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Quản Lý Bàn</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTableModal">Thêm
                        Bàn</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Bàn</th>
                                <th class="text-center">Loại Bàn</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in tables" :key="index">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td class="text-center">{{ value.ban_name }}</td>
                                <td class="text-center">
                                    <span v-if="value.loai_ban == 1">Tầng 1</span>
                                    <span v-else-if="value.loai_ban == 2">Tầng 2</span>
                                    <span v-else>Tầng 3</span>
                                </td>
                                <td class="text-center">
                                    <span v-if="value.status == 1" class="badge bg-success p-2">Trống</span>
                                    <span v-else class="badge bg-danger p-2">Đang sử dụng</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#updateTableModal"
                                        v-on:click="Object.assign(update_table, value)">Sửa</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteTableModal"
                                        v-on:click="Object.assign(delete_table, value)">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTableModalLabel">Thêm bàn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="table_name" class="form-label">Tên bàn</label>
                            <input type="text" class="form-control" id="table_name" v-model="create_table.ban_name">
                        </div>
                        <div class="mb-3">
                            <label for="table_type" class="form-label">Loại bàn</label>
                            <select class="form-select" aria-label="Default select example" id="table_type"
                                v-model="create_table.loai_ban">
                                <option selected value="1">Tầng 1</option>
                                <option value="2">Tầng 2</option>
                                <option value="3">Tầng 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="table_status" class="form-label">Trạng thái</label>
                            <select class="form-select" aria-label="Default select example" id="table_status"
                                v-model="create_table.status">
                                <option selected value="1">Trống</option>
                                <option value="2">Đang sử dụng</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        v-on:click="createTable()">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="updateTableModal" tabindex="-1" aria-labelledby="updateTableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateTableModalLabel">Cập nhật bàn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="table_name" class="form-label">Tên bàn</label>
                            <input type="text" class="form-control" id="table_name" v-model="update_table.ban_name">
                        </div>
                        <div class="mb-3">
                            <label for="table_type" class="form-label">Loại bàn</label>
                            <select class="form-select" aria-label="Default select example" id="table_type"
                                v-model="update_table.loai_ban">
                                <option selected value="1">Tầng 1</option>
                                <option value="2">Tầng 2</option>
                                <option value="3">Tầng 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="table_status" class="form-label">Trạng thái</label>
                            <select class="form-select" aria-label="Default select example" id="table_status"
                                v-model="update_table.status">
                                <option selected value="1">Trống</option>
                                <option value="2">Đang sử dụng</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="updateTable()">Cập
                        nhật</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteTableModalLabel">Xóa bàn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <p> Bạn có chắc chắn muốn xóa bàn {{ delete_table.ban_name }} không?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        v-on:click="deleteTable()">Xóa</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            // Mảng chứa danh sách các bàn
            tables: [],
            // Đối tượng lưu thông tin bàn mới khi tạo
            create_table: {
                ban_name: '',
                loai_ban: 1,
                status: 1,
            },
            // Đối tượng lưu thông tin bàn khi cập nhật
            update_table: {
                ban_name: '',
                loai_ban: 1,
                status: 1,
            },
            // Đối tượng lưu thông tin bàn khi xóa
            delete_table: {
                ban_name: '',
                loai_ban: 1,
                status: 1,
            }
        }
    },
    // Gọi API lấy danh sách bàn khi component được tạo
    mounted() {
        this.getTables();
    },
    methods: {
        // Lấy danh sách bàn từ API
        getTables() {
            axios.get('http://127.0.0.1:8000/api/admin/ban/get-data')
                .then((res) => {
                    console.log('API response:', res.data.data[0].ban_name);
                    this.tables = res.data.data;
                })
                .catch((error) => {
                    console.error('API error:', error);
                })
        },
        // Tạo bàn mới
        createTable() {
            axios.post('http://127.0.0.1:8000/api/admin/ban/create-data', this.create_table)
                .then((res) => {
                    if (res.data.status) {
                        // Nếu tạo thành công, cập nhật lại danh sách và reset form
                        this.getTables();
                        this.create_table = {
                            ban_name: '',
                            loai_ban: 1,
                            status: 1,
                        }
                        alert(res.data.message);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // Cập nhật thông tin bàn
        updateTable() {
            axios.post('http://127.0.0.1:8000/api/admin/ban/update-data', this.update_table)
                .then((res) => {
                    if (res.data.status) {
                        // Nếu cập nhật thành công, cập nhật lại danh sách
                        this.getTables();
                        alert(res.data.message);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // Xóa bàn
        deleteTable() {
            axios.post('http://127.0.0.1:8000/api/admin/ban/delete-data', this.delete_table)
                .then((res) => {
                    if (res.data.status) {
                        // Nếu xóa thành công, cập nhật lại danh sách
                        this.getTables();
                        alert(res.data.message);
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
</script>
<style></style>