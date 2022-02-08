<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Page Content -->
                    <div class="content">
                        <div class="d-flex justify-content-around align-items-center align-self-center flex-row">
                            <div class="d-flex justify-content-around align-items-center align-self-center flex-column">
                                <div id="piechart_3d" style="width: 800px; height: 400px;"></div>
                                <div id="donutchart" style="width: 800px; height: 400px;"></div>
                            </div>
                            <div id="barchart_values" style="width: 800px; height: 400px;"></div>
                        </div>
                    </div>
                    <!-- END Page Content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Element reklame', 'Broj korišćenja'],
                <?php echo $chartData1?>
            ]);

            var options = {
                title: 'Upotreba različitih elemenata reklame',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tip reklame', 'Broj korišćenja'],
                <?php echo $chartData2?>
            ]);

            var options = {
                title: 'Učestalost upotrebe slike u odnosu na video u reklamama',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Broj ponavljanja", "Broj reklama"],
                <?php echo $chartData3 ?>
            ]);


            // var view = new google.visualization.DataView(data);
            // view.setColumns([0, 1,
            //                  { calc: "stringify",
            //                    sourceColumn: 1,
            //                    type: "string",
            //                    role: "annotation" },
            //                  2]);

            var options = {
                title: "Statistika broja ponavljanja reklama",
                width: 600,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
            };

            var chart = new google.visualization.BarChart(document.getElementById('barchart_values'));
            chart.draw(data, options);
        }
    </script>
<body>

</body>
