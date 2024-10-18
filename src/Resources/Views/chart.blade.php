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
                return `
                    <strong>${this.series.name}</strong><br/>
                    Date: ${this.x}<br/>
                    Amount: ${Highcharts.numberFormat(this.y, 0)} ETB
                `;
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
                    return this.value + " ETB";
                }
            },
        },
        labels: {
            items: [{
                html: 'Income for the Last 30 Days',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'Site Share',
            color: "green",
            data: [@foreach($dates as $date => $value) @if($day = $summary->where("date",  $date)->first()) {{ $day->totalSiteShare }}, @else 0, @endif  @endforeach]
        }, {
            type: 'column',
            name: 'Successful Transactions',
            data: [@foreach($dates as $date => $value) @if($day = $summary->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach]
        }, {
            type: 'column',
            name: 'Seller Share',
            color: "pink",
            data: [@foreach($dates as $date => $value) @if($day = $summary->where("date",  $date)->first()) {{ $day->totalSellerShare}}, @else 0, @endif  @endforeach]
        }, {
            type: 'spline',
            name: 'Sales',
            data: [@foreach($dates as $date => $value) @if($day = $summary->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach],
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
                name: 'Site Share',
                y: {{$last30DaysBenefit}},
                color: "green"
            }, {
                name: 'Seller Share',
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
