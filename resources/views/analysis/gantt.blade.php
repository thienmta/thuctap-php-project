@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="js/jsgantt.css" />

    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-gantt.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.0/js/anychart-data-adapter.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.0/css/anychart-ui.min.css" />
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.0/fonts/css/anychart-font.min.css" />

    <script language="javascript" src="js/jsgantt.js"></script>

    <div class="panel panel-primary ">
        <div class="panel-heading">Projects <a  class="pull-right btn btn-primary btn-sm" href="/projects/create">Create new</a> </div>
        <div class="panel-body">
            <div id="container" style="height: 400px;"></div>
        </div>
    </div>


    <script type="text/javascript">
        anychart.onDocumentReady(function (){
            var rawData = [
                @foreach($projects as $project)
                {
                    "id": "{{ $project->id }}",
                    "name": "{{ $project->name }}",
                    "actualStart": "{{ $project->start_at }}",
                    "actualEnd": "{{ $project->finish_at }}",
                    "progressValue": '{{ $project->completed }}%'
                },
                @endforeach
            ];
            anychart.theme('darkBlue');

            // data tree settings
            var treeData = anychart.data.tree(rawData, "as-table");
            var chart = anychart.ganttProject();      // chart type
            chart.data(treeData);                     // chart data

            chart.splitterPosition(370);

            // get chart data grid link to set column settings
            var dataGrid = chart.dataGrid();

            // set first column settings
            dataGrid.column(0)
                    .title('#')
                    .width(30)
                    .labels({
                        hAlign: 'center'
                    });

            // set second column settings
            dataGrid.column(1)
                    .title('Project')
                    .labels()
                    .hAlign('left')
                    .width(30);

            // set third column settings
            dataGrid.column(2)
                    .title('Start Time')
                    .width(85)
                    .labels()
                    .hAlign('right')
                    .format(function() {
                        var date = new Date(this.actualStart);
                        var month = date.getUTCMonth() + 1;
                        var strMonth = (month > 9) ? month : '0' + month;
                        var utcDate = date.getUTCDate();
                        var strDate = (utcDate > 9) ? utcDate : '0' + utcDate;
                        return date.getUTCFullYear() + '/' + strMonth + '/' + strDate;
                    });

            // set fourth column settings
            dataGrid.column(3)
                    .title('End Time')
                    .width(80)
                    .labels()
                    .hAlign('right')
                    .format(function() {
                        var date = new Date(this.actualEnd);
                        var month = date.getUTCMonth() + 1;
                        var strMonth = (month > 9) ? month : '0' + month;
                        var utcDate = date.getUTCDate();
                        var strDate = (utcDate > 9) ? utcDate : '0' + utcDate;
                        return date.getUTCFullYear() + '/' + strMonth + '/' + strDate;
                    });

            chart.container('container').draw();      // set container and initiate drawing
            chart.fitAll();

            //choose an event type from table above:
            chart.listen("rowClick", function(event) {
//                var msg = event['item'].get('name') + event['item'].get('id');
//                if (event['period']) msg += '\nPeriod: ' + event['period']['id'];
//                console.log(msg);
                window.location.href = "/projects/" + event['item'].get('id');
            });
             // zoom chart to specified date
//            chart.zoomTo(951350400000, 954201600000);
        });
    </script>
@endsection