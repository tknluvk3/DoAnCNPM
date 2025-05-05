<template>
  <div class="container mt-4">
    <div class="card border-top border-success">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">Bảng Doanh Thu</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th class="text-center">ID Hóa đơn</th>
              <th class="text-center">ID Bàn</th>
              <th class="text-center">Tổng tiền</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="bill in bills" :key="bill.hoa_don_id">
              <td class="text-center">{{ bill.hoa_don_id }}</td>
              <td class="text-center">{{ bill.ban_id }}</td>
              <td class="text-end">{{ bill.total_amount ? Number(bill.total_amount).toLocaleString() : 0 }}đ</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">Tổng doanh thu</th>
              <th class="text-end text-success">{{ totalRevenue.toLocaleString() }}đ</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      bills: []
    }
  },
  computed: {
    totalRevenue() {
      return this.bills.reduce((sum, bill) => sum + (Number(bill.total_amount) || 0), 0);
    }
  },
  mounted() {
    this.getBills();
  },
  methods: {
    getBills() {
      axios.get('http://127.0.0.1:8000/api/admin/hoa-don/get-data')
        .then((res) => {
          this.bills = res.data.data || [];
        })
        .catch((error) => {
          console.error('API error:', error);
        })
    }
  }
}
</script>
