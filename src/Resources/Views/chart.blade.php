<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    Highcharts.chart('container', {
        title: {
            text: 'Sales Chart for the Last 30 Days',
            align: 'center'
        },
        tooltip: {
            useHTML: true,
            style: {
                fontSize: "20px",
                fontFamily: 'Tahoma',
                direction: "rtl"
            },
            formatter: function () {
                return (this.x ? "Date: " + this.x + "<br>" : "") + "Amount: " + this.y;
            }
        },
        xAxis: {
            categories: [@foreach($dates as $date => $value) '{{getJalaliFromFormat($date)}}', @endforeach]
        },
        yAxis: {
            title: {
                text: 'Amount'
            },
            labels: {
                formatter: function () {
                    return this.value + " Toman";
                }
            },
        },
        labels: {
            items: [{
                html: 'Income for the Last 30 Days',
                style: {
                    left: '50px',
                    top: '18px',
                    color: ( // theme
                        Highcharts.defaultOptions.title.style &&
                        Highcharts.defaultOptions.title.style.color
                    ) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'Site Percentage',
            color: "green",
            data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalSiteShare }}, @else 0, @endif  @endforeach]
        }, {
            type: 'column',
            name: 'Successful Transactions',
            data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach]
        }, {
            type: 'column',
            name: 'Instructor Percentage',
            color: "pink",
            data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalSellerShare}}, @else 0, @endif  @endforeach]
        }, {
            type: 'spline',
            name: 'Sales',
            data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach],
            marker: {
                lineWidth: 2,
                lineColor: "green",
                fillColor: 'white'
            },
            color: "green"
        }, {
            type: 'pie',
            name: 'Ratio',
            data: [{
                name: 'Site Percentage',
                y: {{$last30DaysBenefit}},
                color: "green"
            }, {
                name: 'Instructor Percentage',
                y: {{$last30DaysSellerShare}},
                color: "pink"
            }],
            center: [80, 70],
            size: 100,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });
</script>
