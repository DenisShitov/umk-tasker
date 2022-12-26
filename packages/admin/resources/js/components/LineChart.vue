<template>
  <canvas :id="id"></canvas>
</template>

<script>
  import { onMounted, onUpdated } from 'vue'
  import { Chart, LineElement, PointElement, LineController, CategoryScale, LinearScale, Filler, Tooltip } from 'chart.js'

  export default {
    props: {
      id: String,
      data: Object,
      backgroundColor: String,
      borderColor: String,
      tooltipLabel: String,
    },

    setup(props) {
      Chart.register(LineElement, PointElement, LineController, CategoryScale, LinearScale, Filler, Tooltip)

      let myChart = {}

      onMounted(function () {
        myChart = new Chart(document.getElementById(props.id), config)
      })

      onUpdated(function() {
        myChart.data.datasets[0].data = props.data
        myChart.update()
      })

      const data = {
        datasets: [{
          label: props.tooltipLabel,
          backgroundColor: props.backgroundColor,
          borderColor: props.borderColor,
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: 'white',
          fill: true,
          data: props.data,
        }]
      }

      const config = {
        type: 'line',
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
            elements: {
              point: {
                pointStyle: 'cross',
                backgroundColor: 'blue',
                borderColor: 'black',
              },
            },

            tooltip: {
              usePointStyle: true,
              callbacks: {
                // label: function(context) {
                //   const label = context.dataset.label || '';
                //   console.log(label)
                //   console.log( context.parsed.y )

                //   if (label) {
                //       label += ': ';
                //   }
                //   if (context.parsed.y !== null) {
                //       label += context.parsed.y + ' Hours'
                //   }
                //   return label;
                // }
              }
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: {
                // display: false
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                // display: false
              }
            }
          }
        }
      }
    }
  }
</script>
