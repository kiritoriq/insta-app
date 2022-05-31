<script src="https://cdn.jsdelivr.net/npm/echarts@5.1.2/dist/echarts.min.js"></script>
<div class="container py-5 max-w-800px">
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Monthly Sales Ammount By Category
            </h3>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th width="2%">#</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Ammount</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Clothes</td>
                                <td class="text-right">23</td>
                                <td class="text-right">46,0%</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Home Decor</td>
                                <td class="text-right">12</td>
                                <td class="text-right">24,0%</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Game and Accessories</td>
                                <td class="text-right">10</td>
                                <td class="text-right">20,0%</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Fashion</td>
                                <td class="text-right">5</td>
                                <td class="text-right">10,0%</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Furniture</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0,0%</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center font-weight-bold">Total</td>
                                <td class="text-right">50</td>
                                <td class="text-right">100,0%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div id="pieChart" style="height: 400px"></div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" onclick="$.fancybox.close()" class="btn btn-danger">Close</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var chartModal = echarts.init(document.getElementById('pieChart'));
        var optionPie = {
            title: {
                // text: 'Grafik Laporan Harian Hotline Dinkop UMKM Berdasarkan Jenis Aduan'
            },
            legend: {
                orient: 'horizontal',
                left: 'center',
                padding: 10
            },
            tooltip: {
                trigger: 'item',
            },
            xAxis: {
                data: [],
                axisLabel: { interval: 0, rotate: 20 }
            },
            yAxis: {
                name: 'Sales Ammount',
                nameLocation: 'middle',
                nameGap: 50
            },
            series: [{
                name: 'Sales Ammount',
                type: 'pie',
                radius: '50%',
                data: [
                    { value: 23, name: 'Clothes' },
                    { value: 12, name: 'Home Decor' },
                    { value: 10, name: 'Game and Accesories' },
                    { value: 5, name: 'Fashion' },
                    { value: 0, name: 'Furniture' },
                ]
            }]
        };
        chartModal.setOption(optionPie);
    })
</script>