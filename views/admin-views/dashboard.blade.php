@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    @if(auth('admin')->user()->admin_role_id==1 || \App\CPU\Helpers::module_permission_check('dashboard'))
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header pb-0 mb-0 border-0">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">{{\App\CPU\translate('Dashboard')}}</h1>
                        <p>{{ \App\CPU\translate('Welcome_message')}}.</p>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Business Analytics -->
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row flex-between align-items-center g-2 mb-3">
                        <div class="col-sm-6">
                            <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                <img src="{{asset('/public/assets/back-end/img/business_analytics.png')}}" alt="">{{\App\CPU\translate('business_analytics')}}</h4>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-sm-end">
                            <select class="custom-select w-auto" name="statistics_type"
                                    onchange="order_stats_update(this.value)">
                                <option
                                    value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                    {{ \App\CPU\translate('Overall_statistics')}}
                                </option>
                                <option
                                    value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                    {{ \App\CPU\translate("Todays Statistics")}}
                                </option>
                                <option
                                    value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                    {{ \App\CPU\translate("This Months Statistics")}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2" id="order_stats">
                        @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
                    </div>
                </div>
            </div>
            <!-- End Business Analytics -->


            <!-- Admin Wallet -->
            <!--<div class="card mb-3">
                <div class="card-body">
                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-3">
                        <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}" alt="">
                        {{\App\CPU\translate('admin_wallet')}}
                    </h4>

                    <div class="row g-2" id="order_stats">
                        @include('admin-views.partials._dashboard-wallet-stats',['data'=>$data])
                    </div>
                </div>
            </div>-->
            <!-- End Admin Wallet -->

{{--            <div class="user-overview-wrap mb-2">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row g-2 align-items-center">--}}
{{--                            <div class="col-md-5">--}}
{{--                                <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">--}}
{{--                                    <img src="{{asset('/public/assets/back-end/img/order_statictics.png')}}" alt="">--}}
{{--                                    Order Statictics--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-7 d-flex justify-content-md-end">--}}
{{--                                <ul class="option-select-btn">--}}
{{--                                    <li>--}}
{{--                                        <label>--}}
{{--                                            <input type="radio" name="statistics" hidden="" checked="">--}}
{{--                                            <span>This Year</span>--}}
{{--                                        </label>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <label>--}}
{{--                                            <input type="radio" name="statistics" hidden="">--}}
{{--                                            <span>This Month</span>--}}
{{--                                        </label>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <label>--}}
{{--                                            <input type="radio" name="statistics" hidden="">--}}
{{--                                            <span>This Week</span>--}}
{{--                                        </label>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!-- Bar Chart -->--}}
{{--                        <div class="chartjs-custom mt-2">--}}
{{--                            <canvas id="order_statictics" height="340"></canvas>--}}
{{--                        </div>--}}
{{--                        <!-- End Bar Chart -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="card-header__title">User Overview</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="position-relative">--}}
{{--                            <h3 class="amount-of-user">1.6M+ <span>User</span></h3>--}}
{{--                            <canvas id="user_overview" height="300" width="300"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="row g-1">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card">
                        <!-- Body -->
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                        <img src="{{asset('/public/assets/back-end/img/earning_statictics.png')}}" alt="">
                                        {{\App\CPU\translate('earning_statistics')}}
                                    </h4>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end">
                                    <ul class="option-select-btn">
                                        <li>
                                            <label>
                                                <input type="radio" name="statistics2" hidden="" checked="">
                                                <span data-earn-type="yearEarn"
                                                      onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This_Year')}}</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="statistics2" hidden="">
                                                <span data-earn-type="MonthEarn"
                                                      onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This_Month')}}</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="statistics2" hidden="">
                                                <span data-earn-type="WeekEarn"
                                                      onclick="earningStatisticsUpdate(this)">{{\App\CPU\translate('This Week')}}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 mb-3 d-none border-bottom">
                                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                        <img src="{{asset('/public/assets/back-end/img/order_statictics.png')}}" alt="">
                                        {{\App\CPU\translate('earning_statistics_for_business_analytics')}}
                                    </h4>

                                    <h5 class="card-header-title float-right mb-2">{{\App\CPU\translate('this_year_earning')}}
                                        <i class="tio-chart-bar-2 fz-30"></i>
                                    </h5>
                                </div> 

                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                    <span class="h6 mb-0">
                                        <i class="legend-indicator bg-primary"></i>
                                        {{\App\CPU\translate('in-house_earning')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($inhouse_data)))}}
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                        <span class="h6 mb-0">
                                            <i class="legend-indicator bg-success"></i>
                                            {{\App\CPU\translate('seller_earnings')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($seller_data)))}}
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                        <span class="h6 mb-0">
                                            <i class="legend-indicator bg-danger"></i>
                                        {{\App\CPU\translate('commission_earned')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($commission_data)))}}
                                    </span>
                                    </div>
                                </div> 
                            </div>

                            <!-- End Row -->

                            <!-- Bar Chart -->
                            <div class="chartjs-custom mt-2" id="set-new-graph">
                                <canvas id="updatingData"
                                        data-hs-chartjs-options='{
                                            "type": "bar",
                                            "data": {
                                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                                              "datasets": [{
                                                "label": "In-house ",
                                                "data": [{{$inhouse_data[1]}},{{$inhouse_data[2]}},{{$inhouse_data[3]}},{{$inhouse_data[4]}},{{$inhouse_data[5]}},{{$inhouse_data[6]}},{{$inhouse_data[7]}},{{$inhouse_data[8]}},{{$inhouse_data[9]}},{{$inhouse_data[10]}},{{$inhouse_data[11]}},{{$inhouse_data[12]}}],
                                                "backgroundColor": "#ACDBAB",
                                                "hoverBackgroundColor": "#ACDBAB",
                                                "borderColor": "#ACDBAB"
                                              },
                                              {
                                                "label": "Seller",
                                                "data": [{{$seller_data[1]}},{{$seller_data[2]}},{{$seller_data[3]}},{{$seller_data[4]}},{{$seller_data[5]}},{{$seller_data[6]}},{{$seller_data[7]}},{{$seller_data[8]}},{{$seller_data[9]}},{{$seller_data[10]}},{{$seller_data[11]}},{{$seller_data[12]}}],
                                                "backgroundColor": "#0177CD",
                                                "borderColor": "#0177CD"
                                              },
                                              {
                                                "label": "Commission",
                                                "data": [{{$commission_data[1]}},{{$commission_data[2]}},{{$commission_data[3]}},{{$commission_data[4]}},{{$commission_data[5]}},{{$commission_data[6]}},{{$commission_data[7]}},{{$commission_data[8]}},{{$commission_data[9]}},{{$commission_data[10]}},{{$commission_data[11]}},{{$commission_data[12]}}],
                                                "backgroundColor": "#FFB36D",
                                                "borderColor": "#FFB36D"
                                              }]
                                            },
                                            "options": {
                                                "legend": {
                                                    "display": true,
                                                    "position": "top",
                                                    "align": "center",
                                                    "labels": {
                                                        "fontColor": "#758590",
                                                        "fontSize": 14
                                                    }
                                                },
                                                "scales": {
                                                    "yAxes": [{
                                                    "gridLines": {
                                                        "color": "rgba(180, 208, 224, 0.5)",
                                                        "borderDash": [8, 4],
                                                        "drawBorder": false,
                                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                                    },
                                                    "ticks": {
                                                        "beginAtZero": true,
                                                        "stepSize": 50000,
                                                        "fontSize": 12,
                                                        "fontColor": "#5B6777",
                                                        "padding": 10,
                                                        "postfix": " {{\App\CPU\BackEndHelper::currency_symbol()}}"
                                                    }
                                                    }],
                                                    "xAxes": [{
                                                    "gridLines": {
                                                        "color": "rgba(180, 208, 224, 0.5)",
                                                        "display": true,
                                                        "drawBorder": true,
                                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                                    },
                                                    "ticks": {
                                                        "fontSize": 12,
                                                        "fontColor": "#5B6777",
                                                        "fontFamily": "Open Sans, sans-serif",
                                                        "padding": 5
                                                    },
                                                    "categoryPercentage": 0.5,
                                                    "maxBarThickness": "7"
                                                    }]
                                                },
                                                "cornerRadius": 3,
                                                "tooltips": {
                                                    "prefix": " ",
                                                    "hasIndicator": true,
                                                    "mode": "index",
                                                    "intersect": false
                                                },
                                                "hover": {
                                                    "mode": "nearest",
                                                    "intersect": true
                                                }
                                            }
                                  }'></canvas>

                            </div>
                            <!-- End Bar Chart -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>

                <!-- Total Business Overview -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-header-title">
                                <i class="tio-company"></i> {{\App\CPU\translate('total_business_overview')}}
                            </h5>
                            <i class="tio-chart-pie-1 fz-45"></i>
                        </div>

                        <div class="card-body ltr" id="business-overview-board">
                            <div class="chartjs-custom mx-auto">
                                <canvas id="business-overview" class="mt-2"></canvas>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- End Total Business Overview -->

                <div class="col-md-6 col-xl-4">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']])
                    </div>
                    <!-- End Card -->
                </div>

                <!-- Top Store By Order Received -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100">
                        @include('admin-views.partials._top-store-by-order',['top_store_by_order_received'=>$data['top_store_by_order_received']])
                    </div>
                </div>
                <!-- End Top Store By Order Received -->
                
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100">
                        @include('admin-views.partials._top-selling-store',['top_store_by_earning'=>$data['top_store_by_earning']])
                    </div>
                </div>
                

                <div class="col-md-6 col-xl-4">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-md-6 col-xl-4">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                    </div>
                    <!-- End Card -->
                </div>

            </div>
        </div>
    @else
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12 mb-2 mb-sm-0">
                        <h3 class="text-center">{{\App\CPU\translate('hi')}} {{auth('admin')->user()->name}}, {{\App\CPU\translate('welcome_to_dashboard')}}.</h3>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
        </div>
    @endif
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{asset('public/assets/back-end')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush


@push('script_2')
    <script>
        function earningStatisticsUpdate(t) {
            let value = $(t).attr('data-earn-type');

            $.ajax({
                url: '{{route('admin.dashboard.earning-statistics')}}',
                type: 'GET',
                data: {
                    type: value
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (response_data) {
                    document.getElementById("updatingData").remove();
                    let graph = document.createElement('canvas');
                    graph.setAttribute("id", "updatingData");
                    document.getElementById("set-new-graph").appendChild(graph);

                    var ctx = document.getElementById("updatingData").getContext("2d");

                    // var oldChart = new Chart(ctx, {});
                    // oldChart.destroy();

                    var options = {
                        responsive: true,
                        bezierCurve: false,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(180, 208, 224, 0.5)",
                                    zeroLineColor: "rgba(180, 208, 224, 0.5)",
                                    borderDash: [8, 4],
                                }
                            }]
                        },
                        legend: {
                            display: true,
                            position: "top",
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                fontColor: "#758590",
                                fontSize: 14
                            }
                        },
                        plugins: {
                            datalabels: {
                                display: false
                            }
                        },
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [],
                            datasets: [
                                {
                                    label: "In-house",
                                    data: [],
                                    backgroundColor: "#ACDBAB",
                                    hoverBackgroundColor: "#ACDBAB",
                                    borderColor: "#ACDBAB",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                },
                                {
                                    label: "Seller",
                                    data: [],
                                    backgroundColor: "#0177CD",
                                    hoverBackgroundColor: "#0177CD",
                                    borderColor: "#0177CD",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                },
                                {
                                    label: "Commission",
                                    data: [],
                                    backgroundColor: "#FFB36D",
                                    hoverBackgroundColor: "FFB36D",
                                    borderColor: "#FFB36D",
                                    fill: false,
                                    lineTension: 0.3,
                                    radius: 0
                                }
                            ]
                        },
                        options: options
                    });

                    myChart.data.labels = response_data.inhouse_label;
                    myChart.data.datasets[0].data = response_data.inhouse_earn;
                    myChart.data.datasets[1].data = response_data.seller_earn;
                    myChart.data.datasets[2].data = response_data.commission_earn;

                    myChart.update();
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>

    <script>
        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>

    <script>
        var ctx = document.getElementById('business-overview');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    '{{\App\CPU\translate('customer')}} ',
                    '{{\App\CPU\translate('store')}} ',
                    '{{\App\CPU\translate('product')}} ',
                    '{{\App\CPU\translate('order')}} ',
                    '{{\App\CPU\translate('brand')}} ',
                ],
                datasets: [{
                    label: '{{\App\CPU\translate('business')}}',
                    data: ['{{$data['customer']}}', '{{$data['store']}}', '{{$data['product']}}', '{{$data['order']}}', '{{$data['brand']}}'],
                    backgroundColor: [
                        '#041562',
                        '#DA1212',
                        '#EEEEEE',
                        '#11468F',
                        '#000000',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        $(function(){

            //get the doughnut chart canvas
            var ctx1 = $("#user_overview");

            //doughnut chart data
            var data1 = {
                labels: ["Customer", "Seller", "Delivery Man"],
                datasets: [
                    {
                        label: "User Overview",
                        data: [88297, 34546, 15000],
                        backgroundColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderColor: [
                            "#017EFA",
                            "#51CBFF",
                            "#56E7E7",
                        ],
                        borderWidth: [1, 1, 1]
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                cutoutPercentage: 65,
                legend: {
                    display: true,
                    position: "bottom",
                    align: "start",
                    maxWidth: 100,
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        fontColor: "#758590",
                        fontSize: 14
                    }
                }
            };

            //create Chart class object
            var chart1 = new Chart(ctx1, {
                type: "doughnut",
                data: data1,
                options: options
            });
        });
    </script>

    <script>
        $(function(){
            //get the line chart canvas
            var ctx = $("#order_statictics");

            //line chart data
            var data = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "In-house",
                        data: [10000, 50000, 100000, 140000, 40000, 10000, 50000, 100000, 130000, 40000, 80000, 120000],
                        backgroundColor: "#FFB36D",
                        borderColor: "#FFB36D",
                        fill: false,
                        lineTension: 0.3,
                        radius: 2
                    },
                    {
                        label: "Seller",
                        data: [9000, 60000, 110000, 130000, 50000, 29000, 60000, 110000, 100000, 50000, 70000, 90000],
                        backgroundColor: "#0177CD",
                        borderColor: "#0177CD",
                        fill: false,
                        lineTension: 0.3,
                        radius: 2
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                bezierCurve : false,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(180, 208, 224, 0.5)",
                            zeroLineColor: "rgba(180, 208, 224, 0.5)",
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgba(180, 208, 224, 0.5)",
                            zeroLineColor: "rgba(180, 208, 224, 0.5)",
                            borderDash: [8, 4],
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        fontColor: "#758590",
                        fontSize: 14
                    }
                }
            };

            //create Chart class object
            var chart = new Chart(ctx, {
                type: "line",
                data: data,
                options: options
            });
        });
    </script>

    <script>
        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.order-stats')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    console.log(data)
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function business_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.business-overview')}}',
                data: {
                    business_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    console.log(data.view)
                    $('#business-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>

@endpush

