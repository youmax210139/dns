<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  props: {
    labels: {
      type: Array,
      default: () => [
        "12pm,",
        "3pm",
        "6pm",
        "9pm",
        "12am",
        "3am",
        "6am",
        "9am",
      ],
    },
    label: {
      type: String,
      default: "Active Countries",
    },
    data: {
      type: Array,
      default: () => [40, 500, 650, 700, 1200, 1250, 1300, 1900],
    },
    datasets: {
      type: Object,
      default: function () {
        return {
          borderColor: "#18ce0f",
          pointBorderColor: "#FFF",
          pointBackgroundColor: "#18ce0f",
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          borderWidth: 2,
        };
      },
    },
    options: {
      type: Object,
      default: function () {
        return {
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          responsive: true,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
                gridLines: {
                  zeroLineColor: "transparent",
                  drawBorder: false,
                  display: true,
                },
              },
            ],
            xAxes: [
              {
                ticks: {
                  display: false,
                },
                gridLines: {
                  zeroLineColor: "transparent",
                  drawTicks: false,
                  display: false,
                  drawBorder: false,
                },
              },
            ],
          },
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 15,
              bottom: 15,
            },
          },
        };
      },
    },
  },
  computed: {
    backgroundColor: function () {
      let gradient = this.$refs.canvas
        .getContext("2d")
        .createLinearGradient(0, 170, 0, 50);
      gradient.addColorStop(0, "rgba(128, 182, 244, 0)");
      gradient.addColorStop(1, "rgb(24, 206, 15, 0.6)");
      return gradient;
    },
  },
  mounted() {
    this.renderChart(
      {
        labels: this.labels,
        datasets: [
          {
            ...this.datasets,
            backgroundColor: this.backgroundColor,
            label: this.label,
            data: this.data,
          },
        ],
      },
      this.options
    );
  },
};
</script>