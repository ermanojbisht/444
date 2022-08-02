@extends('layouts.type200.main')

@section('pagetitle')
	Marks
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
@endsection
@section('styles')
<style type="text/css">
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
@endsection
@section('content')
<div id="chartdiv"></div>
{{-- <form class="form-horizontal" method="POST" action="{{route('acr.analysis.marksChart')}}">
      @csrf
      <select id="steps">
        <option value="2">2</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
      </select>
</form> --}}
@endsection
@section('footscripts')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('#steps').change(function() {
            this.form.submit();
        });
    });

  am5.ready(function() {
  
  var root = am5.Root.new("chartdiv");
      root.setThemes([
        am5themes_Animated.new(root)
      ]);
  
  var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX:true
      }));

  var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
      cursor.lineY.set("visible", false);

  var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
      xRenderer.labels.template.setAll({
        rotation: -45,
        centerY: am5.p50,
        centerX: am5.p100,
        paddingRight: 15
      });

  var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "range",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
              }));

  var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
              maxDeviation: 0.3,
              renderer: am5xy.AxisRendererY.new(root, {})
            }));
  var yAxis2 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
              maxDeviation: 0.3,
              renderer: am5xy.AxisRendererY.new(root, {})
            }));

  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "No of Employee",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "count",
                sequencedInterpolation: true,
                categoryXField: "range",
                tooltip: am5.Tooltip.new(root, {
                  labelText:"{valueY} Employee \n average {average}"
                }),
                maskBullets: false
              }));  
  
      series.columns.template.setAll({ cornerRadiusTL: 50, cornerRadiusTR: 50 });
      //series.columns.template.propertyFields.fill = "colour";
      //series.columns.template.propertyFields.fill = "{color}";

      series.columns.template.adapters.add("fill", function(fill, target) {
        return target.dataItem.dataContext.color;
      });

      series.columns.template.adapters.add("stroke", function(stroke, target) {
        return target.dataItem.dataContext.color;
      });

      series.bullets.push(function() {
        return am5.Bullet.new(root, {
          locationX: 0.5,
          locationY: 1,
          sprite: am5.Circle.new(root, {
            radius: 25,
            fill: am5.color(0x900C3F)
          })
        });
      });

      series.bullets.push(function(root) {
        return am5.Bullet.new(root, {
          locationX: 0.5,
          locationY: 1,
          sprite: am5.Label.new(root, {
            text: "{percent}%",
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            fill: am5.color(0xffffff),
            populateText: true
          })
        });
      });


 /* var series2 = chart.series.push(am5xy.LineSeries.new(root, {
                name: "No of Employee",
                xAxis: xAxis,
                yAxis: yAxis2,
                valueYField: "average",
                sequencedInterpolation: true,
                categoryXField: "range",
                tooltip: am5.Tooltip.new(root, {
                  labelText:"{valueY}"
                })
              }));
*/

  var data = <?php echo json_encode($data);?>
 
  xAxis.data.setAll(data);
  series.data.setAll(data);
  //series2.data.setAll(data);


  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear(1000);
  chart.appear(1000, 100);

  }); // end am5.ready()
</script>
</script>
@endsection
