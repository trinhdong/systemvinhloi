<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <style type="text/css">
        body {
            font-family: IBMPlexSansJP;
        }
        .container {
            margin: 0 auto;
            width: 100%;
        }
        @page {

        }
        table {
            width: 100%;
        }
        th, td {
            /* text-align: center; */
        }
        .info-pdf {

        }
        .info-pdf-left {
            float: left;
            width: 40%;
            padding: 10px;
            font-size: 9px;
        }
        .info-pdf-center {
            float: left;
            padding: 10px;
            width: 30%;
            font-size: 9px;
        }
        .info-pdf-right{
            float: left;
            padding: 10px;
            width: 25%;
            font-size: 9px;
        }
        .w30 {
            width: 30%;
        }
        .text-center{
            text-align: center;
        }
        .title {
            text-align: center;
            margin-top: 0px;
            font-size: 30px;
              }
        p {
            margin: 0px 0px 30px 0px;
        }
        small {
            font-size: 10px;
        }
        .info-table-border {
            padding: 5px;
            margin:0px;
        }
        .info-table-no-border {
            font-size: 14px;
            padding: 5px;
            margin:0px;
            border:0px;
        }
        .info-table-border td{
            border: 1px solid lightgrey;
            padding-bottom: 6px;
            padding-left: 6px;
        }
        .text-color-grey{
            color:rgb(70, 69, 69);
        }
        .border {
            border: 1px solid rgb(179, 177, 177)!important;
        }
        .border-end-0{
            border-right: 0!important;
        }
        .m-0{
            margin: 0px;
        }
        .red{
            background-color: red;
        }
        .black{
            background-color: rgb(104, 104, 104)
        }
    </style>
</head>
<body>
    <div class="container" style="padding:0px;margin:0px;">
        <div class="title text-dark-blue pt-0 mt-0" >{{$title}}</div>
        <div class="info-pdf" >
            <div class="info-pdf-left" >
                <table class="info-table-border" style="margin-bottom:0px;border-collapse: collapse;word-wrap:break-word;">
                    @if($purchase_check == true)
                        <tr>
                            <td style="width:30%;">{{__('admin.customer_post_code')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->Customer ? $data->Customer->post_code : ''}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.customer_adress')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->Customer ? ($data->Customer->address_for_delivery ? $data->Customer->address_for_delivery : $data->Customer->address) : ''}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_customer_id')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->Customer ? $data->Customer->name : ''}}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_order_date')}}</td>
                            <td style="width:70%;" colspan="3">{{date('Y/m/d',strtotime($data->order_date))}}</td>
                            <!-- <td style="width:20%;">{{__('admin.contract_place_of_import')}}</td>
                            <td style="width:30%;text-overflow:ellipsis;">{{$data->place_of_import}}</td> -->
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_supplier_id')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->Supplier ? $data->Supplier->name : __('message.404_not_found')}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_customer_id')}}</td>
                            <td style="width:70%;" colspan="3">
                                @if($data->Customer)
                                    {{$data->Customer->name}}
                                @else
                                    {{__('message.404_not_found')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_delivery_destination')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->delivery_destination}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_delivery_address')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->delivery_address}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">{{__('admin.contract_delivery_phone')}}</td>
                            <td style="width:70%;" colspan="3">{{$data->delivery_phone_number}}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="info-pdf-center" >
                <div class="" style="margin-bottom:0px;">
                    <div>
                        <div style="width:80px;display:inline-block;">{{__('admin.contract_create_date')}}</div>
                        <div style="width:200px;display:inline-block;text-align:right;">{{date('Y/m/d',strtotime($data->created_date))}}</div>
                    </div>

                    @if($purchase_check == true)
                        <div>
                            <div style="width:80px;display:inline-block;">{{__('admin.contract_order_date')}}</div>
                            <div style="width:200px;display:inline-block;text-align:right;">{{date('Y/m/d',strtotime($data->order_date))}}</div>
                        </div>
                    @endif

                    <div>
                        <div style="width:80px;display:inline-block;vertical-align: top;">{{__('admin.contract_slit_number')}}</div>
                        <div style="width:200px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;" >{{$data->slip_number}}</div>
                    </div>
                    <div>
                        <div style="width:80px;display:inline-block;vertical-align: top;">{{__('admin.contract_person_in_charge')}}</div>
                        @php
                            $person_in_charge = null;
                            foreach ($list_user as $key => $user) {
                                if($data->person_in_charge == $user->id){
                                    $person_in_charge = $user;
                                }
                            }
                        @endphp
                        <div style="width:200px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;" >{{$person_in_charge ? $person_in_charge->name : '削除されました'}}</div>
                    </div>
                    <div>
                        <div style="width:80px;display:inline-block;vertical-align: top;">{{__('admin.supplier_contract_order_number')}}</div>
                        <div style="width:200px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;" >{{$data->order_number}}</div>
                    </div>
                    <div style="line-height:4px;margin-top:5px;margin-left:0px;">
                        <div style="margin-top:10px">株式会社ヤマプラス</div>
                        <div style="margin-top:10px">本社 東京都港区白金台2-25-1</div>
                        <div style="margin-top:10px">TEL 第１営業部 (03)3443-3355</div>
                        <div style="margin-top:10px">TEL 第２営業部 (03)3443-3371</div>
                    </div>
                </div>
                
            </div>
            <div class="info-pdf-right" >
                <div class="" style="margin-bottom:0px;">
                    <div style="" >
                        <div style="width:100px;display:inline-block;vertical-align: top;">{{__('admin.contract_order_code')}}</div>
                        <div style="width:130px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;">{{$data->order_code}}</div>
                    </div>
                    <div style="margin-bottom:5px;">
                        <div style="width:100px;display:inline-block;vertical-align: top;">{{__('admin.product_serial_number')}}</div>
                        <div style="width:130px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;" >{{$data->serial_number}}</div>
                    </div>
                    <div style="margin-bottom:5px;">
                        <div style="width:100px;display:inline-block;vertical-align: top;">{{__('admin.product_creditor')}}</div>
                        <div style="width:130px;display:inline-block;text-align:right;word-wrap: break-word;vertical-align: top;" >{{$data->created_person}}</div>
                    </div>
                </div>
            </div>
        </div>
        @if($purchase_check == false)
            <div class="" style="margin-top:190px;border:1px solid white;font-size:12px">
                <div style="display:inline-block;font-size:16px;text-align:left;">{{__('admin.preview_estimated_amount')}} <span style="">{{number_format($data->getRevenue())}}</span>円</div>
                <div style="display:inline-block;color:rgb(43, 42, 42);opacity:90%;text-align:left;">（{{__('admin.preview_internal_consumption_tax')}}<span style="">{{number_format($data->getRevenueNoTax())}}</span>円）</div>
            </div>
        @else
            <div class="" style="margin-top:190px;border:1px solid white;font-size:12px">
            </div>
        @endif
        <div style="background-color:lightgrey;font-size:10px;padding-top:13px;">
            <div style="display:inline-block;width:250px;margin-left:5px;" >{{__('admin.product_code_name')}}</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_color')}}</div>
            <div style="display:inline-block;text-align: center;width:155px;margin-left:5px">取引寸</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_inverse')}}</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_symbol')}}</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_quantity')}}</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_unit')}}</div>
            <div style="display:inline-block;text-align: center;width:155px;margin-left:5px;padding-top:0px;">
                <div style="margin:0px;padding:0px">{{__('admin.product_earnings')}}</div>
                <div style="display:inline-block;text-align: center;margin:0px;width:50px;margin-bottom: -5px">{{__('admin.product_hanging_rate')}}</div>
                <div style="display:inline-block;text-align: center;margin:0px;width:100px;margin-bottom: -5px">{{__('admin.product_price')}}</div>
            </div>
            <div style="display:inline-block;text-align: center;width:50px;margin-left:5px">{{__('admin.product_previous_generation')}}</div>
            <div style="display:inline-block;text-align: center;width:33px;margin-left:5px">{{__('admin.product_tax')}}</div>
            <div style="display:inline-block;text-align: center;width:70px;margin-left:5px">{{__('admin.product_deadline')}}</div>
        </div>
        @foreach ($data->SupplierContractDetail as $detail)
            <div style="font-size:8px;margin-bot:0px;margin-top:2px;padding: 1px 5px;background-color:rgb(255, 255, 255);{{ $detail->note == null ? 'border-bottom:1px solid lightgrey;' : 'border-left: 0px;border-right: 0px;border-bottom: 1px dashed lightgray;border-style: 1px solid dashed;'}} ">
                <div style="display:inline-block;width:250px;vertical-align: middle;margin-left:5px;padding:0px;" >
                    <!-- <div style="color:rgb(105, 105, 105);font-size:12px;width:180px;word-wrap: break-word;">{{ $detail->product_code }}</div> -->
                    <div style="width:250px;word-wrap: break-word;padding:0px;margin:0px;">{{ $detail->product_name }}</div>
                    {{-- <div style="color:rgb(105, 105, 105);width:250px;word-wrap: break-word;font-size:9px;margin:0px">{{ $detail->note }}</div> --}}
                </div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{ $detail->color }}</div>
                <div style="display:inline-block;text-align: center;width:155px;vertical-align: middle;margin-left:5px;font-size:8px;">
                    <div>{{$detail->trade_size_1}}</div>
                    <div>{{$detail->trade_size_2}}</div>
                </div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{ $detail->reciprocal_number }}</div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{ $detail->standard }}</div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{ number_format($detail->quantity,2) }}</div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{ $detail->unit }}</div>
                <div style="display:inline-block;text-align: center;width:155px;vertical-align: middle;margin-left:5px">
                    <div style="display:inline-block;text-align: center;width:50px;margin-bottom: -5px;word-wrap: break-word;">{{number_format($detail->sales_discount_rate,2)}}</div>
                    <div style="display:inline-block;text-align: center;width:100px;margin-bottom: -5px;word-wrap: break-word;">{{number_format($detail->price,2)}}</div>
                </div>
                <div style="display:inline-block;text-align: center;width:50px;vertical-align: middle;margin-left:5px;word-wrap: break-word;">{{number_format($detail->consignment,2)}}</div>
                <div style="display:inline-block;text-align: center;width:33px;vertical-align: middle;margin-left:5px">{{$detail->tax}}%</div>
                <div style="display:inline-block;text-align: center;width:70px;vertical-align: middle;margin-left:5px">{{ empty($detail->delivery_term) ? "" : date('Y/m/d',strtotime($detail->delivery_term)) }}</div>
            </div>
            @if($detail->note)
            <div style="font-size:8px;margin-bot:0px;margin-top:2px;border-bottom:1px solid lightgrey;padding: 1px 5px;background-color:rgb(255, 255, 255)">
                <div style="display:inline-block;margin-left:5px;padding:0px;word-wrap: break-word;width:300px;" >
                    {{$detail->note}}
                </div>
            </div>
            @endif
        @endforeach
        <div style="margin-top:10px;font-size:12px;">
            <div style="float: left;width:45%;padding: 10px 10px;">
                <div style="display:inline-block;width:49%">{{__('admin.contract_memo')}}</div>
                <div style="display:inline-block;width:49%;text-align:right;"></div>
                <div style="color:rgb(71, 71, 71);width:400px;word-wrap: break-word;">{{$data->note}}</div>
            </div>  
            @php
                $tax = $data->getRevenue() - $data->getRevenueNoTax() ;
                $percen_tax = $tax * 100 / $data->getRevenueNoTax();
            @endphp
            <div style="float: right;width:45%;padding: 10px 10px;">
                <div style="display:inline-block;width:49%">{{__('admin.preview_subtotal')}}</div>
                <div style="display:inline-block;width:49%;text-align:right;">{{ number_format($data->getRevenueNoTax()) }}円</div>
                <div style="display:inline-block;width:49%">{{__('admin.preview_consumption_tax')}}</div>
                <div style="display:inline-block;width:49%;text-align:right;">{{ number_format($tax) }}　円</div>
                <div style="display:inline-block;width:49%">{{__('admin.preview_total')}}</div>
                <div style="display:inline-block;width:49%;text-align:right;">{{ number_format($data->getRevenue()) }}　円</div>
                @php
                    $details = [];
                    $is_first_row = true;
                    foreach ($data->SupplierContractDetail as $detail) {
                        $tax = $detail->tax;
                        $price = (!empty($detail->price)) ? ($detail->price * $detail->quantity) : ($detail->quantity * $detail->sales_discount_rate * $detail->consignment);
                        if (isset($details[$tax])) {
                            $details[$tax] += $price;
                        } else {
                            $details[$tax] = $price;
                        }
                    }
                    ksort($details);
                @endphp

                @foreach ($details as $tax => $price)
                    @if($is_first_row)
                        <div style="display:inline-block;width:49%;color:rgb(105, 105, 105); vertical-align: top">
                            {{__('admin.preview_items')}} {{ number_format($tax, 1) }}{{__('admin.preview_percent_tax')}}
                        </div>
                        <div style="display:inline-block;width:49%;text-align:right;color:rgb(105, 105, 105); vertical-align: top">
                            {{ number_format($price) }} 円
                        </div>
                        <div style="width:99%;text-align:right;color:rgb(105, 105, 105); vertical-align: top"> {{number_format(($price * $tax) / 100)}} 円</div>
                        @php $is_first_row = false; @endphp
                    @else
                        <div style="display:inline-block;width:49%;color:rgb(105, 105, 105); vertical-align: top">
                            <span style="margin-left: 30px">{{ number_format($tax, 1) }}{{__('admin.preview_percent_tax')}}</span>
                        </div>
                        <div style="display:inline-block;width:49%;text-align:right;color:rgb(105, 105, 105); vertical-align: top">
                            {{ number_format($price) }} 円
                        </div>
                        <div style="width:99%;text-align:right;color:rgb(105, 105, 105); vertical-align: top"> {{number_format(($price * $tax) / 100)}} 円</div>
                    @endif
                @endforeach
            </div>
        </div>
    </div></body></html>

