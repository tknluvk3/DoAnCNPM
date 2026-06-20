<template>
  Chào mừng bạn đến với trang quản lý
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      // Data sẽ được thêm sau
    }
  }
}
</script>

<style scoped>
.dashboard {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: white;
  padding: 20px;
}

.logo h2 {
  margin-bottom: 30px;
  text-align: center;
}

.sidebar nav ul {
  list-style: none;
  padding: 0;
}

.sidebar nav ul li {
  padding: 12px 15px;
  margin: 5px 0;
  cursor: pointer;
  border-radius: 5px;
}

.sidebar nav ul li:hover,
.sidebar nav ul li.active {
  background-color: #34495e;
}

.main-content {
  flex: 1;
  padding: 20px;
  background-color: #f5f6fa;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-info img {
  border-radius: 50%;
}

.stats-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card h3 {
  margin: 0;
  color: #666;
  font-size: 14px;
}

.card .number {
  font-size: 24px;
  font-weight: bold;
  margin: 10px 0;
}

.trend {
  font-size: 12px;
  padding: 4px 8px;
  border-radius: 4px;
}

.trend.positive {
  background-color: #e3f9e5;
  color: #1b4332;
}

.trend.negative {
  background-color: #ffe3e3;
  color: #c92a2a;
}

.recent-orders {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  font-weight: 600;
  color: #666;
}

.status {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
}

.status.completed {
  background-color: #e3f9e5;
  color: #1b4332;
}

.status.pending {
  background-color: #fff3cd;
  color: #856404;
}

.status.cancelled {
  background-color: #ffe3e3;
  color: #c92a2a;
}
</style>