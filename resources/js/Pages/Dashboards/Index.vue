<template>
  <div class>
    <div class="row">
      <div class="col-lg-4">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">Platform Doughnut</h4>
          </div>
          <div class="card-body">
            <doughnut-chart :labels="doughnut.labels" :data="doughnut.data" :height="190" />
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
          <div class="card-header">
            <!-- <h5 class="card-category">Email Statistics</h5> -->
            <h4 class="card-title">All Platforms</h4>
            <!-- <div class="dropdown">
              <button
                type="button"
                class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret"
                data-toggle="dropdown"
              >
                <i class="now-ui-icons loader_gear"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <a class="dropdown-item text-danger" href="#">Remove Data</a>
              </div>
            </div>-->
          </div>
          <div class="card-body">
            <line-chart :height="190" :labels="doughnut.labels" :data="doughnut.data"/>
          </div>
          <div class="card-footer">
            <!-- <div class="stats">
              <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
            </div>-->
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">Domain Amount of Platform </h4>
          </div>
          <div class="card-body">
            <bar-chart :height="190" :labels="doughnut.labels" :data="doughnut.data"/>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div v-for="(domain, key) in domains" :key="key" class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Expired in {{ key }}</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>Platform</th>
                  <th>Name</th>
                  <th>Expired At</th>
                </thead>
                <tbody>
                  <tr v-for="d in domain" :key="d.id">
                    <td>{{ d.platform_name }}</td>
                    <td>{{ d.name }}</td>
                    <td>{{ d.expired_at }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BarChart from "@/Shared/Charts/BarChart";
import LineChart from "@/Shared/Charts/LineChart";
import DoughnutChart from "@/Shared/Charts/DoughnutChart";
export default {
  components: {
    BarChart,
    LineChart,
    DoughnutChart,
  },
  props: {
    domains: Object,
    doughnut: Object,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>
