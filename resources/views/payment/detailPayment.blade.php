@extends('layouts.app')
@section('title')
    Thanh toán
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('payment.indexPayment')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$order->order_number}}
@endsection
@section('content')
    <form class="row g-3 needs-validation" action="{{ route('payment.updatePayment', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row pt-3">
                    <div class="col-7 offset-4">
                        <div class="form-group row">
                            <div class="col-4 fw-bold">Mã đơn hàng</div>
                            <div class="col-8">{{$order->order_number}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Tên khách hàng</div>
                            <div class="col-8"> {{$order->customer->customer_name}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Hình thức thanh toán</div>
                            <div class="col-8">
                                {{PAYMENTS_TYPE[$order->payment_type]}}
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Phương thức thanh toán</div>
                            <div class="col-8">{{PAYMENTS_METHOD[$order->payment_method]}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Tổng số tiền của đơn hàng</div>
                            <div class="col-8">{{number_format($order->order_total)}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Số tiền đã thanh toán</div>
                            <div class="col-8">{{number_format($order->deposit)}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Số tiền còn lại</div>
                            <div class="col-8">{{number_format($order->order_total - $order->deposit)}}</div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-4 fw-bold">Trạng thái thanh toán</div>
                            <div class="col-8"><span
                                        class="font-14 badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center py-3">
                    <input type="file" hidden="" name="uploadInputRequest[]" id="selectedFile" multiple="">
                    <button type="button" class="btn btn-primary rounded-sm px-3 mr-2" disabled=""><i
                                class="fa fa-cloud-upload mr-1" aria-hidden="true"></i>アップロード
                    </button>
                    <button id="review-request" type="button" class="btn btn-primary rounded-sm px-3">確認
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
