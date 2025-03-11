<script>
function renderChart($id){
  const ctx = document.getElementById($id);

  new Chart(ctx, {
    type: '{{$grafico->tipo}}',
    data: {
      labels: [{!!$labels!!}],
      datasets: [{
        label: '{{$grafico->nome}}',
        data: [{!!$data!!}],
        borderWidth: 1,
        barThickness: 'flex',
        maxBarThickness: 90,
        categoryPercentage: 1,
        minBarLength: 20,
      }]
    },
    options: {
      indexAxis: '{{$grafico->axis}}',
      scales: {
        y: {
          beginAtZero: true
        }
      },
    }
  });
}

renderChart("chart_id_{{$grafico->id}}")
</script>