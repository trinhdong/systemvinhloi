@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.supplier_contract')}}
@endsection
@section('css')
    {{-- write css this page--}}
    <style>
        .font-size-8 {
            font-size: 8px;
        }
        .font-size-12 {
            font-size: 12px;
        }
        .p-15 {
            padding: .15rem;
        }
        .text-grey{
            color:rgb(122, 120, 120)
        }
        .width-col-258{
            width:258px;
        }
        .width-col-50{
            width:50px;
        }
        .width-col-66{
            width:66px;
        }
        .width-col-90{
            width:90px;
        }
        .padding-input{
            padding:6px 2px;
        }
        .btn-close-col-left{
            color:black;

        }


        .btn-close-col-left:hover{
            color:rgb(121, 121, 121);
        }
        .tab-memo li{
            width: 25%;
        }
        .col-right-preview{
            width: 1123px;
            /* height: 794px; */
        }
        .border-bottom {
            border-bottom: .1px var(--bs-border-style) var(--bs-border-color)!important; ;
        }
        .border-bottom-note{
            border-top: 1px dashed lightgray; 
            border-style: 1px solid dashed;
            border-bottom: 1px solid lightgray; 
            min-height: 38px;
        }
    </style>
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.preview')}}
@endsection
@section('content')
    <div class="flex-container justify-content-center" style="overflow-x:auto;">
        <div class="col-right-preview position-relative">
            @if(!isset($data['is_detail']))
                <div class="position-absolute" style="right:20px;top:70px;z-index:2">
                    <button class="btn float-end border btn-reload" ><i class="lni lni-reload"></i></button>
                </div>
            @endif
            <ul class="nav nav-tabs nav-primary d-flex justify-content-center tab-memo" role="tablist">
                <li class="nav-item" role="presentation" name="quotation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#quotation" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_quotation')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" name="order">
                    <a class="nav-link" data-bs-toggle="tab" href="#order" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_order')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" name="purchase">
                    <a class="nav-link" data-bs-toggle="tab" href="#purchase" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_purchase')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" name="copy">
                    <a class="nav-link" data-bs-toggle="tab" href="#copy" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_copy')}}</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="" style="">
                <div class="">
                    <div class="p-2 rounded">
                        <div class="tab-content py-3" style="color:black;">
                            <div class="tab-pane fade active show" id="quotation" role="tabpanel">
                                <div class="card px-5">
                                    <div class="row justify-content-between card-body position-relative">
                                        @if(isset($data['is_detail']))
                                            <div class="col-12 mb-2 position-absolute" style="top:10px;right:0px;">
                                                <a href="{{route('supplier-contract.downLoadQuotationPDF',$data['is_detail'])}}" class="btn bg-grey-table float-end border" ><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                <a href="{{route('supplier-contract.edit',$data['is_detail'])}}" class="btn bg-grey-table float-end me-2 border"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                            </div>
                                        @else                                       
                                        @endif
                                        <div class="col-12 text-center mt-2">
                                            <label class="h3 fw-bold">{{__('admin.contract_quotation')}}</label>
                                        </div>
                                        <div class="col-4">
                                            <div class="row font-size-8">
                                                <div class="col-4 p-15 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                                <div class="col-8 p-15 border"><span class="order_date_paper">{{($data['order_date'] != null) ? date('Y/m/d', strtotime($data['order_date'])) : ""}}</span></div>
                                                <!-- <div class="col-3 p-15 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                                <div class="col-3 p-15 border"><span class="place_of_import_paper">{{$data['place_of_import']}}</span></div> -->

                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                                @php 
                                                $customer = "";
                                                foreach($list_customer as $cus){
                                                    if($cus->id == $data['customer_id']){
                                                        $customer = $cus->name;
                                                    }
                                                } 
                                                $supplier = "" ;
                                                foreach($list_supplier as $sup){
                                                    if($sup->id == $data['supplier_id']){
                                                        $supplier = $sup->name;
                                                    }
                                                } 
                                                @endphp
                                                <div class="col-8 p-15 border border-top-0"><span class="supplier_id_paper">{{$supplier}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="customer_id_paper">{{$customer}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_destination_paper">{{$data['delivery_destination']}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_address_paper">{{$data['delivery_address']}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_phone_number_paper">{{$data['delivery_phone_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['created_date'] != null) ? date('Y/m/d', strtotime($data['created_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                                <div class="col-7 text-end"><span class="slit_number_paper">{{$data['slip_number']}}</span></div>

                                                <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                                @php
                                                    $person_in_charge = null;
                                                    foreach ($list_user as $key => $user) {
                                                        if($data['person_in_charge'] == $user->id){
                                                            $person_in_charge = $user;
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-7 text-end"><span class="person_in_charge_paper">{{$person_in_charge ? $person_in_charge->name : ''}}</span></div>

                                                <div class="col-5">{{__('admin.supplier_contract_order_number')}}</div>
                                                <div class="col-7 text-end"><span class="order_number_paper">{{$data['order_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{$data['order_code']}}</span></div>

                                                <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                                <div class="col-7 text-end seri-number">{{$data['serial_number']}}</div>

                                                <div class="col-5 mb-2">{{__('admin.product_creditor')}}</div>
                                                <div class="col-7 text-end created-person">{{$data['created_person']}}</div>
                                                
                                                <div class="col-12 font-size-12">株式会社ヤマプラス</div>
                                                <div class="col-12">本社 東京都港区白金台2-25-1</div>
                                                <div class="col-12">TEL 第１営業部 (03)3443-3355</div>
                                                <div class="col-12">TEL 第２営業部 (03)3443-3371</div>
                                            </div>
                                        </div>
                                        <div class="mask-total col-12 mt-3 ">
                                            <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                            <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                        </div>
                                        <div class="col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                            <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                                <div class="px-1 py-1 text-start" style="width:230px;">{{__('admin.product_name')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_color')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:200px">取引寸</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_inverse')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_symbol')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_quantity')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_unit')}}</div>

                                                <div class="px-1 text-center" style="width:140px">
                                                    <span>{{__('admin.product_earnings')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>


                                                <div class="px-1 py-1 text-center" style="width:50px">{{__('admin.product_previous_generation')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                            </div>
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($data['item_contract'] as $key => $detail)
                                                    @if($count == 9)
                                                        @break
                                                    @endif
                                                    <div class="col-12 d-flex {{$detail['note'] == null ? 'border-bottom' : ''}}" >
                                                        <div class="d-flex detail_memo align-items-center" data-id='{{$key}}' >
                                                            <div class="px-1 py-1 text-start product_cover" style="width:230px;">
                                                                <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                                <span class="product_name">{{$detail['product_name']}}</span>
                                                                <span class="product_id d-none"></span>
                                                                {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                            </div>
                                                            <div class="px-1 py-1 text-center color" style="width:40px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                            <div class="px-1 py-1 text-center reciprocal_number" style="width:40px">{{$detail['reciprocal_number']}}</div>
                                                            <div class="px-1 py-1 text-center standard" style="width:40px">{{$detail['standard']}}</div>
                                                            <div class="px-1 py-1 text-center quantity" style="width:40px">{{number_format($detail['quantity'],2)}}</div>
                                                            <div class="px-1 py-1 text-center unit" style="width:40px">{{$detail['unit']}}</div>

                                                            <div class="px-1 py-1 text-center sales_discount_rate" style="width:50px">{{number_format($detail['sales_discount_rate'],2)}}</div>
                                                            <div class="px-1 py-1 text-center price" style="width:90px">{{number_format($detail['price'],2)}}</div>

                                                            <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                            <div class="px-1 py-1 text-center delivery_term" style="width:100px">{{ empty($detail['delivery_term']) ? "" : date('Y/m/d',strtotime($detail['delivery_term'])) }}</div>
                                                            <!-- <div class="d-none product_code">{{$detail['product_code']}}</div> -->
                                                        </div>
                                                    </div>
                                                    @if($detail['note'])
                                                        <div class="col-12 d-flex border-bottom-note" >
                                                            <div class="ms-2 detail_memo " data-id='{{$key}}' style="width: 360px;">
                                                                {{$detail['note']}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                        </div>
                                        @if($count < 9)
                                            <div class="col-6" style="font-size:10px">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total" style="padding:5px 20px 5px 20px;font-size:10px">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- page 2 --}}
                                @if($count >= 9)
                                    <div class="card px-5">
                                        <div class="row justify-content-between card-body" style="font-size:10px">
                                            @foreach ($data['item_contract'] as $key => $detail)
                                                @if($key > 8)
                                                    <div class="col-12 d-flex ps-0 {{$detail['note'] == null ? 'border-bottom' : ''}}" >
                                                        <div class="d-flex detail_memo align-items-center" data-id='{{$key}}' >
                                                            <div class="px-1 py-1 text-start product_cover" style="width:230px;">
                                                                <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                                <span class="product_name">{{$detail['product_name']}}</span>
                                                                <span class="product_id d-none"></span>
                                                                {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                            </div>
                                                            <div class="px-1 py-1 text-center color" style="width:40px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                            <div class="px-1 py-1 text-center reciprocal_number" style="width:40px">{{$detail['reciprocal_number']}}</div>
                                                            <div class="px-1 py-1 text-center standard" style="width:40px">{{$detail['standard']}}</div>
                                                            <div class="px-1 py-1 text-center quantity" style="width:40px">{{number_format($detail['quantity'],2)}}</div>
                                                            <div class="px-1 py-1 text-center unit" style="width:40px">{{$detail['unit']}}</div>

                                                            <div class="px-1 py-1 text-center sales_discount_rate" style="width:50px">{{number_format($detail['sales_discount_rate'],2)}}</div>
                                                            <div class="px-1 py-1 text-center price" style="width:90px">{{number_format($detail['price'],2)}}</div>

                                                            <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                            <div class="px-1 py-1 text-center delivery_term" style="width:100px">{{ empty($detail['delivery_term']) ? "" : date('Y/m/d',strtotime($detail['delivery_term'])) }}</div>
                                                            <!-- <div class="d-none product_code">{{$detail['product_code']}}</div> -->
                                                        </div>
                                                    </div>
                                                    @if($detail['note'])
                                                        <div class="col-12 d-flex border-bottom-note">
                                                            <div class="ms-2 detail_memo" data-id='{{$key}}' style="width: 360px;">
                                                                {{$detail['note']}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <div class="col-6 mt-3">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total mt-3" style="padding:5px 20px 5px 20px;">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="purchase" role="tabpanel">
                                <div class="card px-5">
                                    <div class="row justify-content-between card-body position-relative">
                                        @if(isset($data['is_detail']))
                                            <div class="col-12 mb-2 position-absolute" style="top:10px;right:0px;">
                                                <a href="{{route('supplier-contract.downLoadPurchasePDF',$data['is_detail'])}}" class="btn bg-grey-table float-end border" ><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                <a href="{{route('supplier-contract.edit',$data['is_detail'])}}" class="btn bg-grey-table float-end me-2 border"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                            </div>
                                        @endif
                                        <div class="col-12 text-center mt-2">
                                            <label class="h3 fw-bold">{{__('admin.contract_purchase')}}</label>
                                        </div>
                                        <div class="col-4">
                                            <div class="row font-size-8">
                                                @php 
                                                    $customer = "";
                                                    $post_code = "";
                                                    $cus_address = "" ; 
                                                    $cus_name = "";
                                                    foreach($list_customer as $cus){
                                                        if($cus->id == $data['customer_id']){
                                                            $post_code = $cus->post_code;             
                                                            if($cus->address_for_delivery){
                                                                $cus_address = $cus->address_for_delivery;
                                                            } else {
                                                                $cus_address = $cus->address;
                                                            }
                                                            $cus_name = $cus->name;
                                                        }
                                                    } 
                                                    $supplier = "" ;
                                                    foreach($list_supplier as $sup){
                                                        if($sup->id == $data['supplier_id']){
                                                            $supplier = $sup->name;
                                                        }
                                                    } 
                                                @endphp
                                                <div class="col-4 p-15 border border-end-0">{{__('admin.customer_post_code')}}</div>
                                                <div class="col-8 p-15 border"><span class="order_date_paper">{{$post_code}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.customer_adress')}}</div>
                                                <div class="col-8 p-15 border-top-0 border"><span class="order_date_paper">{{$cus_address}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                                <div class="col-8 p-15 border-top-0 border"><span class="order_date_paper">{{$cus_name}}</span></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['created_date'] != null) ? date('Y/m/d', strtotime($data['created_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_order_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['order_date'] != null) ? date('Y/m/d', strtotime($data['order_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                                <div class="col-7 text-end"><span class="slit_number_paper">{{$data['slip_number']}}</span></div>

                                                <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                                <div class="col-7 text-end"><span class="person_in_charge_paper">{{$person_in_charge ? $person_in_charge->name : ''}}</span></div>

                                                <div class="col-5">{{__('admin.supplier_contract_order_number')}}</div>
                                                <div class="col-7 text-end"><span class="order_number_paper">{{$data['order_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{$data['order_code']}}</span></div>

                                                <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                                <div class="col-7 text-end seri-number">{{$data['serial_number']}}</div>

                                                <div class="col-5 mb-2">{{__('admin.product_creditor')}}</div>
                                                <div class="col-7 text-end created-person">{{$data['created_person']}}</div>
                                                
                                                <div class="col-12 font-size-12">株式会社ヤマプラス</div>
                                                <div class="col-12">本社 東京都港区白金台2-25-1</div>
                                                <div class="col-12">TEL 第１営業部 (03)3443-3355</div>
                                                <div class="col-12">TEL 第２営業部 (03)3443-3371</div>
                                            </div>
                                        </div>
                                        {{-- <div class="mask-total col-12 mt-3 ">
                                            <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                            <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                        </div> --}}
                                        <div class="mt-3 col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                            <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                                <div class="px-1 py-1 text-start" style="width:230px;">{{__('admin.product_name')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_color')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:200px">取引寸</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_inverse')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_symbol')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_quantity')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:40px">{{__('admin.product_unit')}}</div>

                                                <div class="px-1 text-center" style="width:140px">
                                                    <span>{{__('admin.product_earnings')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>


                                                <div class="px-1 py-1 text-center" style="width:50px">{{__('admin.product_previous_generation')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                            </div>
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($data['item_contract'] as $key => $detail)
                                                    @if($count == 9)
                                                        @break
                                                    @endif
                                                    <div class="col-12 d-flex {{$detail['note'] == null ? 'border-bottom' : ''}}" >
                                                        <div class="d-flex detail_memo align-items-center" data-id='{{$key}}' >
                                                            <div class="px-1 py-1 text-start product_cover" style="width:230px;">
                                                                <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                                <span class="product_name">{{$detail['product_name']}}</span>
                                                                <span class="product_id d-none"></span>
                                                                {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                            </div>
                                                            <div class="px-1 py-1 text-center color" style="width:40px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                            <div class="px-1 py-1 text-center reciprocal_number" style="width:40px">{{$detail['reciprocal_number']}}</div>
                                                            <div class="px-1 py-1 text-center standard" style="width:40px">{{$detail['standard']}}</div>
                                                            <div class="px-1 py-1 text-center quantity" style="width:40px">{{number_format($detail['quantity'],2)}}</div>
                                                            <div class="px-1 py-1 text-center unit" style="width:40px">{{$detail['unit']}}</div>

                                                            <div class="px-1 py-1 text-center sales_discount_rate" style="width:50px">{{number_format($detail['sales_discount_rate'],2)}}</div>
                                                            <div class="px-1 py-1 text-center price" style="width:90px">{{number_format($detail['price'],2)}}</div>

                                                            <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                            <div class="px-1 py-1 text-center delivery_term" style="width:100px">{{ empty($detail['delivery_term']) ? "" : date('Y/m/d',strtotime($detail['delivery_term'])) }}</div>
                                                            <!-- <div class="d-none product_code">{{$detail['product_code']}}</div> -->
                                                        </div>
                                                    </div>
                                                    @if($detail['note'])
                                                        <div class="col-12 d-flex border-bottom-note" >
                                                            <div class="ms-2 detail_memo " data-id='{{$key}}' style="width: 360px;">
                                                                {{$detail['note']}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                        </div>
                                        @if($count < 9)
                                            <div class="col-6" style="font-size:10px">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total" style="padding:5px 20px 5px 20px;font-size:10px">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- page 2 --}}
                                @if($count >= 9)
                                    <div class="card px-5">
                                        <div class="row justify-content-between card-body" style="font-size:10px">
                                            @foreach ($data['item_contract'] as $key => $detail)
                                                @if($key > 8)
                                                    <div class="col-12 d-flex {{$detail['note'] == null ? 'border-bottom' : ''}} ps-0" >
                                                        <div class="d-flex detail_memo align-items-center" data-id='{{$key}}' >
                                                            <div class="px-1 py-1 text-start product_cover" style="width:230px;">
                                                                <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                                <span class="product_name">{{$detail['product_name']}}</span>
                                                                <span class="product_id d-none"></span>
                                                                {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                            </div>
                                                            <div class="px-1 py-1 text-center color" style="width:40px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                            <div class="px-1 py-1 text-center reciprocal_number" style="width:40px">{{$detail['reciprocal_number']}}</div>
                                                            <div class="px-1 py-1 text-center standard" style="width:40px">{{$detail['standard']}}</div>
                                                            <div class="px-1 py-1 text-center quantity" style="width:40px">{{number_format($detail['quantity'],2)}}</div>
                                                            <div class="px-1 py-1 text-center unit" style="width:40px">{{$detail['unit']}}</div>

                                                            <div class="px-1 py-1 text-center sales_discount_rate" style="width:50px">{{number_format($detail['sales_discount_rate'],2)}}</div>
                                                            <div class="px-1 py-1 text-center price" style="width:90px">{{number_format($detail['price'],2)}}</div>

                                                            <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                            <div class="px-1 py-1 text-center delivery_term" style="width:100px">{{ empty($detail['delivery_term']) ? "" : date('Y/m/d',strtotime($detail['delivery_term'])) }}</div>
                                                            <!-- <div class="d-none product_code">{{$detail['product_code']}}</div> -->
                                                        </div>
                                                    </div>
                                                    @if($detail['note'])
                                                        <div class="col-12 d-flex border-bottom-note" >
                                                            <div class="ms-2 detail_memo" data-id='{{$key}}' style="width: 360px;">
                                                                {{$detail['note']}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <div class="col-6 mt-3">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total mt-3" style="padding:5px 20px 5px 20px;">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="order" role="tabpanel">
                                <div class="card px-5">
                                    <div class="row justify-content-between card-body position-relative">
                                        @if(isset($data['is_detail']))
                                            <div class="col-12 mb-2 position-absolute" style="top:10px;right:0px;">
                                                <a href="{{route('supplier-contract.downLoadOrderPDF',$data['is_detail'])}}" class="btn bg-grey-table float-end border" ><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                <a href="{{route('supplier-contract.edit',$data['is_detail'])}}" class="btn bg-grey-table float-end me-2 border"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                            </div>
                                        @endif
                                        <div class="col-12 text-center">
                                            <label class="h3 fw-bold">{{__('admin.contract_order')}}</label>
                                        </div>
                                        <div class="col-4">
                                            <div class="row font-size-8">
                                                <div class="col-4 p-15 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                                <div class="col-8 p-15 border"><span class="order_date_paper">{{($data['order_date'] != null) ? date('Y/m/d', strtotime($data['order_date'])) : ""}}</span></div>
                                                <!-- <div class="col-3 p-15 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                                <div class="col-3 p-15 border"><span class="place_of_import_paper">{{$data['place_of_import']}}</span></div> -->

                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                                @php 
                                                $customer = "";
                                                foreach($list_customer as $cus){
                                                    if($cus->id == $data['customer_id']){
                                                        $customer = $cus->name;
                                                    }
                                                } 
                                                $supplier = "" ;
                                                foreach($list_supplier as $sup){
                                                    if($sup->id == $data['supplier_id']){
                                                        $supplier = $sup->name;
                                                    }
                                                } 
                                                @endphp
                                                <div class="col-8 p-15 border border-top-0"><span class="supplier_id_paper">{{$supplier}}</span></div>
                                                {{-- <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="customer_id_paper">{{$customer}}</span></div> --}}
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_destination_paper">{{$data['delivery_destination']}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_address_paper">{{$data['delivery_address']}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                                <div class="col-8 p-15 border border-top-0"><span class="delivery_phone_number_paper">{{$data['delivery_phone_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['created_date'] != null) ? date('Y/m/d', strtotime($data['created_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                                <div class="col-7 text-end"><span class="slit_number_paper">{{$data['slip_number']}}</span></div>

                                                <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                                <div class="col-7 text-end"><span class="person_in_charge_paper">{{$person_in_charge ? $person_in_charge->name : ''}}</span></div>

                                                <div class="col-5">{{__('admin.supplier_contract_order_number')}}</div>
                                                <div class="col-7 text-end"><span class="order_number_paper">{{$data['order_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{$data['order_code']}}</span></div>

                                                <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                                <div class="col-7 text-end seri-number">{{$data['serial_number']}}</div>

                                                <div class="col-5 mb-2">{{__('admin.product_creditor')}}</div>
                                                <div class="col-7 text-end created-person">{{$data['created_person']}}</div>

                                                <div class="col-12 font-size-12">株式会社ヤマプラス</div>
                                                <div class="col-12">本社 東京都港区白金台2-25-1</div>
                                                <div class="col-12">TEL 第１営業部 (03)3443-3355</div>
                                                <div class="col-12">TEL 第２営業部 (03)3443-3371</div>
                                            </div>
                                        </div>
                                        {{-- <div class="mask-total col-12 mt-3 ">
                                            <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                            <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                        </div> --}}
                                        <div class="mt-3 col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                            <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                                <div class="px-1 py-1 text-start text-wrap" style="width:230px;">{{__('admin.product_code_name')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:200px">取引寸</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                                <div class="px-1 text-center" style="width:83px">
                                                    <span>{{__('admin.product_purchage')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:33px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>

                                                <div class="px-1 text-center" style="width:83px">
                                                    <span>{{__('admin.product_earnings')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:33px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>

                                                <div class="px-1 py-1 text-center" style="width:50px">{{__('admin.product_previous_generation')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                            </div>
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach($data['item_contract'] as $key => $detail)
                                                @if($count == 9)
                                                    @break
                                                @endif
                                                <div class="d-flex align-items-center {{$detail['note'] == null ? 'border-bottom' : ''}} detail_memo" data-id='{{$key}}'>
                                                    <div class="px-1 py-1 text-start text-wrap product_cover" style="width:230px;">
                                                        <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                        <span class="product_name">{{$detail['product_name']}}</span>
                                                        {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                    </div>
                                                    <div class="px-1 py-1 text-center color" style="width:33px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                    <div class="px-1 py-1 text-center reciprocal_number" style="width:33px">{{$detail['reciprocal_number']}}</div>
                                                    <div class="px-1 py-1 text-center standard" style="width:33px">{{$detail['standard']}}</div>
                                                    <div class="px-1 py-1 text-center quantity" style="width:33px">{{number_format($detail['quantity'],2)}}</div>
                                                    <div class="px-1 py-1 text-center unit" style="width:33px">{{$detail['unit']}}</div>
                                                
                                                    <div class="px-1 py-1 text-center buy_in_discount_rate" style="width:33px">{{number_format($detail['buy_in_discount_rate'],2)}}</div>
                                                    <div class="px-1 py-1 text-center buy_price" style="width:50px">{{number_format($detail['buy_price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center sales_discount_rate" style="width:33px">{{number_format($detail['sales_discount_rate'],2)}}</div>
                                                    <div class="px-1 py-1 text-center price" style="width:50px">{{number_format($detail['price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                    <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                    <div class="px-1 py-1 text-center delivery_term" style="width:90px">{{$detail['delivery_term']}}</div>
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                                @if($detail['note'])
                                                    <div class="col-12 d-flex border-bottom-note" >
                                                        <div class="ms-2 detail_memo" data-id='{{$key}}' style="width: 360px;">
                                                            {{$detail['note']}}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if($count < 9)
                                            <div class="col-6" style="font-size:10px">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            {{-- <div class="col-5 mask-total" style="padding:5px 20px 5px 20px;font-size:10px">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        @endif
                                    </div>
                                </div>
                                {{-- page 2 --}}
                                @if($count >= 9)
                                    <div class="card px-5">
                                        <div class="row justify-content-between card-body" style="font-size:10px">
                                            @foreach ($data['item_contract'] as $key => $detail)
                                                @if($key > 8)
                                                <div class="d-flex align-items-center detail_memo ps-0" data-id='{{$key}}'>
                                                    <div class="px-1 py-1 text-start text-wrap product_cover" style="width:230px;">
                                                        <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                        <span class="product_name">{{$detail['product_name']}}</span>
                                                        {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                    </div>
                                                    <div class="px-1 py-1 text-center color" style="width:33px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                    <div class="px-1 py-1 text-center reciprocal_number" style="width:33px">{{$detail['reciprocal_number']}}</div>
                                                    <div class="px-1 py-1 text-center standard" style="width:33px">{{$detail['standard']}}</div>
                                                    <div class="px-1 py-1 text-center quantity" style="width:33px">{{number_format($detail['quantity'],2)}}</div>
                                                    <div class="px-1 py-1 text-center unit" style="width:33px">{{$detail['unit']}}</div>
                                                
                                                    <div class="px-1 py-1 text-center buy_in_discount_rate" style="width:33px">{{number_format($detail['buy_in_discount_rate'],2)}}</div>
                                                    <div class="px-1 py-1 text-center buy_price" style="width:50px">{{number_format($detail['buy_price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center sales_discount_rate" style="width:33px">{{number_format($detail['buy_price'],2)}}</div>
                                                    <div class="px-1 py-1 text-center price" style="width:50px">{{number_format($detail['price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                    <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                    <div class="px-1 py-1 text-center delivery_term" style="width:90px">{{$detail['delivery_term']}}</div>
                                                </div>
                                                @if($detail['note'])
                                                    <div class="col-12 d-flex border-bottom-note" >
                                                        <div class="ms-2 detail_memo" data-id='{{$key}}' style="width: 360px;">
                                                            {{$detail['note']}}
                                                        </div>
                                                    </div>
                                                @endif
                                                @endif
                                            @endforeach
                                            <div class="col-6 mt-3">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            {{-- <div class="col-5 mask-total mt-3" style="padding:5px 20px 5px 20px;">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="copy" role="tabpanel">
                                <div class="card px-5">
                                    <div class="row justify-content-between card-body position-relative">
                                        @if(isset($data['is_detail']))
                                            <div class="col-12 mb-2 position-absolute" style="top:10px;right:0px;">
                                                <a href="{{route('supplier-contract.downLoadCopyPDF',$data['is_detail'])}}" class="btn bg-grey-table float-end border" ><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                <a href="{{route('supplier-contract.edit',$data['is_detail'])}}" class="btn bg-grey-table float-end me-2 border"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                            </div>
                                        @endif
                                        <div class="col-12 text-center">
                                            <label class="h3 fw-bold">{{__('admin.contract_copy')}}</label>
                                        </div>
                                        <div class="col-4">
                                            <div class="row font-size-8"> 
                                                @php 
                                                    $customer = "";
                                                    
                                                    foreach($list_customer as $cus){
                                                        if($cus->id == $data['customer_id']){
                                                            $post_code = $cus->post_code;
                                                            $cus_address = $cus->address;
                                                            $cus_name = $cus->name;
                                                        }
                                                    } 
                                                    $supplier = "" ;
                                                    foreach($list_supplier as $sup){
                                                        if($sup->id == $data['supplier_id']){
                                                            $supplier = $sup->name;
                                                        }
                                                    } 
                                                @endphp
                                                <div class="col-4 p-15 border border-end-0">{{__('admin.customer_post_code')}}</div>
                                                <div class="col-8 p-15 border"><span class="order_date_paper">{{$post_code}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.customer_adress')}}</div>
                                                <div class="col-8 p-15 border-top-0 border"><span class="order_date_paper">{{$cus_address}}</span></div>
                                                <div class="col-4 p-15 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                                <div class="col-8 p-15 border-top-0 border"><span class="order_date_paper">{{$cus_name}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['created_date'] != null) ? date('Y/m/d', strtotime($data['created_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_order_date')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{($data['order_date'] != null) ? date('Y/m/d', strtotime($data['order_date'])) : ""}}</span></div>

                                                <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                                <div class="col-7 text-end"><span class="slit_number_paper">{{$data['slip_number']}}</span></div>

                                                <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                                <div class="col-7 text-end"><span class="person_in_charge_paper">{{$person_in_charge ? $person_in_charge->name : ''}}</span></div>

                                                <div class="col-5">{{__('admin.supplier_contract_order_number')}}</div>
                                                <div class="col-7 text-end"><span class="order_number_paper">{{$data['order_number']}}</span></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row font-size-8">
                                                <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                                <div class="col-7 text-end"><span class="create_date_paper">{{$data['order_code']}}</span></div>

                                                <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                                <div class="col-7 text-end seri-number">{{$data['serial_number']}}</div>

                                                <div class="col-5 mb-2">{{__('admin.product_creditor')}}</div>
                                                <div class="col-7 text-end created-person">{{$data['created_person']}}</div>

                                                <div class="col-12 font-size-12">株式会社ヤマプラス</div>
                                                <div class="col-12">本社 東京都港区白金台2-25-1</div>
                                                <div class="col-12">TEL 第１営業部 (03)3443-3355</div>
                                                <div class="col-12">TEL 第２営業部 (03)3443-3371</div>
                                                <div class="col-12">登録番号 T1010401030016</div>
                                            </div>
                                        </div>
                                        <div class="mask-total col-12 mt-3 ">
                                            <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                            <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                        </div>
                                        <div class="col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                            <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                                <div class="px-1 py-1 text-start text-wrap" style="width:230px;">{{__('admin.product_code_name')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:200px">取引寸</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                                <div class="px-1 text-center" style="width:83px">
                                                    <span>{{__('admin.product_purchage')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:33px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>

                                                <div class="px-1 text-center" style="width:83px">
                                                    <span>{{__('admin.product_earnings')}}</span>
                                                    <div class="d-flex">
                                                        <div class="px-1 fw-normal" style="width:33px">{{__('admin.product_hanging_rate')}}</div>
                                                        <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                    </div>
                                                </div>

                                                <div class="px-1 py-1 text-center" style="width:50px">{{__('admin.product_previous_generation')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                                <div class="px-1 py-1 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                            </div>
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach($data['item_contract'] as $key => $detail)
                                                @if($count == 9)
                                                    @break
                                                @endif
                                                <div class="d-flex align-items-center {{$detail['note'] == null ? 'border-bottom' : ''}} detail_memo" data-id='{{$key}}'>
                                                    <div class="px-1 py-1 text-start text-wrap product_cover" style="width:230px;">
                                                        <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                        <span class="product_name">{{$detail['product_name']}}</span>
                                                        {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                    </div>
                                                    <div class="px-1 py-1 text-center color" style="width:33px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                    <div class="px-1 py-1 text-center reciprocal_number" style="width:33px">{{$detail['reciprocal_number']}}</div>
                                                    <div class="px-1 py-1 text-center standard" style="width:33px">{{$detail['standard']}}</div>
                                                    <div class="px-1 py-1 text-center quantity" style="width:33px">{{number_format($detail['quantity'],2)}}</div>
                                                    <div class="px-1 py-1 text-center unit" style="width:33px">{{$detail['unit']}}</div>
                                                
                                                    <div class="px-1 py-1 text-center buy_in_discount_rate" style="width:33px">{{number_format($detail['buy_in_discount_rate'],2)}}</div>
                                                    <div class="px-1 py-1 text-center buy_price" style="width:50px">{{number_format($detail['buy_price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center sales_discount_rate" style="width:33px">{{number_format($detail['buy_price'],2)}}</div>
                                                    <div class="px-1 py-1 text-center price" style="width:50px">{{number_format($detail['price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                    <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                    <div class="px-1 py-1 text-center delivery_term" style="width:90px">{{$detail['delivery_term']}}</div>
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                                @if($detail['note'])
                                                <div class="col-12 d-flex border-bottom-note" >
                                                    <div class="ms-2" data-id='{{$key}}' style="width: 360px;">
                                                        {{$detail['note']}}
                                                    </div>
                                                </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @if($count < 9)
                                            <div class="col-6" style="font-size:10px">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total" style="padding:5px 20px 5px 20px;font-size:10px" >
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- page 2 --}}
                                @if($count >= 9)
                                    <div class="card px-5">
                                        <div class="row justify-content-between card-body" style="font-size:10px">
                                            @foreach ($data['item_contract'] as $key => $detail)
                                                @if($key > 8)
                                                <div class="d-flex align-items-center  detail_memo ps-0" data-id='{{$key}}'>
                                                    <div class="px-1 py-1 text-start text-wrap product_cover" style="width:230px;">
                                                        <!-- <div class="product_code text-grey">{{$detail['product_code']}}</div> -->
                                                        <span class="product_name">{{$detail['product_name']}}</span>
                                                        {{-- <div class="description_paper text-grey">{{$detail['note']}}</div> --}}
                                                    </div>
                                                    <div class="px-1 py-1 text-center color" style="width:33px">{{$detail['color']}}</div>
                                                            <div class="px-1 py-1 text-center" style="width:200px">
                                                                <div>{{$detail['trade_size_1']}}</div>
                                                                <div>{{$detail['trade_size_2']}}</div>
                                                            </div>
                                                    <div class="px-1 py-1 text-center reciprocal_number" style="width:33px">{{$detail['reciprocal_number']}}</div>
                                                    <div class="px-1 py-1 text-center standard" style="width:33px">{{$detail['standard']}}</div>
                                                    <div class="px-1 py-1 text-center quantity" style="width:33px">{{number_format($detail['quantity'],2)}}</div>
                                                    <div class="px-1 py-1 text-center unit" style="width:33px">{{$detail['unit']}}</div>
                                                
                                                    <div class="px-1 py-1 text-center buy_in_discount_rate" style="width:33px">{{number_format($detail['buy_in_discount_rate'],2)}}</div>
                                                    <div class="px-1 py-1 text-center buy_price" style="width:50px">{{number_format($detail['buy_price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center sales_discount_rate" style="width:33px">{{number_format($detail['buy_price'],2)}}</div>
                                                    <div class="px-1 py-1 text-center price" style="width:50px">{{number_format($detail['price'],2)}}</div>
                                                
                                                    <div class="px-1 py-1 text-center consignment" style="width:50px">{{number_format($detail['consignment'],2)}}</div>
                                                    <div class="px-1 py-1 text-center" style="width:33px"><span class="tax">{{$detail['tax']}}</span>%</div>
                                                    <div class="px-1 py-1 text-center delivery_term" style="width:90px">{{$detail['delivery_term']}}</div>
                                                </div>
                                                @if($detail['note'])
                                                    <div class="col-12 d-flex border-bottom-note" >
                                                        <div class="ms-2 detail_memo" data-id='{{$key}}' style="width: 360px;">
                                                            {{$detail['note']}}
                                                        </div>
                                                    </div>
                                                @endif
                                                @endif
                                            @endforeach
                                            <div class="col-6 mt-3">
                                                <div class="row mb-2">
                                                    <div class="col-5">{{__('admin.contract_memo')}}</div>
                                                    <div class="col-7 text-end"></div>
                                                </div>
                                                <div class="text-grey">
                                                    <span class="note_paper">{{$data['note']}}</span>
                                                </div>
                                            </div>
                                            <div class="col-5 mask-total mt-3" style="padding:5px 20px 5px 20px;">
                                                <div class="row">
                                                    <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                                    <div class="col-6 text-end"><span class="total"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                                    <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                                    <div class="col-6">{{__('admin.preview_total')}}</div>
                                                    <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                                    <div class="tax_percent col-12">
                                                        <div class="row">
                                                            <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                                    class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                            <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                            <div class="col-6"></div>
                                                            <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>
@endsection
@section('script')
<script src="js/edit-memo-supplier-contract.js"></script>
<script>
    getTotal()
    function getTotal(){
        total_tax = 0;
        tax = 0;
        total = 0;
        tax_array = {};
        $('#copy .paper_memo_2 .detail_memo').each(function (index) {
            consignment = parseFloat($(this).find('.consignment').text().replace(/,/g, ''))
            quantity = parseFloat($(this).find('.quantity').text().replace(/,/g, ''))
            sales_discount_rate = parseFloat($(this).find('.sales_discount_rate').text().replace(/,/g, ''))
            price = parseFloat($(this).find('.price').text().replace(/,/g, ''))
            tax = parseFloat($(this).find('.tax').text().replace(/,/g, ''))

            total_price = 0;
            if (price) {
                total_tax += (quantity * price * tax / 100) + (quantity * price);
                total_price = (quantity * price);
                total += total_price
            } else {
                total_price = (quantity * sales_discount_rate * consignment/ 100)  + (quantity * sales_discount_rate)
                total += total_price
                total_tax += (total_price * tax / 100) + (total_price);
            }
            if (!tax_array[tax]) {
                tax_array[tax] = 0;
            }
            tax_array[tax] += total_price;
        });
        if(!isNaN(total_tax) && !isNaN(total)){
            $('.mask-total .total_tax').text(Math.floor(total_tax).toLocaleString('ja-JP'));
            $('.mask-total .total').text(Math.floor(total).toLocaleString('ja-JP'));
            tax = total_tax - total;
            $('.mask-total .tax').text(Math.floor(tax).toLocaleString('ja-JP'))
        }

        html = "";
        title = 1;
        $.each(tax_array, function(tax, total_price ) {
            if(isNaN(tax) || isNaN(total_price)){
                tax = "";
                total_price = "";
            }
            title_preview_items = '<span style="margin: 17px"></span>';
            if (title == 1){
                title_preview_items = lang_ja['preview_items'];
            }
            title++;
            html+= '<div class="row">'
            html+= '<div class="col-6 text-grey">'+title_preview_items+' <span class="percent_tax">'+tax+'</span>'+lang_ja['preview_percent_tax']+' </div>'
            html+= '<div class="col-6 text-end text-grey"><span class="total">'+Math.floor(total_price).toLocaleString('ja-JP')+'</span>  円</div>'
            html+= '<div class="col-6"></div>'
            tax_money = tax * total_price /100
            html+= '<div class="col-6 text-end text-grey"><span class="tax">'+Math.floor(tax_money).toLocaleString('ja-JP')+'</span>  円</div>'
            html+= '</div>'
        });
        $('.tax_percent').empty();
        $('.tax_percent').append(html);
    }
    $('.btn-reload').click(function(){
        location.reload();
    })
</script>
@endsection
