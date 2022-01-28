@extends('layouts.type200.main')

@section('headscripts')
    <script src="{{ asset('../js/go/go.js') }}"></script> 
@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0, 'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('pagetitle')
     View Estimate Detail
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0,'instance_id'=>$instanceEstimate->instance_id])
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
    <div class="card-body">
      <div class="row">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link " data-coreui-toggle="tab" href="#preview-929" role="tab" aria-selected="true">
                       General Detail 
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-coreui-toggle="tab" href="#code-929" role="tab" aria-selected="false">
                        Movement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-coreui-toggle="tab" href="#code-123" role="tab" aria-selected="false">
                        Chart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-coreui-toggle="tab" href="#Images" role="tab" aria-selected="false">
                        Images
                    </a>
                </li>
                </ul>
                <div class="tab-content rounded-bottom">
                    <div class="tab-pane p-3 preview " role="tabpanel" id="preview-929">
                      
                        <div class="row align-items-center">
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
                                <h4 class="text-danger"> Estimate Deatils are yet to be filled </h4>
                            @endif
                        </div>

                     </div>

                    <div class="tab-pane pt-1" role="tabpanel" id="code-929">
                        <div class="card table-responsive">
                            <div class="card-body">
                                <table id="user_Request_Details" class="table border caption-top">
                                    <caption class="fs-4">Movement History</caption>
                                    <thead class="table-light fw-bold">
                                        <tr class="align-middle text-center">
                                            <th>#</th>
                                            <th>Send By</th>
                                            <th>Sent to</th>
                                            <th>on Date</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($count=1)
                                        @foreach($instance->history as $history)
                                        <tr>
                                            <td>{{$count}} </td>
                                            <td>{{$history->sender->name}} ({{$history->sender->designation}})
                                            </td>
                                            <td>{{$history->emp_name}} ({{$history->designation}})
                                            </td>
                                            <td>{{$history->created_at->format('d / m / Y') }}</td>
                                            <td>{{$history->remarks}}</td>
                                            <td> {{($history->action_taken == 0) ? "Moved" : "Forwarded" }} </td>
                                        </tr>
                                        @php($count++)
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                    <div class="tab-pane pt-2 active" role="tabpanel" id="code-123">
                        <div id="myDiagramDiv" style="background-color: whitesmoke; border: solid 1px black; width: 100%; height: 400px"></div>
                    </div>
                    <div class="tab-pane p-3" role="tabpanel" id="Images">
                        @include("track.estimate.partial._Images",[ 'images' => $images])
                    </div>
                </div>

                 


            </div>
        </div>
    </div>
@endsection

@section('footscripts')

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
