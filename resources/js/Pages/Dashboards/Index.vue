<template>
  <div class>
    <div class="row">
      <div class="col-lg-4">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">{{ __("platform_percentage") }}</h4>
          </div>
          <div class="card-body">
            <doughnut-chart
              :labels="doughnut.labels"
              :data="doughnut.data"
              :height="190"
            />
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
          <div class="card-header">
            <!-- <h5 class="card-category">Email Statistics</h5> -->
            <h4 class="card-title">{{ __("platform_line") }}</h4>
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
            <line-chart
              :height="190"
              :labels="doughnut.labels"
              :data="doughnut.data"
            />
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
            <h4 class="card-title">{{ __("platform_bar") }}</h4>
          </div>
          <div class="card-body">
            <bar-chart
              :height="190"
              :labels="doughnut.labels"
              :data="doughnut.data"
            />
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <data-table
          :fields="statusFields"
          :api-url="route('domains.index', { status: ['!=','200'] }).url()"
          :filterMode="false"
        >
          <template v-slot:header>
            <h5 class="card-title">{{ __('domain_status_alert') }}</h5>
          </template>
          <template v-slot:name="props">
            <a
              name="name"
              :href="urlTransform(props.rowData.name)"
              target="_blank"
              >{{ props.rowData.name }}</a
            >
          </template>

          <template v-slot:http_status_code="props">
            <span
              name="http_status_code"
              :class="getStatusClass(props.rowData.http_status_code)"
              >{{ props.rowData.http_status_code }}</span
            >
          </template>
        </data-table>
      </div>
    </div>

    <div class="row">
      <div :key="key" class="col-12" v-for="(expiration, key) in expiration">
        <data-table
          :fields="expirationFields"
          :api-url="route('domains.index', { expired: expiration }).url()"
          :filterMode="false"
        >
          <template v-slot:header>
            <h5 class="card-title">{{ __(`expired_in_${key}`) }}</h5>
          </template>
          <template v-slot:name="props">
            <a
              name="name"
              :href="urlTransform(props.rowData.name)"
              target="_blank"
              >{{ props.rowData.name }}</a
            >
          </template>
        </data-table>
      </div>
    </div>
  </div>
</template>

<script>
import BarChart from "@/Shared/Charts/BarChart";
import LineChart from "@/Shared/Charts/LineChart";
import DoughnutChart from "@/Shared/Charts/DoughnutChart";
import DataTable from "@/Shared/Tables/DataTable";

export default {
  components: {
    BarChart,
    LineChart,
    DoughnutChart,
    DataTable,
  },
  props: {
    domains: Object,
    doughnut: Object,
    expirationFields: Array,
    statusFields: Array,
  },
  data() {
    return {
      expiration: {
        week: window.moment().add(7, "d").format("YYYY-MM-DD hh:mm:ss"),
        month: window.moment().add(1, "M").format("YYYY-MM-DD hh:mm:ss"),
        season: window.moment().add(3, "M").format("YYYY-MM-DD hh:mm:ss"),
      },
    };
  },
  methods: {
    getStatusClass(code) {
      if (code >= 200 && code < 300) {
        return { "text-success": true };
      } else if (code >= 300 && code < 400) {
        return { "text-info": true };
      } else if (code >= 400 && code < 500) {
        return { "text-danger": true };
      } else if (code >= 500 && code < 600) {
        return { "text-danger": true };
      } else {
        return {};
      }
    },
  },
};
</script>
