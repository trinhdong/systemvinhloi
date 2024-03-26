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
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="d-flex">
                            <div class="card border shadow-none col-7">
                                <div class="card-header bg-light py-3">
                                    <div>
                                        <h5 class="mb-0 fw-bold">Chi tiết thanh toán</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-7 fw-bold">Mã đơn hàng</div>
                                        <div class="col-5">{{$order->order_number}}</div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Tên khách hàng</div>
                                        <div class="col-5"> {{$order->customer->customer_name}}</div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Hình thức thanh toán</div>
                                        <div class="col-5">
                                            {{PAYMENTS_TYPE[$order->payment_type]}}
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Phương thức thanh toán</div>
                                        <div class="col-5">{{PAYMENTS_METHOD[$order->payment_method]}}</div>
                                    </div>
                                    @if($order->payment_method == TRANFER)
                                        <div class="form-group row mt-3">
                                            <div class="col-7 fw-bold">Tên chủ tài khoản:</div>
                                            <div class="col-5">{{$order->bank_customer_name}}</div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-7 fw-bold">Tên ngân hàng:</div>
                                            <div class="col-5">{{$order->bank_name}}</div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-7 fw-bold">Số tài khoản:</div>
                                            <div class="col-5">{{$order->bank_code}}</div>
                                        </div>
                                    @endif
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Tổng số tiền của đơn hàng</div>
                                        <h5 class="mb-0 col-5">{{number_format($order->order_total)}}₫</h5>
                                    </div>
                                    @if(!empty($order->deposit))
                                        <div class="form-group row mt-3">
                                            <div class="col-7 fw-bold">Số tiền đã cọc</div>
                                            <h5 class="mb-0 col-5 text-danger">{{number_format($order->deposit)}}₫</h5>
                                        </div>
                                    @endif
                                    @if(!empty($order->deposit) && $order->payment_status == UNPAID)
                                        <div class="form-group row mt-3">
                                            <div class=" col-7 fw-bold">Số tiền còn lại</div>
                                            <h5 class="mb-0 col-5 text-danger">{{number_format($order->order_total - $order->deposit)}}
                                                ₫</h5>
                                        </div>
                                    @else
                                        <div class="form-group row mt-3">
                                            <div class=" col-7 fw-bold">Số tiền đã thanh toán</div>
                                            <h5 class="mb-0 col-5 text-danger">{{number_format($order->order_total)}}
                                                ₫</h5>
                                        </div>
                                    @endif
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Trạng thái thanh toán</div>
                                        <div class="col-5"><span
                                                    class="font-14 badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$comments->isEmpty())
                <div class="card">
                    <div class="card-body col-7">
                        <table class="table align-middle border">
                            <thead class="table-secondary">
                            <tr>
                                <th>Nhân viên</th>
                                <th>Trạng thái</th>
                                <th class="">Ghi chú</th>
                            </tr>
                            </thead>
                            <tbody class="bd-content-stable">
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{$users[$comment->created_by]}}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$comment->status]}}">{{STATUS_PAYMENT[$comment->status]}}</span>
                                    </td>
                                    <td>{{$comment->note}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if($order->status != REJECTED && (($order->payment_status == PAID && $order->status == DELIVERED) || $order->payment_status == UNPAID || ($order->payment_status == PARITAL_PAYMENT && ($order->status == DELIVERED || $order->status == AWAITING))))
                <div class="text-left py-3">
                    <form class="d-none" id="update-status-payment-reject" method="POST"
                          action="{{route('payment.updateStatusPayment', ['id' => $order->id, 'status' => REJECTED])}}">
                        @csrf
                        @method('PUT')
                    </form>
                    <button id="rejectPaymentModalBtn" data-bs-target="#rejectPaymentModal" data-bs-toggle="modal"
                            class="text-center btn btn-danger me-2">Từ chối
                    </button>
                    <form class="d-none" id="update-status-payment" method="POST"
                          action="{{ route('payment.updateStatusPayment', ['id' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                    </form>
                    <button id="approvePaymentModalBtn" data-bs-target="#approvePaymentModal" data-bs-toggle="modal"
                            class="text-center btn btn-primary me-2">Phê duyệt
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="approvePaymentModal" tabindex="-1" aria-labelledby="approvePaymentModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvePaymentModalLabel">Phê duyệt thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn phê duyệt thanh toán của đơn hàng này?
                    <div class="mb-3 mt-3">
                        <label for="approveNote" class="form-label">Ghi chú:</label>
                        <textarea class="form-control" id="approveNote" name="note" rows="3"></textarea>
                        <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="approvePayment" type="button"
                            class="btn btn-success">Đồng ý
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejectPaymentModal" tabindex="-1" aria-labelledby="rejectPaymentModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectPaymentModalLabel">Từ chối thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn từ chối thanh toán của đơn hàng này?
                    <div class="mb-3 mt-3">
                        <label for="rejectNote" class="form-label">Ghi chú:</label>
                        <textarea class="form-control" id="rejectNote" name="note" rows="3"></textarea>
                        <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="rejectPayment" type="button"
                            class="btn btn-danger">Đồng ý
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/payment/detail.js"></script>
@endsection
