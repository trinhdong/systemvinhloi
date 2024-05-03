@extends('layouts.app')
@section('title')
    Thanh toán
@endsection
@section('breadcrumb')
    Danh sách thanh toán
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-10 mb-2">
                    <form id="form-search" class="position-relative">
                        <div class="row">
                            <div class="col-4">
                                <div class="position-absolute translate-middle-y search-icon px-3" style="top: 15%"><i
                                            class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text"
                                       placeholder="Nhập nội dung tìm kiếm"
                                       name="query" value="{{ request('query') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="customer_id" class="form-select single-select">
                                    <option selected="" value="">Chọn khách hàng</option>
                                    @foreach($customers as $customerId => $customerName)
                                        <option value="{{ $customerId }}"
                                                @if(intval(request('customer_id')) === $customerId) selected @endif>{{ $customerName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="sale_id" class="form-select single-select">
                                    <option selected="" value="">Nhân viên bán hàng</option>
                                    @foreach($sales as $saleId => $saleName)
                                        <option value="{{ $saleId }}"
                                                @if(intval(request('sale_id')) === $saleId) selected @endif>{{ $saleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="status" class="form-select single-select">
                                    <option selected="" value="">Chọn trạng thái đơn hàng</option>
                                    @foreach($statusList as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('status')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="payment_status" class="form-select single-select">
                                    <option selected="" value="">Chọn trạng thái thanh toán</option>
                                    @foreach($statusPayment as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('payment_status')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <select onchange="$('#form-search').submit()" name="payment_check_type" class="form-select single-select">
                                    <option selected="" value="">Chọn tình trạng kiểm tra thanh toán</option>
                                    @foreach(STATUS_CHECK_PAYMENT as $status => $statusName)
                                        <option value="{{ $status }}"
                                                @if(intval(request('payment_check_type')) === $status) selected @endif>{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 d-flex justify-content-between align-items-center">
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text" id="delivered-from" autocomplete="off"
                                       placeholder="Ngày đã giao hàng (từ)"
                                       name="delivered_from" value="{{ request('delivered_from') }}">
                                <i class="lni lni-arrow-right" style="margin-left: 5px; margin-right: 5px"></i>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text" id="delivered-to" autocomplete="off"
                                       placeholder="Ngày đã giao hàng (đến)"
                                       name="delivered_to" value="{{ request('delivered_to') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Nhân viên bán hàng</th>
                                <th>Tổng tiền</th>
                                <th>Tài khoản nhận tiền</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Tình trạng kiểm tra thanh toán</th>
                                <th>Ngày đã giao hàng</th>
                                <th>Ngày hẹn thanh toán</th>
                                @if(Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN)
                                <th>Xác nhận thanh toán</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="{{Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN ? '12' : '11'}}" class="text-center">Không tìm thấy dữ liệu</td>
                                </tr>
                            @else
                                @foreach($orders as $key => $order)
                                    <?php
                                        $paymentDueDay = $order->payment_due_day ?? 0;
                                        $deadlinePayment = $order->payment_type === PAYMENT_ON_DELIVERY && $paymentDueDay > 0 && !empty($dateDeliverys[$order->id])
                                            ? date(FORMAT_DATE_VN, strtotime($dateDeliverys[$order->id] . ' +' . $paymentDueDay . ' day')) : '';
                                        $isExpiredPayment = $deadlinePayment != '' && $order->payment_type === PAYMENT_ON_DELIVERY && $order->status === DELIVERED && $order->payment_status === UNPAID && $deadlinePayment <= date(FORMAT_DATE_VN)
                                    ?>
                                    <tr
                                        style="
                                        {{$isExpiredPayment ? 'background-color: red' : '' }}
                                        {{$order->status === COMPLETE ? 'background-color: gray' : ''}}" class="hover-able"
                                    >
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ $key + 1 }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ $order->order_number }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ $order->customer->customer_name }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ $order->user->name ?? '' }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ number_format($order->order_total) }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">
                                            {{ !empty($order->bankAccount) ? $order->bankAccount->bank_code . '-' . $order->bankAccount->bank_account_name : '' }} <br>
                                            {{ !empty($order->bankAccount2) && $order->bank_account_id !== $order->bank_account_id2 ? $order->bankAccount2->bank_code . '-' . $order->bankAccount2->bank_account_name : '' }}
                                        </td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">
                                            <span class="badge rounded-pill bg-{{STATUS_COLOR[$order->status]}}">{{STATUS_ORDER[$order->status]}}</span>
                                        </td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">
                                            <span class="badge rounded-pill bg-{{STATUS_PAYMENT_COLOR[$order->payment_status]}}">{{STATUS_PAYMENT[$order->payment_status]}}</span>
                                        </td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ STATUS_CHECK_PAYMENT[$order->payment_check_type] }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ !empty($deliveredDates[$order->id]) ? date(FORMAT_DATE_VN, strtotime($deliveredDates[$order->id])) : '' }}</td>
                                        <td class="cursor-pointer" onclick="window.location = '{{route('payment.detailPayment', $order->id)}}'">{{ $deadlinePayment }}</td>
                                        @if(Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN)
                                        <td>
                                            @if($order->status === DELIVERED && $order->payment_status === PAID)
                                            <form class="d-none" id="update-status-payment{{$order->id}}" method="POST"
                                                  action="{{ route('payment.updateStatusPayment', ['id' => $order->id]) }}">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <div class="d-flex align-items-center justify-content-center">
                                            <a data-order-id="{{$order->id}}" href="javascript:;" id="approvePaymentModalBtn" data-bs-target="#approvePaymentModal" data-bs-toggle="modal"
                                                    class="text-center"><i class="bx font-20 bx-checkbox" title="Xác nhận"></i>
                                            </a>
                                            </div>
                                            @endif
                                            @if($order->status === COMPLETE)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div style="pointer-events: none;" class="text-center"><i style="color: #000" class="bx font-20 bx-checkbox-checked"></i>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(in_array($order->payment_status, [IN_PROCESSING, REJECTED, DEPOSITED, UNPAID]))
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div style="pointer-events: none;" class="text-center"><i style="color: gray" class="bx font-20 bx-checkbox"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection
@section('script')
    <script src="js/payment/index.js"></script>
@endsection
