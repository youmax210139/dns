<template>
  <div class>
    <div class="row">
      <!-- Progress -->
      <div class="col-12">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">{{ __("usage_period_avg") }}</h4>
          </div>
          <div class="card-body d-flex">
            <div v-for="(item, index) in doughnuts" :key="index" class="mx-3">
              <progress-circle :key="index" :percentage="item" />
            </div>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <!-- Bar -->
      <div class="col-12">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">{{ __("avaliablity") }}</h4>
          </div>
          <div class="card-body">
            <bar-chart :chartdata="bar.chartdata" :options="bar.options" />
            />
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <!-- Line -->
      <div class="col-12">
        <div class="card card-chart">
          <div class="card-header">
            <h4 class="card-title">{{ __("avg_response_time") }}</h4>
          </div>
          <div class="card-body">
            <line-chart :chartdata="line.chartdata" :options="line.options" />
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <data-table
          ref="statusDataTable"
          :fields="statusFields"
          :api-url="route('domains.index', { status: ['>=', '400'] }).url()"
          :filterMode="false"
        >
          <template v-slot:header>
            <h5 class="card-title">{{ __("domain_status_alert") }}</h5>
          </template>
          <template v-slot:name="props">
            <a
              name="name"
              :href="urlTransform(props.rowData.name)"
              target="_blank"
              >{{ props.rowData.name }}</a
            >
          </template>
          <template v-slot:protocols="props">
            <span
              v-for="(protocol, index) in props.rowData.protocols"
              :key="index"
              class="badge badge-info"
            >
              {{ protocol }}
            </span>
          </template>
          <template v-slot:status_code="props">
            <span
              v-for="(protocol, _) in props.rowData.protocols"
              :key="protocol"
              :class="
                `badge-` + getStatusClass(props.rowData.status_code[protocol])
              "
              class="badge"
              >{{ props.rowData.status_code[protocol] }}</span
            >
          </template>
        </data-table>
      </div>
    </div>

    <div class="row">
      <div :key="key" class="col-12 col-lg-4" v-for="(expiration, key) in expiration">
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
import BarChart from "@/Shared/Charts/Bar";
import LineChart from "@/Shared/Charts/Line";
import ProgressCircle from "@/Shared/Progress/Circle";
import DataTable from "@/Shared/Tables/DataTable";

export default {
  components: {
    BarChart,
    LineChart,
    ProgressCircle,
    DataTable,
  },
  props: {
    doughnuts: Array,
    bar: Object,
    line: Object,
    domains: Object,
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
    refresh() {
      this.$refs.statusDataTable.reload();
    },
  },
  mounted() {
    this.timer = setInterval(this.refresh, 60 * 1000);
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>
