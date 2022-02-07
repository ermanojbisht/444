{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')
@section('styles')
    <link href="{{ asset('../css/admin-kit-light.css') }}" rel="stylesheet" />
    <style>
        .select2-selection__rendered {
            line-height: 18px !important;
        }

        .table> :not(:last-child)> :last-child>*,
        .table tbody,
        .table td,
        .table tfoot,
        .table th,
        .table thead,
        .table tr {
            border-color: transparent !important;
        }

        .tab .nav-tabs .nav-link.active {
            background: #3b7ddd;
            border-bottom-color: #3b7ddd;
            color: #fff;
        }

        .tab .tab-content,
        .tab .nav-tabs .nav-link {
            border: 1px solid #E9ECEF;
        }
    </style>
@endsection

@section('headscripts')
    <script src="{{ asset('../js/go/go.js') }}"></script>
@endsection

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
     View Estimate Detail
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
       ['datas'=> [
            ['label'=>'Estimate','route'=>'myInstances','routefielddata'=>['field1'=>1,'field2'=>2],'active'=>false],
            ['label'=>'Estimate ID -'.$instanceEstimate->id,'active'=>false],
            ['label'=>'View Estimate Detail','active'=>true],

    ]])
@endsection


@section('content')

<div class="container-fluid">
    <div class="card">
            <form>
                @csrf
                <div class="row">
                    <div class="col-md-12"> {{-- col-md-4 offset-md-1 --}}
                        <div class="card-body">
                            <div class="example">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-coreui-toggle="tab" href="#estimate-info" toCall="estimate-info"
                                            role="tab" aria-selected="true">
                                            {{ $instance->type->name }} Details </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-coreui-toggle="tab" href="#estimate-movement"  toCall="estimate-movement"
                                            role="tab" aria-selected="false">
                                            {{ $instance->type->name }} Movements
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content rounded-bottom">
                                    <div class="tab-pane p-3   active" role="tabpanel" id="estimate-info">
                                        <h4 class="tab-title"> </h4>
                                        <div class="form-group">
                                            @if($instanceEstimate)
                                                @include("track.estimate.partial._EstimateInfo",[
                                                'instance' => $instance,
                                                'addDetails' => true,
                                                'instanceEstimate' => $instanceEstimate,
                                                'blocks' => $instance_blocks,
                                                'Constituencies' => $instance_constituencies 
                                                ])
                                            @else
                                                @include("track.estimate.partial._EstimateInfo",[ 
                                                'instance' => $instance,
                                                'addDetails' => false
                                                ])
                                            @endif
                                            <h4 class="text-danger"> Estimate Deatils are yet to be filled </h4>
                                        </div>
                                    </div>
                                    <div class="tab-pane pt-1" role="tabpanel" id="estimate-movement">
                                        <div class="row">
                                            <table style="border-collapse: separate;" id="estimateReport"
                                                class="table table-bordered dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th> #</th>
                                                        <th> Created At</th>
                                                        <th> Sender</th>
                                                        <th> Receiver</th>
                                                        <th> Remark</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3   active" role="tabpanel" id="estimate-info">

                                    </div> 

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="myDiagramDiv"
                            style="background-color: whitesmoke; border: solid 1px black; width: 100%; height: 400px">
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>
@endsection

@section('footscripts')


<script type="text/javascript">
    $("#myTab li a").on("click", function (e) { 
      let tabId = $(this).attr("toCall");
      switch (tabId) {
        case "estimate-info":
            break;

        case "estimate-movement":
            getEstimateMovement();
            break;
            
        case "estimate-details":
            break;
      }
    });


    function getEstimateMovement()
    {

        $('#estimateReport').DataTable().destroy();

        var instanceId = {!!html_entity_decode($instance->id)!!}; // 
        var _token = $('input[name="_token"]').val();

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        let dtOverrideGlobals = {
        responsive: true,
        buttons: dtButtons,
        aaSorting : [],
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{route('estimate.ajaxDataForEstimateMovements')}}",
            method: "POST",
            data: {
                instanceId : instanceId,
                _token: _token
            }
        },
        columns:[            
            {"data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }}, 

                {data :"created_at",
                "defaultContent": "0", 
                "render": function (data) {
                    var date = new Date(data);
                    var month = date.getMonth() + 1;
                    return (month.toString().length > 1 ? month : "0" + month) + " / " + date.getDate() + " / " + date.getFullYear();
                }},

                { data: "sender.name", 
                "defaultContent": "0", orderable: false},

                { data: "receiver.name", 
                "defaultContent": "0", orderable: false },

                { data: "remarks", 
                "defaultContent": "0" }
        ],

        orderCellsTop: false,
        order: [[ 1, 'asc' ]],
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
                'pageLength','copy', 'csv', 'excel', 'pdf', 'print'               
            ],
        columnDefs: [
            { orderable: false }
                /*  { "visible": false, "targets": [9,11,12,13] },*/
                //{'max-width': '10%', 'targets': 0},
            ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "scrollX": false,
        "sScrollX": "100%"

        };

        let table = $('#estimateReport').DataTable(dtOverrideGlobals);
        $('.datatable thead').on('input', '.search', function () {
        let strict = $(this).attr('strict') || false
        let value = strict && this.value ? "^" + this.value + "$" : this.value
        table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
        });

    }


    function show_Registred_users(moveToType) {
        $(".selector").css("background-color", "white");
        $(".move_to").css("display", "none");

        $("." + moveToType).css("display", "block");

        $(".tblSelection").css("background-color", "lavender");
        $("." + moveToType + "-selector").css("background-color", "lavender");
    }

    function getEmployeeDesignationWise() {
        var designation = $("#designation").val();
        var _token = $('input[name="_token"]').val();
        if (designation > 0) {
            $.ajax({
                url: "{{ route('getEmployeeDesignationWise') }}",
                method: "POST",
                data: {
                    designation: designation,
                    _token: _token
                },
                success: function (data) {
                    bindDdlWithData("employees", data, "id", "name", false, "0", "Find employees");
                    $('#employees').val("");
                }
            });
        }
    }
</script>


@include('jsbundle.datatablefor5',['button'=>true])


@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')

<script id="code">
    $(document).ready(function () {
            var nodeDataArray = {!!html_entity_decode($receivers)!!}  //
            var linkDataArray = {!!html_entity_decode($remarks)!!}
            init(nodeDataArray);
        });


        function init(nodeDataArray) {

            var $ = go.GraphObject.make;  // for conciseness in defining templates
            myDiagram =
                $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
                    {
                        initialAutoScale: go.Diagram.Uniform,  // an initial automatic zoom-to-fit
                        contentAlignment: go.Spot.Center,  // align document to the center of the viewport
                        layout:
                            $(go.ForceDirectedLayout,  // automatically spread nodes apart
                                {defaultSpringLength: 10, defaultElectricalCharge: 50}),
                        "undoManager.isEnabled": true
                    });


            var colourType = {0: "rgb(254, 201, 0)", 1: "rgb(254, 162, 0)"};

            if (nodeDataArray[nodeDataArray.length - 1]) {
                colourType = {0: "red", 1: "white"};
            }

            // define each Node's appearance
            myDiagram.nodeTemplate =
                $(go.Node, "Auto",  // the whole node panel
                    {locationSpot: go.Spot.Center},
                    // define the node's outer shape, which will surround the TextBlock
                    $(go.Shape, "Ellipse",
                        {fill: $(go.Brush, "Linear", colourType), stroke: "black"}),
                    $(go.TextBlock,
                        {font: "bold 10pt helvetica, bold arial, sans-serif", margin: new go.Margin(4, 4, 3, 20)},
                        new go.Binding("text", "text"))
                );

            // replace the default Link template in the linkTemplateMap
            myDiagram.linkTemplate =
                $(go.Link, go.Link.Bezier,  // the whole link panel
                    {reshapable: true},  // users can reshape the link route
                    $(go.Shape,  // the link shape
                        {stroke: "Black", strokeWidth: 2}
                        , new go.Binding("stroke", "inStatus")
                        , new go.Binding("pathPattern", "patt", convertPathPatternToShape)
                    ),
                    $(go.Shape,  // the arrowhead
                        {toArrow: "standard", stroke: null, scale: 1.5}),
                    $(go.Panel, "Auto",
                        $(go.Shape,  // the label background, which becomes transparent around the edges
                            {
                                fill: $(go.Brush, "Radial", {
                                    0: "rgb(240, 240, 240)",
                                    0.3: "rgb(240, 240, 240)",
                                    1: "rgba(240, 240, 240, 0)"
                                }),
                                stroke: null
                            }),
                        $(go.TextBlock,  // the label text
                            {
                                textAlign: "center",
                                font: "10pt helvetica, arial, sans-serif",
                                stroke: "#555555",
                                margin: 4
                            },
                            new go.Binding("text", "text"))
                    )
                );

            // Conversion functions that make use of the PathPatterns store of pattern Shapes
            function convertPathPatternToShape(name) {
                if (!name) return null;
                return PathPatterns.getValue(name);
            }

            function colorAsPerInStatus(inStatus) {
                var color1 = "Black";
                if (inStatus == 0) {
                    color1 = "Blue";
                } else {
                    color1 = "Orange";
                }
                return color1
                //return (inStatus==0)?'Blue':'Orange';
            }

            // Define a bunch of small Shapes that can be used as values for Shape.pathPattern
            var PathPatterns = new go.Map('string', go.Shape);

            function definePathPattern(name, geostr, color, width, cap) {
                if (typeof name !== 'string' || typeof geostr !== 'string') throw new Error("invalid name or geometry string argument: " + name + " " + geostr);
                if (color === undefined) color = "black";
                if (width === undefined) width = 1;
                if (cap === undefined) cap = "square";
                PathPatterns.add(name,
                    $(go.Shape,
                        {
                            geometryString: geostr,
                            fill: "transparent",
                            stroke: color,
                            strokeWidth: width,
                            strokeCap: cap
                        }
                    ));
            }

            definePathPattern("Tshape1", "M0 0 L9 4 0 8z", "Red", 0.4);
            definePathPattern("Tshape2", "M0 0 L9 4 0 8z", "Green", 0.4);

            myDiagram.nodeTemplateMap.add("token",
                $(go.Part,
                    {locationSpot: go.Spot.Center, layerName: "Foreground"},
                    $(go.Shape, "XLine",
                        {width: 1, height: 1, fill: "green", strokeWidth: 0},
                        new go.Binding("fill", "color")),

                    $(go.Picture,
                        {width: 64, height: 64},
                        {
                            sourceCrossOrigin: function (pict) {
                                return "use-credentials";
                            }
                        },
                        new go.Binding("source", "path")),
                        $(go.TextBlock,  // the label text
                        {
                            textAlign: "center",
                            font: "15pt helvetica, arial, sans-serif",
                            stroke: "#555555",
                            margin: 4
                        },
                        new go.Binding("text", "comm")
                    )
                ));



                initTokens();

            var linkDataArray = {!!html_entity_decode($remarks)!!};
            myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);

        }


        function initTokens() {
            myDiagram.model.addNodeDataCollection([
                {
                    category: 'token',
                    //rec_id: 'f236p16307Mar2017155125',
                    //at: 1,
                    // ato: 0,
                    color: 'green' // ,
                    //steps: 4,
                    //path: '../../images/01R.png',
                    //comm: '',
                    //id: 1,
                    //face: 1
                }
            ]);
            myReq = window.requestAnimationFrame(updateTokens);
        }

        function updateTokens() {
            myDiagram.parts.each(function (token) {
                var dataToken = token.data;

                var rec_id = dataToken.rec_id;
                var at = dataToken.at;
                var face = dataToken.face;
                var movInsId = dataToken.id;
                var frac = dataToken.frac;
                var next = dataToken.next;
                var key1 = token.data.key;
                var model = myDiagram.model;
                key1 = (key1 * (-1)) - 1;
                var dataFileIns = myDiagram.model.nodeDataArray[key1];  // get the node data

                var str = dataFileIns.path;
                var res = str.substring(7, 9);
                var leftright = (dataToken.face == 1) ? "R" : "L";
                if (dataToken.id <= dataToken.steps) {
                    switch (res) {
                        case '01':
                            str = "../../images/02" + leftright + ".png";
                            break;
                        case '02':
                            str = "../../images/03" + leftright + ".png";
                            break;
                        case '03':
                            str = "../../images/04" + leftright + ".png";
                            break;
                        case '04':
                            str = "../../images/05" + leftright + ".png";
                            break;
                        case '05':
                            str = "../../images/06" + leftright + ".png";
                            break;
                        case '06':
                            str = "../../images/07" + leftright + ".png";
                            break;
                        case '07':
                            str = "../../images/08" + leftright + ".png";
                            break;
                        case '08':
                            str = "../../images/09" + leftright + ".png";
                            break;
                        case '09':
                            str = "../../images/10" + leftright + ".png";
                            break;
                        case '10':
                            str = "../../images/01" + leftright + ".png";
                            break;
                        default:

                    }
                }

                model.setDataProperty(dataFileIns, "path", str);


                if (at === undefined) return;
                var from = myDiagram.findNodeForKey(at);
                if (from === null) return;
                var to = myDiagram.findNodeForKey(next);
                if (frac === undefined) frac = 0.0;
                if (dataToken.id > dataToken.steps) return;

                if (to === null)// nowhere to go?
                {
                    positionTokenAtNode(token, from);  // temporarily stay at the current node
                    var newloc = chooseDestination(movearr, rec_id, movInsId, token, from);
                    if (newloc.length > 0) {
                        dataToken.next = newloc[0].e;  // and decide where to go next
                        model.setDataProperty(dataFileIns, "a", newloc[0].c);
                    }
                    dataToken.id = movInsId + 1;

                } else // proceed toward the
                {
                    var link = from.findLinksTo(to).first();
                    if (link !== null) {
                        // assume straight lines, for now
                        var start = link.getPoint(0);
                        var end = link.getPoint(link.pointsCount - 1);
                        if (start.x > end.x) {
                            face = 0;
                        } else {
                            face = 1;
                        }

                        model.setDataProperty(dataFileIns, "face", face);
                        var x = start.x + frac * (end.x - start.x);
                        var y = start.y + frac * (end.y - start.y);
                        token.location = new go.Point(x, y);
                    } else {  // stay at the current node
                        positionTokenAtNode(token, from);
                    }

                    if (frac >= 1.0) {  // if beyond the end, it's "AT" the NEXT node
                        dataToken.frac = 0.0;
                        dataToken.at = next;
                        dataToken.next = undefined;  // don't know where to go next
                    } else {  // otherwise, move fractionally closer to the NEXT node
                        dataToken.frac = frac + 0.01;
                    }
                }
            });
            //console.log('face_change'+face1);
            myReq = window.requestAnimationFrame(updateTokens);
        }

        function chooseDestination(fileMoveProcess, rec_id, id, token, node) {
            //console.log("chooseDestination function got id="+id);
            var t = [];
            var processId = id;
            var t = search(fileMoveProcess, rec_id, processId);
            return t;

        }

        function search(array, rid, sid) {
            //console.log("search function got id="+sid);
            var filtered = [];
            var yp = [];
            for (var i = 0; i < array.length; i++) {
                var item = array[i];
                if (item.rec_id == rid) {
                    for (j = 0; j < item.yp.length; j++) {
                        if (item.yp[j].id == sid) {
                            filtered.push(item.yp[j]);
                        }
                    }
                }
            }
            return filtered;

        }

        // determine where to position a token when it is resting at a node
        function positionTokenAtNode(token, node) {
            // these details depend on the node template
            token.location = node.position.copy().offset(4 + 6, 5 + 6);
        }

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function reload_dd1(form) {
            var val1 = form.dd1.options[form.dd1.options.selectedIndex].value;
            var val2 = form.recid.value;
            var val3 = form.sl.value;
            var val4 = form.ec.value;
            self.location = 'instancepath.php?dd1=' + val1
                + '&recid=' + val2
                + '&sl=' + val3
                + '&ec=' + val4;
        }
</script>

@endsection
