<?php
function formatPhoneNumber($number)
{
    $formatted_number = '';
    $length = strlen($number);
    for ($i = 0; $i < $length; $i++) {
        $formatted_number .= $number[$i];
        if ($i == 3 || $i == 6) {
            $formatted_number .= ' ';
        }
    }
    return $formatted_number;
}
?>
    <!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bán hàng Vinh Lợi</title>
    <link href="{{public_path('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{public_path('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <style type="text/css">
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tr td {
            font-size: x-small;
        }

        .detail {
            margin: 0;
            padding: 1px;
        }

        .detail tr {
            margin: 0;
            padding: 1px;
            border: solid 1px;
        }

        .detail th {
            margin: 0;
            padding: 1px;
            border: solid 1px;
        }

        .detail tr td {
            margin: 0;
            padding: 1px;
            border: solid 1px;
        }

    </style>

</head>
<body>
<div style="font-family: 'DejaVu Sans',sans-serif">
    <table width="100%" style="font-family: 'DejaVu Sans',sans-serif">
        <tr>
            <td valign="top" style="width:70%"><img src="{{public_path('assets/images/logo-icon.png')}}" alt=""
                                                    height="80"/></td>
            <td align="right" style="width: 30%">
                <h6 style="text-align: left; font-weight: bold">CTY TNHH NHỰA VINH LỢI</h6>
                <div style="text-align: left; line-height: 5px; margin-top: 10px">
                    <p>G8/32 Tỉnh lộ 10, Lê Minh Xuân, </p>
                    <p>Bình Chánh - TP. Hồ Chí Minh</p>
                    <p>ĐT: 3 969 1482 - Fax: 3 960 4613</p>
                    <p>A Diệu</p>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <div style="line-height: 5px">
                    <h1 style="font-weight: bold">ĐƠN ĐẶT HÀNG</h1><br>
                    <p>Số: <strong>{{$invoiceId}}</strong></p>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" style="width:70%;"></td>
            <td align="right" style="width: 30%">
                <div style="text-align: left; line-height: 5px">
                    <p style="text-align: left;">Người Nhận: <span
                            style="font-weight: bold">{{$order->customer->customer_name ?? ''}}</span></p>
                    <p>SĐT: {{formatPhoneNumber($order->customer->phone ?? '')}}</p>
                    <p>ĐỊA CHỈ GIAO: {{$order->shipping_address ?? $order->customer->address ?? ''}}</p>
                    <p style="text-align: left">Ngày nhận
                        đơn: {{'Ngày ' . date('d', strtotime($order->order_date)) . " tháng " . date('m', strtotime($order->order_date)) . " năm " . date('Y', strtotime($order->order_date))}}</p>
                </div>
            </td>
        </tr>
    </table>
    <table width="100%" class="detail" style="font-family: 'DejaVu Sans',sans-serif">
        <thead>
        <tr>
            <th style="text-align: center">STT</th>
            <th style="text-align: center">Mã sản phẩm</th>
            <th style="text-align: center">Tên sản phẩm</th>
            <th style="text-align: center">Quy cách</th>
            <th style="text-align: center">Đơn vị tính</th>
            <th style="text-align: center">Số lượng thùng</th>
            <th style="text-align: center">Tổng số lượng</th>
            <th style="text-align: center">Đơn giá</th>
            <th style="text-align: center">Chiết khấu</th>
            <th style="text-align: center">Giá sau chiết khấu</th>
            <th style="text-align: center">Tổng cộng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderDetail as $k => $orderDetail)
            <tr>
                <td style="text-align: right">{{$k+1}}</td>
                <td>{{$orderDetail->product->product_code}}</td>
                <td>{{$orderDetail->product->product_name}}</td>
                <td style="text-align: center">{{$orderDetail->product->specifications}}</td>
                <td style="text-align: center">{{$orderDetail->product->unit}}</td>
                <td style="text-align: right">{{number_format($orderDetail->quantity)}}</td>
                <td style="text-align: right">{{number_format($orderDetail->quantity * $orderDetail->product->quantity_per_package ?? 1)}}</td>
                <td style="text-align: right">{{number_format($orderDetail->product_price)}}</td>
                <td style="text-align: right">{{ rtrim(rtrim(number_format($orderDetail->discount_percent, 4), '0'), '.') }}%
                </td>
                <td style="text-align: right">{{number_format($orderDetail->unit_price)}}</td>
                <td style="text-align: right">{{number_format($orderDetail->unit_price * $orderDetail->quantity * $orderDetail->product->quantity_per_package ?? 1)}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="9" style="border-right: none; text-align: center">
                <h3 style="font-weight: bold; margin-top: 1px; margin-bottom: 1px">Tổng cộng</h3>
            </td>
            <td colspan="2" style="border-left: none; margin-right: 5px">
                <h3 style="text-align: right; font-weight: bold; margin-top: 1px; margin-bottom: 1px">{{number_format($order->order_total)}}</h3>
            </td>
        </tr>
        </tbody>
    </table>
    <table width="100%" style="font-family: 'DejaVu Sans',sans-serif">
        <tr>
            <td style="text-align: center; font-weight: bold">
                Lưu ý: Quý khách hàng kiểm tra đơn hàng thật kỹ đúng yêu cầu, số lượng trước khi kí tên. Xin cảm ơn.
            </td>
        </tr>
    </table>
    <table width="100%" style="font-family: 'DejaVu Sans',sans-serif; margin-top: 15px">
        <tr>
            <td valign="top" style="width:30%;">
                <div style="text-align: center; line-height: 5px">
                    <p>Ngày ....... Tháng ...... năm {{date('Y')}}</p>
                    <p>Người Nhận</p>
                    <p>(Ký, họ tên)</p>
                </div>
            </td>
            <td style="width: 40%"></td>
            <td valign="top" style="width:30%;">
                <div style="text-align: center; line-height: 5px">
                    <p style="white-space: nowrap;">Giờ: ......, Ngày ....... Tháng ...... năm {{date('Y')}}</p>
                    <p>Thủ kho</p>
                    <p>(Ký, họ tên)</p>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
