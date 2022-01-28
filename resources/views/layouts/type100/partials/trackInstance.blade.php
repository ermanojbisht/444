<div class="">

    {{--
    <link href="{{ asset('../plugins/go/style.css') }}" rel="stylesheet"> --}}


    <script src="{{ asset('../plugins/go/go.js') }}"></script>

    @if (Auth::guest())
    @else
    @endif



    <body onload="init()">


        <div id="myDiagramDiv"
            style="background-color: whitesmoke; border: solid 1px black; width: 100%; height: 400px"></div>

        <span><button onclick="reTokens()">repeat animation</button></span>
    </body>
</div>



<script id="code">
    function init() {
      
      var $ = go.GraphObject.make;  // for conciseness in defining templates
      myDiagram =
        $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
          {
            initialAutoScale: go.Diagram.Uniform,  // an initial automatic zoom-to-fit
            contentAlignment: go.Spot.Center,  // align document to the center of the viewport
            layout:
              $(go.ForceDirectedLayout,  // automatically spread nodes apart
                { defaultSpringLength: 30, defaultElectricalCharge: 100 }),
            "undoManager.isEnabled": true
          });
  
      // define each Node's appearance
      myDiagram.nodeTemplate =
        $(go.Node, "Auto",  // the whole node panel
          { locationSpot: go.Spot.Center },
          // define the node's outer shape, which will surround the TextBlock
          $(go.Shape, "RoundedRectangle",
            { fill: $(go.Brush, "Linear", { 0: "rgb(254, 201, 0)", 1: "rgb(254, 162, 0)" }), stroke: "black" }),
          $(go.TextBlock,
            { font: "bold 10pt helvetica, bold arial, sans-serif", margin: new go.Margin(4, 4, 3, 20)},
            new go.Binding("text", "text"))
        );
  
      // replace the default Link template in the linkTemplateMap
      myDiagram.linkTemplate =
        $(go.Link, go.Link.Bezier,  // the whole link panel
          { reshapable: true },  // users can reshape the link route
          $(go.Shape,  // the link shape
            { stroke: "Black",strokeWidth: 2 }
           ,new go.Binding("stroke", "inStatus")
            ,new go.Binding("pathPattern", "patt", convertPathPatternToShape)
            ),
          $(go.Shape,  // the arrowhead
            { toArrow: "standard", stroke: null,  scale: 1.5 }),
          $(go.Panel, "Auto",
            $(go.Shape,  // the label background, which becomes transparent around the edges
              { fill: $(go.Brush, "Radial", { 0: "rgb(240, 240, 240)", 0.3: "rgb(240, 240, 240)", 1: "rgba(240, 240, 240, 0)" }),
                stroke: null }),
            $(go.TextBlock,  // the label text
              { textAlign: "center",
                font: "10pt helvetica, arial, sans-serif",
                stroke: "#555555",
                margin: 4 },
              new go.Binding("text", "text"))
          )
        );
        // Conversion functions that make use of the PathPatterns store of pattern Shapes
      function convertPathPatternToShape(name) {
        if (!name) return null;
        return PathPatterns.getValue(name);
      }
      function colorAsPerInStatus(inStatus) {
          var color1="Black";
          if (inStatus==0){color1="Blue";}else{color1="Orange";}
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
      
      definePathPattern("Tshape1", "M0 0 L9 4 0 8z","Red",0.4);
      definePathPattern("Tshape2", "M0 0 L9 4 0 8z","Green",0.4);
      
      myDiagram.nodeTemplateMap.add("token",
        $(go.Part,
          { locationSpot: go.Spot.Center, layerName: "Foreground" },
          $(go.Shape, "circle",
            { width: 12, height: 12, fill: "green", strokeWidth: 0 },
            new go.Binding("fill", "color")),
            
            $(go.Picture,
           { width: 64, height: 64 },
           { sourceCrossOrigin: function(pict) { return "use-credentials"; } },
           new go.Binding("source", "path")),
            $(go.TextBlock,  // the label text
              { textAlign: "center",
                font: "15pt helvetica, arial, sans-serif",
                stroke: "#555555",
                margin: 4 }
                ,new go.Binding("text", "comm")
                )
        ));
  
      // create the model for the concept map
      var nodeDataArray = [
      { key:163, text:'Pradeep Bhatt'},{ key:0, text:'Record Room'},{ key:157, text:'Dayanand'},{ key:1392, text:'Arvind Singh Hayanki'}      
      ];
      var linkDataArray = [
      
      { from:163,to:157, text:'sir kindly process the file for payment', patt: 'Tshape2',inStatus:'Blue'},{ from:0,to:163, text:'Process Started', patt: 'Tshape1',inStatus:'Blue'},{ from:157,to:1392, text:'', patt: 'Tshape2',inStatus:'Blue'}      
      ];
      
      myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
  
      initTokens();
    }
       
    var movearr = [
    { rec_id:'f236p16307Mar2017155125',yp: [{ id:1,s:0, e:'163',c:'Process Started'},{ id:2,s:163, e:'157',c:'sir kindly process the file for payment'},{ id:3,s:157, e:'1392',c:''}]} 
      ];
  
    
   
    function initTokens() {
      
      
      myDiagram.model.addNodeDataCollection([
      { category: 'token', rec_id:'f236p16307Mar2017155125', at:0,ato:0, color: '#40e307',steps:4,path:'images/01.png' ,comm:'',id:1,face:1}     
      ]);
      myReq = window.requestAnimationFrame(updateTokens);
      
  
  
    }
  function reTokens() {
      myDiagram.parts.each(function(token) {
      var dataToken1 = token.data;
      var at1 = dataToken1.at;
      var movInsId1 = dataToken1.id;
      var next1 = dataToken1.next;
      var atOrignal = dataToken1.ato;
      
  //console.log("color="+dataToken1.color+" file movement id ="+movInsId1+" at="+at1+" next_Point"+next1+" comment="+dataToken1.comm+", frac="+dataToken1.frac);
      var model1 = myDiagram.model;
      var key2=token.data.key;
      key2=(key2*(-1))-1;
      var dataFileIns1 = myDiagram.model.nodeDataArray[key2];
      model1.setDataProperty(dataFileIns1, "id", 0);
      model1.setDataProperty(dataFileIns1, "at", atOrignal);
      cancelAnimationFrame(myReq);
      updateTokens();
      });
      
  }
    function updateTokens() { 
        myDiagram.parts.each(function(token) {
        var dataToken = token.data;
        
        var rec_id = dataToken.rec_id;
        var at = dataToken.at;
        var face=dataToken.face;
        var movInsId = dataToken.id;
        var frac = dataToken.frac;	  
        var next = dataToken.next;
        var key1=token.data.key;
        var model = myDiagram.model;
        key1=(key1*(-1))-1;
        var dataFileIns = myDiagram.model.nodeDataArray[key1];  // get the node data
  //console.log(key1);
  //console.log("color="+dataToken.color+" file movement id ="+movInsId+" at="+at+" next_Point"+next+" comment="+dataToken.comm);
  
  
  var str=dataFileIns.path;
  var res = str.substring(7,9);
  var leftright=(dataToken.face==1)?"R":"L";
  if(dataToken.id<=dataToken.steps){
          switch (res)
          {
              case '01':
              str="images/02"+leftright+".png";
              break;
              case '02':
              str="images/03"+leftright+".png";
              break;
              case '03':
              str="images/04"+leftright+".png";
              break;
              case '04':
              str="images/05"+leftright+".png";
              break;
              case '05':
              str="images/06"+leftright+".png";
              break;
              case '06':
              str="images/07"+leftright+".png";
              break;
              case '07':
              str="images/08"+leftright+".png";
              break;
              case '08':
              str="images/09"+leftright+".png";
              break;
              case '09':
              str="images/10"+leftright+".png";
              break;
              case '10':
              str="images/01"+leftright+".png";
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
         if (dataToken.id>dataToken.steps)return;
        
        if (to === null)// nowhere to go?
        {  
          positionTokenAtNode(token, from);  // temporarily stay at the current node
          var newloc=chooseDestination(movearr,rec_id,movInsId,token, from);
          if(newloc.length > 0)
          {   
      
          dataToken.next = newloc[0].e;  // and decide where to go next	
          
          
  //console.log(dataFileIns);
          
          model.setDataProperty(dataFileIns, "a", newloc[0].c);
           
          }
          
          
          dataToken.id=movInsId+1;
          
        }
        else // proceed toward the 
        {  
              var link = from.findLinksTo(to).first();
              if (link !== null)
              {
                // assume straight lines, for now
                var start = link.getPoint(0);
                var end = link.getPoint(link.pointsCount - 1);
                if (start.x>end.x){face=0;}else{face=1;} ;
              model.setDataProperty(dataFileIns, "face", face);
                var x = start.x + frac * (end.x - start.x);
                var y = start.y + frac * (end.y - start.y);
                token.location = new go.Point(x, y);
              } 
              else 
              {  // stay at the current node
                positionTokenAtNode(token, from);
              }
              
              if (frac >= 1.0)
              {  // if beyond the end, it's "AT" the NEXT node
                dataToken.frac = 0.0;
                dataToken.at = next;
                dataToken.next = undefined;  // don't know where to go next
              }
              else 
              {  // otherwise, move fractionally closer to the NEXT node
                dataToken.frac = frac + 0.01;
              }
        }
        
      });
      //console.log('face_change'+face1);	
     myReq = window.requestAnimationFrame(updateTokens);
    }
  
  
  
    function chooseDestination(fileMoveProcess,rec_id,id,token, node) {
  //console.log("chooseDestination function got id="+id);
       var t=new Array();	 
       var processId=id;
        var t=search(fileMoveProcess,rec_id,processId);
        return t;
      
    }
    
    function search(array,rid,sid)
      {
          //console.log("search function got id="+sid);
          var filtered = [];
          var yp=new Array();
          for(var i=0; i<array.length; i++)
          {           
              var item = array[i];           
              if (item.rec_id == rid)
              { 
                 for(j=0;j<item.yp.length;j++)
                 {
                    if(item.yp[j].id==sid)
                    {
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
      for (var i = 0; i < 6; i++ ) {
          color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
  } 
  function reload_dd1(form) {
              var val1 = form.dd1.options[form.dd1.options.selectedIndex].value;
              var val2 = form.recid.value;
              var val3 = form.sl.value;
              var val4 = form.ec.value;
              self.location = 'instancepath.php?dd1='+val1
              +'&recid='+val2
              +'&sl='+val3
              +'&ec='+val4;
          } 
  </script>

  