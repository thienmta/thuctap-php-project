@extends('layouts.app')

@section('content')
    <div style="position: relative; width: 200px;" class="filters">
        <form method="post" id="frm-change-current-date" action="{{ route('statistics.filter') }}">
            {{ csrf_field() }}
            <input placeholder="Enter current date"
                   id="current_date"
                   name="current_date"
                   spellcheck="false"
                   class="form-control datepicker"
                   style="margin-top: 10px;"
                   onchange="changeCurrentDate()"
            />
        </form>
    </div>
    <br/>
    <link rel="stylesheet" type="text/css" href="js/jsgantt.css" />

    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-gantt.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-data-adapter.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.0/css/anychart-ui.min.css" />
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.0/fonts/css/anychart-font.min.css" />
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datetimepicker({
                format: 'YYYY/MM/DD',
                defaultDate: '{{ $current_date }}',
            }).on('dp.change',function(e){
                $("#frm-change-current-date").submit();
            });
        });
    </script>
    <style>
        html, body, #container {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

    <script language="javascript" src="js/jsgantt.js"></script>
    <div class="panel panel-primary ">
        <div class="panel-heading">Timeline</div>
        <div class="panel-body">
            <div id="container" style="height: 400px;"></div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).on('click', '#abc', function () {
            alert('changed');
        });
        anychart.onDocumentReady(function() {
            // The data used in this sample can be obtained from the CDN
            // https://cdn.anychart.com/samples/gantt-charts/human-resource-chart/data.js
            // create data tree
            var rawData = [
                @foreach($statistics as $key1 => $staff)
                {
                    "id": "{{ $staff['id'] }}",
                    "name": "{{ $staff['full_name'] }}",
                    "progressValue": "100%",
                    "periods": [
                        @foreach($staff['periods'] as $key2 => $period)
                        {
                            "id": "{{ $key1 . '_' . $key2 }}",
                            "start": "{{ $period['start_date'] }}",
                            "end": "{{ $period['end_date'] }}",
                            "participation_rates" : "{{ 80 }}",
                            "stroke": "#B8AA96",
                            "fill": {
                                "angle": 90,
                                "keys": [
                                    {
                                        "color": "#CFC0A9",
                                        "position": 0
                                    },
                                    {
                                        "color": "#E6D5BC",
                                        "position": 0.38
                                    },
                                    {
                                        "color": "#E8D9C3",
                                        "position": 1
                                    }
                                ]
                            }
                        },
                        @endforeach
                    ]
                },
                @endforeach
            ];

            var treeData = anychart.data.tree(rawData, 'as-table');

            // create resource gantt chart
            var chart = anychart.ganttResource();

            // set data for the chart
            chart.data(treeData);

            chart.rowSelectedFill('#D4DFE8')
                    .rowHoverFill('#EAEFF3')
                    // set start splitter position settings
                    .splitterPosition(150);


            // get chart data grid link to set column settings
            var dataGrid = chart.dataGrid();

            var timeline = chart.getTimeline();

            // getting timeline's tooltip
            var tlTooltip = timeline.tooltip();

            tlTooltip.format(function () {
                var hoveredPeriod = this['period'];

                if (hoveredPeriod) {
                    var startDate = hoveredPeriod['start'];
                    var endDate = hoveredPeriod['end'];
                    var participationRates = hoveredPeriod['participation_rates'];
                    return 'Start date: ' + startDate + '\nEnd date: ' + endDate + '\nParticipation rates: ' + participationRates + '%.';
                } else {
                    return 'No periods under cursor';
                }
            });

            // set first column settings
            dataGrid.column(0)
                    .title('')
                    .width(30)
                    .labels({
                        hAlign: 'center'
                    });

            // set second column settings
            dataGrid.column(1)
                    .title('Staff')
                    .width(120);

            // set container id for the chart
            chart.container('container');

            // initiate chart drawing
            chart.draw();

            // zoom chart to specified date
            //chart.zoomTo(1171036800000, 1176908400000);

            chart.zoomOut(10);
        });
    </script>
@endsection