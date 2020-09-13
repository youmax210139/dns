<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  props: {
    labels: {
      type: Array,
      default: () => [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
    },
    laebl: {
      type: String,
      default: "Active Countries",
    },
    data: {
      type: Array,
      default: () => [80, 99, 86, 96, 123, 85, 100, 75, 88, 90, 123, 155],
    },
    datasets: {
      type: Object,
      default: function () {
        return {
          borderColor: "#2CA8FF",
          pointBorderColor: "#FFF",
          pointBackgroundColor: "#2CA8FF",
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          borderWidth: 1,
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
          responsive: 1,
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
      gradient.addColorStop(1, "rgba(44, 168, 255, 0.6)");
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