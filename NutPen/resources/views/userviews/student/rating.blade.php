@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.student.Navbar')
    
@endsection

@section('content')
    

    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">

        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif


        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                
                @if ($status ==4)       <!--//Értékelések listázása a tanórában szereplő diákoknak osztályra szűrve-->
                    <h2 class="tm-block-title">Saját értékeléseim</h2>
                   @include('gradeInfo')
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Legutóbbi értékelés dátum</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Értékelések</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($combinedGrades as $oneGrade)
                            
                                <tr>
                                    <td>{{ $oneGrade["subjectName"] }}</td>
                                    <td>{{ $oneGrade["latestGrade"] }}</td>
                                    <td>{{ $oneGrade["teacherName"] }}</td>
                                    <td>
                                        @foreach ($oneGrade["grades"] as $grade)
                                        <span class="grade-button" onclick="showGradeDetails('{{ $grade['gradeName'] }}', '{{ $grade['gradeDateTime'] }}')">{{ $grade["gradeValue"] }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>  
                    <br>
                    <h2 class="tm-block-title">Átlagok:</h2>
                    <div id="chartdiv"></div>     
                @endif

               
            </div>
        </div>
    </div>
@endsection
    <style>
      
    </style>
@section('script')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>


    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
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
        
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
          panX: true,
          panY: true,
          wheelX: "panX",
          wheelY: "zoomX",
          pinchZoomX: true,
          paddingLeft:0,
          paddingRight:1
        }));
        
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);
        
        
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, { 
          minGridDistance: 30, 
          minorGridEnabled: true
        });
        
        xRenderer.labels.template.setAll({
          rotation: -20,
          centerY: am5.p50,
          centerX: am5.p200,
          paddingRight: 15
        });
        
        xRenderer.grid.template.setAll({
          location: 1
        })
        
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
          maxDeviation: 0.3,
          categoryField: "grade",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        }));
        
        var yRenderer = am5xy.AxisRendererY.new(root, {
          strokeOpacity: 0.1
        })
        
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
          maxDeviation: 0.3,
          renderer: yRenderer
        }));
        
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
          name: "Series 1",
          xAxis: xAxis,
          yAxis: yAxis,
          valueYField: "value",
          sequencedInterpolation: true,
          categoryXField: "grade",
          tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
          })
        }));
        
        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
        series.columns.template.adapters.add("fill", function (fill, target) {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });
        
        series.columns.template.adapters.add("stroke", function (stroke, target) {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        var data = [
        <?php

       
            foreach ($combinedGrades as $oneGrade)
            {

                echo(
                        '{'.
                            'grade: "'. $oneGrade["subjectName"]." ". $oneGrade["teacherName"].'",'.
                            'value:'. $oneGrade["gradeavg"].
                        '},'
                  );
          
            }
           
       
        ?>

     ];
  
        xAxis.data.setAll(data);
        series.data.setAll(data);
        
        
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
        
        }); // end am5.ready()
    </script>
@endsection
