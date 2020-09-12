<script>
import { Doughnut } from "vue-chartjs";

export default {
  extends: Doughnut,
  props: {
    labels: {
      type: Array,
      default: () => ["Babol", "Cabanatuan", "Daegu", "Jerusalem"],
    },
    data: {
      type: Array,
      default: () => [1000, 500, 1500, 1000],
    },
    datasets: {
      type: Object,
      default: function () {
        return {
          borderWidth: 1,
          borderColor: [
            "rgba(255,99,132,1)",
            "rgba(54, 162, 235, 1)",
            "rgba(255, 206, 86, 1)",
            "rgba(75, 192, 192, 1)",
          ],
          backgroundColor: [
            "rgba(255, 99, 132, 0.2)",
            "rgba(54, 162, 235, 0.2)",
            "rgba(255, 206, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(153, 102, 255, 0.2)",
          ],
        };
      },
    },
    options: {
      type: Object,
      default: function () {
        return {
          legend: {
            display: true,
          },
          responsive: true,
          maintainAspectRatio: false,
        };
      },
    },
  },
  mounted() {
    this.renderChart(
      {
        labels: this.labels,
        datasets: [
          {
            ...this.datasets,
            data: this.data,
          },
        ],
      },
      this.options
    );
  },
};
</script>