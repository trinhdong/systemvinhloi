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
<?php
    $isEdit = in_array($order->payment_status, [UNPAID, DEPOSITED, IN_PROCESSING, REJECTED]) && $order->status === DELIVERED;
    $isTranfer = $order->payment_method === TRANFER && ($order->payment_type === DEPOSIT || $order->payment_type === PAY_FULL);
?>
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="d-flex">
                            <div class="card border shadow-none col-8">
                                <div class="card-header bg-light py-3 justify-content-center">
                                    <div>
                                        <h5 class="mb-0 fw-bold">Chi tiết thanh toán</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-7 fw-bold">Mã đơn hàng</div>
                                        <div class="col-5"><a href="{{route('order.detail', $order->id)}}">{{$order->order_number}}</a></div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Trạng thái đơn hàng</div>
                                        <div class="col-5">
                                            <span class="font-14 badge rounded-pill bg-{{STATUS_COLOR[$order->status]}}">{{STATUS_ORDER[$order->status]}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Trạng thái thanh toán</div>
                                        <div class="col-5">
                                            <span class="font-14 badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
                                        </div>
                                    </div>
                                    @if($order->payment_check_type !== UNCHECK_PAYMENT)
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Tình trạng kiểm tra thanh toán</div>
                                        <div class="col-5 text-danger">
                                            {{STATUS_CHECK_PAYMENT[$order->payment_check_type] ?? ''}}
                                        </div>
                                    </div>
                                    @endif
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
                                    @if(!empty($order->payment_method))
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Phương thức thanh toán</div>
                                        <div class="col-5">{{PAYMENTS_METHOD[$order->payment_method]}}</div>
                                    </div>
                                    @endif
                                    @if($isEdit && $order->payment_type === PAYMENT_ON_DELIVERY)
                                        <div class="form-group row mt-3 d-flex align-items-center">
                                            <div class="col-7 fw-bold">Phương thức thanh toán</div>
                                            <div class="col-5">
                                                <div class="col-8">
                                                    <select id="payment-method" name="payment_method"
                                                            class="form-select">
                                                        <option selected="" value="">Chọn phương thức</option>
                                                        @foreach(PAYMENTS_METHOD as $k => $v)
                                                            <option value="{{ $k }}"
                                                                    @if($order->payment_method == $k) selected @endif>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Vui lòng nhập phương thức thanh toán</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->payment_type === PAYMENT_ON_DELIVERY  || $order->payment_method == TRANFER)
                                    <div id="payment-method-info" class="{{$order->payment_type === PAYMENT_ON_DELIVERY && $order->payment_method !== TRANFER ? 'd-none' : ''}}">
                                        <label for="" class="fw-bolder me-1 mt-3" style="white-space: nowrap">Tài khoản chuyển tiền </label>
                                        <div class="card border radius-10">
                                            <div class="card-body">
                                                @if(!$isEdit)
                                                <div class="form-group row">
                                                    <div class="col-7 fw-bold">Tên ngân hàng</div>
                                                    <div class="col-5">{{$order->bank_name}}</div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-7 fw-bold">Số tài khoản</div>
                                                    <div class="col-5">{{$order->bank_code}}</div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-7 fw-bold">Tên chủ tài khoản</div>
                                                    <div class="col-5">{{$order->bank_customer_name}}</div>
                                                </div>
                                                @else
                                                <div class="form-group row d-flex align-items-center">
                                                    <div class="col-7 fw-bold">Tên ngân hàng </div>
                                                    <div class="col-5">
                                                        <div class="col-8">
                                                            <input name="bank_name" type="text" class="form-control"
                                                                   placeholder="Nhập tên ngân hàng" autocomplete="off"
                                                                   value="{{$order->bank_name}}">
                                                            <div class="invalid-feedback">Vui lòng nhập tên ngân hàng</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3 d-flex align-items-center">
                                                    <div class="col-7 fw-bold">Số tài khoản </div>
                                                    <div class="col-5">
                                                        <div class="col-8">
                                                            <input name="bank_code" type="text" class="form-control"
                                                                   placeholder="Nhập số tài khoản" autocomplete="off"
                                                                   value="{{$order->bank_code}}">
                                                            <div class="invalid-feedback">Vui lòng nhập số tài khoản</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3 d-flex align-items-center">
                                                    <div class="col-7 fw-bold">Tên chủ tài khoản </div>
                                                    <div class="col-5">
                                                        <div class="col-8">
                                                            <input name="bank_customer_name" type="text" class="form-control"
                                                                   placeholder="Nhập tên chủ tài khoản" autocomplete="off"
                                                                   value="{{$order->bank_customer_name}}">
                                                            <div class="invalid-feedback">Vui lòng nhập tên chủ tài khoản</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <label for="" class="fw-bolder me-1" style="white-space: nowrap">Tài khoản nhận tiền </label>
                                        <div class="card border radius-10">
                                            <div class="card-body">
                                                @if(!$isEdit)
                                                    <div class="form-group row">
                                                        <div class="col-7 fw-bold">Tên ngân hàng</div>
                                                        <div class="col-5">{{$order->bankAccount->bank_name ?? ''}}</div>
                                                    </div>
                                                    <div class="form-group row mt-3">
                                                        <div class="col-7 fw-bold">Số tài khoản</div>
                                                        <div class="col-5">{{$order->bankAccount->bank_code ?? ''}}</div>
                                                    </div>
                                                    <div class="form-group row mt-3">
                                                        <div class="col-7 fw-bold">Tên chủ tài khoản</div>
                                                        <div class="col-5">{{$order->bankAccount->bank_account_name ?? ''}}</div>
                                                    </div>
                                                    @if(!empty($order->bankAccount->branch))
                                                    <div class="form-group row mt-3">
                                                        <div class="col-7 fw-bold">Tên chi nhánh</div>
                                                        <div class="col-5">{{$order->bankAccount->branch}}</div>
                                                    </div>
                                                    @endif
                                                @else
                                                <div class="form-group row d-flex align-items-center">
                                                    <div class="col-7 fw-bold">Chọn tài khoản nhận tiền </div>
                                                    <div class="col-5">
                                                        <div class="col-8">
                                                            <select id="bank-account" name="bank_account_id" class="form-select">
                                                                <option selected="" value="">Chọn tài khoản</option>
                                                                @foreach($bankAccounts as $k => $v)
                                                                    <option value="{{ $k }}" @if($order->bank_account_id == $k) selected @endif>{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">Vui lòng chọn tài khoản nhận tiền</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="bank-account-info" class="{{$order->bankAccount !== null ? '' : 'd-none'}}">
                                                    <div class="form-group row d-flex align-items-center mt-3">
                                                        <div class="col-7 fw-bold">Tên ngân hàng </div>
                                                        <div class="col-5">
                                                            <div class="col-8">
                                                                <span id="bank-name">{{$order->bankAccount->bank_name ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mt-3 d-flex align-items-center">
                                                        <div class="col-7 fw-bold">Số tài khoản </div>
                                                        <div class="col-5">
                                                            <div class="col-8">
                                                                <span id="bank-code">{{$order->bankAccount->bank_code ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mt-3 d-flex align-items-center">
                                                        <div class="col-7 fw-bold">Tên chủ tài khoản </div>
                                                        <div class="col-5">
                                                            <div class="col-8">
                                                                <span id="bank-account-name">{{$order->bankAccount->bank_account_name ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="{{$order->bankAccount->bank_branch ?? null === null ? 'd-none' : ''}} form-group row mt-3 d-flex align-items-center">
                                                        <div class="col-7 fw-bold">Tên chi nhánh </div>
                                                        <div class="col-5">
                                                            <div class="col-8">
                                                                <span id="bank-branch">{{$order->bankAccount->bank_branch ?? ''}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($isEdit)
                                    <div class="form-group row mt-3 d-flex align-items-center">
                                        <div class="col-7 fw-bold">Ngày thanh toán</div>
                                        <div class="col-5">
                                            <div class="col-8">
                                                <input type="text" id="datepicker" name="payment_date" class="form-control col-5" value="{{!empty($order->payment_date) ? date(FORMAT_DATE_VN, strtotime($order->payment_date)) : ''}}" placeholder="Ngày thanh toán">
                                                <div class="invalid-feedback">Vui lòng nhập ngày thanh toán</div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif(!empty($order->payment_date))
                                    <div class="form-group row mt-3 d-flex align-items-center">
                                        <div class="col-7 fw-bold">Ngày thanh toán</div>
                                        <div class="col-5">
                                            <h5 class="mb-0 col-12 text-danger">{{date(FORMAT_DATE_VN, strtotime($order->payment_date))}}</h5>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group row mt-3">
                                        <div class="col-7 fw-bold">Tổng số tiền của đơn hàng</div>
                                        <h5 class="mb-0 col-5" id="order-total">{{number_format($order->order_total)}}₫</h5>
                                    </div>
                                    @if($order->payment_type == DEPOSIT && !empty($order->deposit))
                                        <div class="form-group row mt-3">
                                            <div class="col-7 fw-bold">Số tiền cọc</div>
                                            <h5 class="mb-0 col-5 ">{{number_format($order->deposit)}}₫</h5>
                                        </div>
                                    @endif
                                    <div class="form-group row mt-3 d-flex align-items-center">
                                        <div class="col-7 fw-bold">Số tiền đã thanh toán</div>
                                        <div class="col-5">
                                            @if($isEdit)
                                                <div class="col-8">
                                                    <input id="paid" type="text" name="paid" class="form-control col-5" value="{{number_format($order->paid)}}">
                                                    <div class="invalid-feedback">Vui lòng nhập số tiền đã thanh toán</div>
                                                </div>
                                            @else
                                                <h5 class="mb-0 col-12 ">{{number_format($order->paid)}}₫</h5>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class=" col-7 fw-bold">Số tiền còn lại</div>
                                        <h5 class="mb-0 col-5 text-danger" id="remaining">{{number_format(max($order->order_total - $order->paid, 0))}}₫</h5>
                                    </div>
                                    @if(!empty($order->is_print_red_invoice))
                                    <div class="form-group row mt-3 d-flex align-items-center">
                                        <div class="col-7 fw-bold">Trạng thái xuất hóa đơn đỏ</div>
                                        <div class="col-5">
                                            <div class="col-8">
                                                @if($order->has_print_red_invoice == PRINTED_RED_INVOICE)
                                                    Đã xuất hóa đơn
                                                @elseif($order->status === DELIVERED)
                                                    <select id="has-print-red-invoice" name="has_print_red_invoice" class="form-select">
                                                        <option value="0">Chưa xuất hóa đơn</option>
                                                        <option value="1">Đã xuất hóa đơn</option>
                                                    </select>
                                                @else
                                                    Chưa xuất hóa đơn
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$commentOrders->isEmpty())
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table align-middle border last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th class="col-3">Nhân viên</th>
                                <th class="col-3">Trạng thái đơn hàng</th>
                                <th class="">Ghi chú</th>
                                <th class="col-2 text-right">Thời gian cập nhật</th>
                            </tr>
                            </thead>
                            <tbody class="bd-content-stable">
                            @foreach($commentOrders as $comment)
                                <tr>
                                    <td>{{$users[$comment->created_by]}}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{STATUS_COLOR[$comment->status]}}">{{STATUS_ORDER[$comment->status]}}</span>
                                    </td>
                                    <td>{{$comment->note}}</td>
                                    <td class="text-right">{{date(FORMAT_DATE_TIME_VN, strtotime($comment->created_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if(!$comments->isEmpty())
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table align-middle border last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th class="col-3">Nhân viên</th>
                                <th class="col-3">Trạng thái thanh toán</th>
                                <th class="">Ghi chú</th>
                                <th class="col-2 text-right">Thời gian cập nhật</th>
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
                                    <td class="text-right">{{date(FORMAT_DATE_TIME_VN, strtotime($comment->created_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-3 text-left flex justify-content-start">
                    @if($order->status === DELIVERED && (($order->is_print_red_invoice === PRINTED_RED_INVOICE  && $order->has_print_red_invoice === NOT_YET_RED_INVOICE) || in_array($order->payment_status, [UNPAID, DEPOSITED, IN_PROCESSING, REJECTED])))
                    <form class="d-none" id="update-payment" method="POST"
                          action="{{ route('payment.updatePayment', ['id' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                    </form>
                    <button id="updatePaymentModalBtn" data-bs-target="#updatePaymentModal" data-bs-toggle="modal"
                            class="text-center btn btn-primary me-2">Cập nhật
                    </button>
                    <div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModalLabel"
                         aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updatePaymentModalLabel">Cập nhật thanh toán</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn muốn cập nhật thanh toán của đơn hàng này?
                                    @if($isEdit)
                                    <div class="mb-3 mt-3">
                                        <label for="updateNote" class="form-label">Ghi chú:</label>
                                        <textarea class="form-control" id="updateNote" name="note" rows="3"></textarea>
                                        <div class="invalid-feedback">Vui lòng nhập ghi chú</div>
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button id="updatePayment" type="button"
                                            class="btn btn-success">Đồng ý
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-6 d-flex justify-content-center text-left">
                    @if($isAdmin && $order->payment_check_type === ACCOUNTANT_CHECK_PAYMENT && $order->status === DELIVERED && $order->payment_status === PAID)
                            <form class="d-none" id="update-status-payment-reject" method="POST"
                                  action="{{route('payment.updateStatusPayment', ['id' => $order->id, 'status' => REJECTED])}}">
                                @csrf
                                @method('PUT')
                            </form>
                            <button id="rejectPaymentModalBtn" data-bs-target="#rejectPaymentModal" data-bs-toggle="modal"
                                    class="text-center btn btn-danger me-2">Từ chối
                            </button>
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
                    @endif
                    @if(($isAdmin || ($isAccountant && in_array($order->payment_check_type, [SALE_CHECK_PAYMENT, UNCHECK_PAYMENT, REJECTED]))) && $order->status === DELIVERED && in_array($order->payment_status, [PAID, IN_PROCESSING]))
                    <form class="d-none" id="update-status-payment" method="POST"
                          action="{{ route('payment.updateStatusPayment', ['id' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                    </form>
                    <button id="approvePaymentModalBtn" data-bs-target="#approvePaymentModal" data-bs-toggle="modal"
                            class="text-center btn btn-success me-2">Xác nhận
                    </button>
                    <div class="modal fade" id="approvePaymentModal" tabindex="-1" aria-labelledby="approvePaymentModalLabel"
                         aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approvePaymentModalLabel">Xác nhận thanh toán</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn muốn xác nhận thanh toán của đơn hàng này?
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
                    @endif
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/payment/detail.js"></script>
    <script>const isEdit = {!! json_encode($isEdit) !!};</script>
    <script>const isTranfer = {!! json_encode($isTranfer) !!};</script>
@endsection
