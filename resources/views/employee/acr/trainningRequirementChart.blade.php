@extends('layouts.type200.main')

@section('pagetitle')
	Training Selected by Employees
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
	@endsection

@section('content')
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/hierarchy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create wrapper container
var container = root.container.children.push(
  am5.Container.new(root, {
    width: am5.percent(100),
    height: am5.percent(100),
    layout: root.verticalLayout
  })
);

// Create series
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
var series = container.children.push(
  am5hierarchy.Treemap.new(root, {
    singleBranchOnly: false,
    downDepth: 1,
    upDepth: -1,
    initialDepth: 2,
    valueField: "value",
    categoryField: "name",
    childDataField: "children",
    nodePaddingOuter: 0,
    nodePaddingInner: 0
  })
);

series.rectangles.template.setAll({
  strokeWidth: 2
});

// Generate and set data
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data
var maxLevels = 2;
var maxNodes = 10;
var maxValue = 100;

//var data = 
var data = {
  name: "Root",
  children: <?php echo json_encode($data); ?>
};

series.data.setAll([data]);
series.set("selectedDataItem", series.dataItems[0]);

// Make stuff animate on load
series.appear(1000, 100);

}); // end am5.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>
@endsection
@section('footscripts')

@endsection
