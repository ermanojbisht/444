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

    </style>
</head>
<body lang="en-US" >
<div>
<p style="margin-bottom: 0.350cm">&shy;
    <img src="{{ asset('../images/5bb.png') }}" name="Picture 0" align="center" width="900" height="1056" border="0"/>

<p style="margin-bottom: 0.7cm; line-height: 100%">
    <font color="#333333" face="Devil Breeze bold, serif" size="7" style="font-size: 60pt">
        Appraisal Report
    </font>
</p>


<span  style="float: left; width: 12.45cm; height: 2.04cm; border: none; padding: 0cm; background: #ffffff">
    <p  align="right" style="margin-bottom: 0.7cm; line-height: 100%">
        <font color="#d01820" face="Devil Breeze bold, serif"size="7" style="font-size: 40pt">
            {{$acr->employee->name}}
        </font>
    </p>
</span>
<span  style="float: left; width: 16.09cm; height: 2.24cm; border: none; padding: 0cm; background: #ffffff">
    <p style="margin-bottom: 0.35cm; line-height: 110%">
        <font color="#777777"face="Poppins Medium, serif" size="4" style="font-size: 14pt">
            This is appraisal report related to PWD employee . If this is not related to you then do do not use it for any purpose Period:{{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}
        </font>
    </p>
</span>
<span  style="float: right; height: 1.85cm; border: none; padding: 0cm; background: #ffffff">
    <p  style="margin-bottom: 0.35cm; line-height: 100%">
        <font color="#d01820" face="Devil Breeze medium, serif" size="5" style="font-size: 30pt">
            {{now()}}
        </font>
    </p>
</span>
</p>
</body>
</html>





