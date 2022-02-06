<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title></title>
    <style type="text/css" media="all">
        @page {
            /*size: 21.59cm 27.94cm;*/
            size: A4 portrait; /* can use also 'landscape' for orientation */
            margin: 1.0in;
            border: thin solid black;
            padding: 1em;
        }

        .appraisal-head {
          position: absolute;
          top: 180px;
          left: 10px;
        }

        .employee-name {
          position: absolute;
          top: 700px;
          left: 10px;
        }
        .disclaimer {
          position: absolute;
          top: 1140px;
          left: 10px;
        }

        .created_on {
          position: absolute;
          top: 1100px;
          left: 10px;
        }

    </style>
</head>
<body lang="en-US" >
<div class="container">
  <img src="{{ asset('../images/5bb.png') }}" alt="background" style="width:100%;" align="center" height="1350" border="0"/>
  <div class="appraisal-head">
    <p style="margin-bottom: 0.7cm; line-height: 100%">
        <font color="#333333" face="Devil Breeze bold, serif" size="7" style="font-size: 60pt">
            Appraisal Report
        </font>
    </p>
  </div>
  <div class="employee-name">
    <span  style="float: left; border: none; padding: 0cm; >
        <p  align="left" style="margin-bottom: 0.7cm; line-height: 100%">
            <font color="#d01820" face="Devil Breeze bold, serif" style="font-size: 40pt">
                {{$acr->employee->name}}
            </font>
        </p>

        <font color="#333333" face="Devil Breeze bold, serif" style="font-size: 20pt">
           Period:{{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}
        </font>


    </span>
  </div>
  <div class="disclaimer">
        <font color="#777777"face="Poppins Medium, serif" style="font-size: 14pt">
            This is appraisal report related to PWD employee . If this is not related to you then do do not use it for any purpose
        </font>
  </div>
  <div class="created_on">
    <font color="#d01820" face="Poppins Medium, serif" style="font-size: 20">
        Created On: {{now()->format('d M Y H:i')}}
    </font>
  </div>
</div>
</body>
</html>





