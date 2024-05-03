@extends('layouts.app')
@section('title')
@endsection
@section('css')
@endsection
@section('breadcrumb')
@endsection
@section('content')
    @if($isAdmin)
    <h6 class="mb-0">Thống kê doanh thu</h6>
    <hr/>
    <form id="form-search-payment">
        <div id="search-payment" style="max-width: 1000px" class="d-flex justify-content-end">
            <select onchange="$('#form-search-payment').submit()" name="customer_id" class="form-select form-select-sm single-select"
                    style="width: 250px; float: right">
                <option value="">Khách hàng</option>
                @foreach($customers as $customerId => $customerName)
                    <option value="{{ $customerId }}"
                            @if(intval(request('customer_id')) === $customerId) selected @endif>{{ $customerName }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <div id="chart" style="max-width: 1000px; margin-top: 50px">
    </div>
    <br>
    @endif

    <h6 class="mb-0">Thống kê số lượng sản phẩm</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="quantityDatatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        @if($isAdmin || $isStocker)
                            <th>Số lượng đã giao</th>
                        @endif
                        <th>Số lượng chưa giao</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($products->isEmpty())
                        <tr>
                            <td colspan="{{($isAdmin || $isStocker) ? 5 : 4}}" class="text-center">Không tìm thấy dữ
                                liệu
                            </td>
                        </tr>
                    @else
                        @foreach($products as $k => $product)
                            <tr>
                                <td>{{$k + 1}}</td>
                                <td>{{$product->product_code}}</td>
                                <td>{{$product->product_name}}</td>
                                @if($isAdmin || $isStocker)
                                    <td>{{number_format($product->quantity_delivered)}}</td>
                                @endif
                                <td>{{number_format($product->quantity_in_processing)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/dashboard.js"></script>
    @if($isAdmin)
    <script>
        var options = {
            chart: {
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Doanh thu',
                data: {!! json_encode(array_values($payment)) !!}
            }],
            xaxis: {
                labels: {
                    formatter: function (val) {
                        return "Tháng " + val
                    }
                },
                categories: {!! json_encode(array_keys($payment)) !!}
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return Intl.NumberFormat("en", {
                            maximumFractionDigits: 0, minimumFractionDigits: 0,
                        }).format(value);
                    }
                }
            },
        }
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    @endif
@endsection
