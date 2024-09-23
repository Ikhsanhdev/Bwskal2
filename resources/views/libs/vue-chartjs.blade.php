@section('jsAfterMain')
  <script src="//unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
  <script>
    Vue.component('pie-chart', {
      extends: VueChartJs.Pie,
      props: ['options'],
      mixins: [VueChartJs.mixins.reactiveProp],
      mounted () {
        this.renderChart(this.chartData, this.options)
      }
    });
    Vue.component('bar-chart', {
      extends: VueChartJs.Bar,
      props: ['options'],
      mixins: [VueChartJs.mixins.reactiveProp],
      mounted () {
        this.renderChart(this.chartData, this.options)
      }
    });
  </script>
  @parent
@endsection