@extends('layout.default')
@section('title', 'Dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/echarts@5.1.2/dist/echarts.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="alert alert-custom alert-white wave wave-animate wave-primary shadow fade show gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-warning svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/General/Smile.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <rect fill="#000000" opacity="0.3" x="2" y="2" width="20" height="20" rx="10"/>
                                <path d="M6.16794971,14.5547002 C5.86159725,14.0951715 5.98577112,13.4743022 6.4452998,13.1679497 C6.90482849,12.8615972 7.52569784,12.9857711 7.83205029,13.4452998 C8.9890854,15.1808525 10.3543313,16 12,16 C13.6456687,16 15.0109146,15.1808525 16.1679497,13.4452998 C16.4743022,12.9857711 17.0951715,12.8615972 17.5547002,13.1679497 C18.0142289,13.4743022 18.1384028,14.0951715 17.8320503,14.5547002 C16.3224187,16.8191475 14.3543313,18 12,18 C9.64566871,18 7.67758127,16.8191475 6.16794971,14.5547002 Z" fill="#000000"/>
                            </g>
                        </svg><!--end::Svg Icon--></span>
                    </div>
                    <div class="alert-text">Welcome to Metronic Laravel 7 Framework.</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5 mt-3">
            <div class="col-xl-12">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div id="chart" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/dashboard.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            var chart = echarts.init(document.getElementById('chart'));
            var option = {
                title: {
                    text: 'Monthly Sales Chart'
                },
                tooltip: {},
                dataZoom: [{
                    type: 'inside'
                }, {
                    type: 'slider'
                }],
                xAxis: {
                    data: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ]
                },
                yAxis: {
                    name: 'Sales Ammount',
                    nameLocation: 'middle',
                    nameGap: 50
                },
                series: [
                    {
                        name: 'Monthly Sales Ammount',
                        type: 'bar',
                        data: [
                            50,120,70,30,240,413,500,527,0,0,0,0
                        ],
                        itemStyle: {
                            color: 'rgba(239, 129, 5, 1)'
                        },
                        label: {
                            show: true,
                            position: 'top'
                        }
                    }
                ]
            };
            chart.setOption(option);

            chart.on('click', function(e) {
                console.log(e.name);
                $.ajax({
                    url: '{{ route("load-page-aduan") }}',
                    type: 'get',
                    data: { _token: $('meta[name="csrf-token"]').attr('content'), tanggal: e.name },
                    success: function(response) {
                        $.fancybox.open([
                            {
                                src: response,
                                type: 'html'
                            }
                        ])
                    }
                })
            })
            
        })
    </script>
@endsection
