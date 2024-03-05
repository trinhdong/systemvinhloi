@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.original_contract_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
    <style>
        .text-grey {
            color: rgb(122, 120, 120)
        }

        .width-col-258 {
            width: 258px;
        }

        .width-col-50 {
            width: 50px;
        }

        .width-col-66 {
            width: 66px;
        }

        .width-col-90 {
            width: 90px;
        }

        .padding-input {
            padding: 6px 2px;
        }

        .btn-close-col-left {
            color: black;

        }

        .btn-close-col-left:hover {
            color: rgb(121, 121, 121);
        }

        .tab-memo li {
            width: 25%;
        }

        .bg-grey-table{
            background-color: rgb(240, 235, 235);
        }
    </style>
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.original_contract_detail')}}
@endsection
@section('content')

    <div class="flex-container justify-content-center">
        <div class="col-left mt-5">
            <div class="text-end pb-2" style="color:black">
                <a class="btn-preview btn btn-primary text-white mb-1" ><h5 class="m-0">プレビュー表示</h5></a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="p-3 rounded">
                        <div class="row g-3 form-all">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.original_contract_order_number')}}</label>
                                <input type="text" class="form-control order_number" name="order_number"
                                       value="{{$original_contract->order_number}}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_order_date')}}</label>
                                <input type="text" class="form-control order_date" name="order_date"
                                       value="{{date('Y/m/d', strtotime($original_contract->order_date))}}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_place_of_import')}}</label>
                                <input type="text" class="form-control place_of_import" name="place_of_import"
                                       value="{{$original_contract->place_of_import}}" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_created_date')}}</label>
                                <input type="text" class="form-control created_date"
                                       value="{{date('Y/m/d', strtotime($original_contract->created_date))}}" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">{{__('admin.contract_slit_number')}}</label>
                                <input type="text" class="form-control slip_number" name="slip_number"
                                       value="{{$original_contract->slip_number}}" min="1" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">{{__('admin.contract_person_in_charge')}}</label>
                                @php
                                    $person_in_charge = null;
                                    foreach ($list_user as $key => $user) {
                                        if($original_contract->person_in_charge == $user->id){
                                            $person_in_charge = $user;
                                        }
                                    }
                                @endphp
                            <input readonly type="text" class="form-control person_in_charge" name="person_in_charge" value="{{$person_in_charge ? $person_in_charge->name : '削除されました'}}" >
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_order_code')}}</label>
                                <input type="text" class="form-control order_code" name=""
                                       value="{{$original_contract->order_code}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_supplier_id')}}</label>
                                <input type="text" class="form-control supplier" name="supplier_id"
                                      data-id="{{$original_contract->supplier->id}}" value="{{$original_contract->supplier->supplier_code.' '.$original_contract->supplier->name}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_customer_id')}}</label>
                                
                                <input type="text" class="form-control customer" name="customer_id"
                                        data-id="{{($original_contract->Customer) ? $original_contract->Customer->id : '' }}" value="{{($original_contract->Customer) ? $original_contract->Customer->customer_code.' '.$original_contract->Customer->name : __('message.404_not_found')}}" readonly>
                            </div>
                            <div class="col-sm-7">
                                <label class="form-label">{{__('admin.contract_delivery_destination')}}</label>
                                <input type="text" class="form-control delivery_destination" name="delivery_destination"
                                       value="{{$original_contract->delivery_destination}}" readonly>
                            </div>
                            <div class="col-sm-5">
                                <label class="form-label">{{__('admin.contract_delivery_phone')}}</label>
                                <input type="text" class="form-control delivery_phone_number"
                                       name="delivery_phone_number"
                                       value="{{$original_contract->delivery_phone_number}}" readonly>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.contract_delivery_address')}}</label>
                                <input type="text" class="form-control delivery_address" name="delivery_address"
                                       value="{{$original_contract->delivery_address}}" readonly>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <label for="" class="h5">{{__('admin.contract_detail')}} </label> <span class="badge bg-secondary">{{__('admin.contract_big_item')}}</span>
                            </div>
                            <div class="col-sm-12 table-responsive text-nowrap">
                                <div class="form-input-original-contract" style="min-width:1570px;width:100%;">
                                    <div class="fw-bold d-flex font-strong border-bottom border-top py-1">
                                        <div class="px-1 py-2 text-center" style="min-width:360px;width:100%">{{__('admin.product_code_name')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_color')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:200px;width:100%">取引寸</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_inverse')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_symbol')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_quantity')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_unit')}}</div>

                                        <div class="px-1 text-center" style="min-width:150px;width:100%">
                                            <span>{{__('admin.product_purchage')}}</span>
                                            <div class="d-flex">
                                                <div class="px-1 fw-normal" style="min-width:50px;width:100%">{{__('admin.product_hanging_rate')}}</div>
                                                <div class="px-1 fw-normal" style="min-width:90px;width:100%">{{__('admin.product_price')}}</div>
                                            </div>
                                        </div>
                                        <div class="px-1 text-center" style="min-width:150px;width:100%">
                                            <span>{{__('admin.product_earnings')}}</span>
                                            <div class="d-flex">
                                                <div class="px-1 fw-normal" style="min-width:50px;width:100%">{{__('admin.product_hanging_rate')}}</div>
                                                <div class="px-1 fw-normal" style="min-width:90px;width:100%">{{__('admin.product_price')}}</div>
                                            </div>
                                        </div>

                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_previous_generation')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_tax')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{__('admin.product_deadline')}}</div>

                                    </div>
                                    @foreach($original_contract->originalContractDetail as $key => $item)
                                        <div class="d-flex align-items-center border-bottom form-memo" data-id="{{$item->id}}">
                                            <div class="px-1 py-2 text-center" style="min-width:360px;width:100%">
                                                <div class="d-flex align-items-center">
                                                    <div class="product_code" style="min-width:50px;width:100%">{{$item->product_code}}</div>
                                                    <div class="product_name_{{$item->id}}" style="min-width:310px; white-space: pre-wrap">{{$item->product_name}}</div>
                                                </div>
                                            </div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{$item->color}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:200px;width:100%">
                                                <div>{{$item->trade_size_1}}</div>
                                                <div>{{$item->trade_size_2}}</div>
                                            </div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{$item->reciprocal_number}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{$item->standard}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{number_format($item->quantity,2)}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{$item->unit}}</div>

                                            <div class="px-1 text-center d-flex" style="min-width:150px;width:100%">
                                                <div class="px-1 py-2 text-center" style="min-width:50px;width:100%">{{number_format($item->buy_in_discount_rate,2)}}</div>
                                                <div class="px-1 py-2 text-center" style="min-width:90px;width:100%">{{number_format($item->buy_price,2)}}</div>
                                            </div>
                                            <div class="px-1 text-center d-flex" style="min-width:150px;width:100%">
                                                <div class="px-1 py-2 text-center" style="min-width:50px;width:100%">{{number_format($item->sales_discount_rate,2)}}</div>
                                                <div class="px-1 py-2 text-center" style="min-width:90px;width:100%">{{isset($item->price) ? number_format($item->price,2) : "" }}</div>
                                            </div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{number_format($item->consignment,2)}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">{{$item->tax}}</div>
                                            <div class="px-1 py-2 text-center" style="min-width:70px;width:100%">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.product_serial_number')}}</label>
                                <input type="text" class="form-control serial_number" value="{{$original_contract->serial_number}}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.product_creditor')}}</label>
                                <input type="text" class="form-control created_person" value="{{$original_contract->created_person}}" readonly>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.contract_memo')}}</label>
                                <textarea type="text" placeholder="" name="note"
                                          class="form-control note" readonly>{{$original_contract->note}}</textarea>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button onclick="history.back()" class="btn btn-secondary">{{__('admin.btn_back')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-right position-relative" hidden>
            <div class="text-start p-2 position-absolute" style="left:-236px;top:0px;">
                <a class="btn-close-col-left"><h5 class="m-0">{{__('admin.preview_enlarge')}} <i class="fas fa-angle-double-left"></i></h5></a>
            </div>
            <ul class="nav nav-tabs nav-primary d-flex justify-content-center tab-memo" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#quotation" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_quotation')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#order" role="tab" aria-selected="false"
                       tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_order')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#purchase" role="tab" aria-selected="false"
                       tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_purchase')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#copy" role="tab" aria-selected="false"
                       tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_copy')}}</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="card" style="">
                <div class="card-body">
                    <div class="p-2 rounded">
                        <div class="tab-content py-3" style="color:black;">
                            <div class="tab-pane fade active show" id="quotation" role="tabpanel">
                                <div class="row">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <a href="{{route('original-contract-downLoadQuotationPDF',$original_contract->id)}}" class="btn bg-grey-table float-end"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="{{route('edit-original-contract',$original_contract->id)}}" class="btn bg-grey-table float-end me-2"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                    </div>
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_quotation')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span
                                                    class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span>
                                            </div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div
                                                class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            
                                            <div
                                                class="col-8 p-1 border border-top-0 customer_id_paper">{{($original_contract->Customer) ? $original_contract->Customer->name : __('message.404_not_found')}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div
                                                class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div
                                                class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div
                                                class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div
                                                class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span
                                                class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                        <div
                                            class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1"
                                            style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center" style="width:180px;">{{__('admin.product_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:140px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex border-bottom detail_memo align-items-center"
                                                     data-id='{{$item->id}}'>
                                                    <div class="px-1 py-2 text-center product_cover"
                                                         style="width:180px;">
                                                        <!-- <div class="product_code text-grey">{{$item->product_code}}</div> -->
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <span class="product_id d-none">{{$item->product_id}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color"
                                                         style="width:33px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number"
                                                         style="width:33px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard"
                                                         style="width:33px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity"
                                                         style="width:33px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit"
                                                         style="width:33px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate"
                                                         style="width:50px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price"
                                                         style="width:90px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment"
                                                         style="width:33px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:33px"><span
                                                            class="tax">{{$item->tax}}</span>%
                                                    </div>
                                                    <div class="px-1 py-2 text-center delivery_term"
                                                         style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <!-- <div class="d-none product_code">{{$item->product_code}}</div> -->
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->created_person}}</div>
                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
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
                            <div class="tab-pane fade" id="order" role="tabpanel">
                                <div class="row">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <a href="{{route('original-contract-downLoadOrderPDF',$original_contract->id)}}" class="btn bg-grey-table float-end"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="{{route('edit-original-contract',$original_contract->id)}}" class="btn bg-grey-table float-end me-2"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                    </div>
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_order')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span
                                                    class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span>
                                            </div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div
                                                class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            {{-- <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            
                                            <div
                                                class="col-8 p-1 border border-top-0 customer_id_paper">{{($original_contract->Customer) ? $original_contract->Customer->name : __('message.404_not_found')}}</div> --}}
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div
                                                class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div
                                                class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div
                                                class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div
                                                class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span
                                                class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（内{{__('admin.preview_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                        <div
                                            class="fw-bold justify-content-center d-flex font-small font-strong header-table border-bottom border-top py-1"
                                            style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center text-wrap" style="width:120px;">
                                                {{__('admin.product_name')}}
                                            </div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_purchage')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div
                                                    class="d-flex justify-content-center align-items-center border-bottom detail_memo"
                                                    data-id="{{$item->id}}">
                                                    <div class="px-1 py-2 text-center text-wrap product_cover"
                                                         style="width:120px;">
                                                        <!-- <div class="product_code text-grey">{{$item->product_code}}</div> -->
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <span class="product_id d-none">{{$item->product_id}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color"
                                                         style="width:29px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number"
                                                         style="width:29px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard"
                                                         style="width:29px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity"
                                                         style="width:29px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit"
                                                         style="width:29px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center buy_in_discount_rate"
                                                         style="width:29px">{{number_format($item->buy_in_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center buy_price"
                                                         style="width:50px">{{number_format($item->buy_price)}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate"
                                                         style="width:29px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price"
                                                         style="width:50px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment"
                                                         style="width:29px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:29px"><span
                                                            class="tax">{{$item->tax}}</span>%
                                                    </div>
                                                    <div class="px-1 py-2 text-center delivery_term"
                                                         style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->created_person}}</div>
                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
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
                            <div class="tab-pane fade" id="purchase" role="tabpanel">
                                <div class="row">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <a href="{{route('original-contract-downLoadPurchasePDF',$original_contract->id)}}" class="btn bg-grey-table float-end"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="{{route('edit-original-contract',$original_contract->id)}}" class="btn bg-grey-table float-end me-2"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                    </div>
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_purchase')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span
                                                    class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span>
                                            </div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div
                                                class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            
                                            <div
                                                class="col-8 p-1 border border-top-0 customer_id_paper">{{($original_contract->Customer) ? $original_contract->Customer->name : __('message.404_not_found')}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div
                                                class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div
                                                class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div
                                                class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div
                                                class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span
                                                class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（内{{__('admin.preview_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                        <div
                                            class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1"
                                            style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center" style="width:180px;">{{__('admin.product_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:140px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex border-bottom detail_memo align-items-center"
                                                     data-id='{{$item->id}}'>
                                                    <div class="px-1 py-2 text-center product_cover"
                                                         style="width:180px;">
                                                        <!-- <div class="product_code text-grey">{{$item->product_code}}</div> -->
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <span class="product_id d-none">{{$item->product_id}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color"
                                                         style="width:33px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number"
                                                         style="width:33px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard"
                                                         style="width:33px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity"
                                                         style="width:33px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit"
                                                         style="width:33px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate"
                                                         style="width:50px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price"
                                                         style="width:90px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment"
                                                         style="width:33px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:33px"><span
                                                            class="tax">{{$item->tax}}</span>%
                                                    </div>
                                                    <div class="px-1 py-2 text-center delivery_term"
                                                         style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <!-- <div class="d-none product_code">{{$item->product_code}}</div> -->
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->created_person}}</div>
                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
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
                            <div class="tab-pane fade" id="copy" role="tabpanel">
                                <div class="row">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <a href="{{route('original-contract-downLoadCopyPDF',$original_contract->id)}}" class="btn bg-grey-table float-end"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="{{route('edit-original-contract',$original_contract->id)}}" class="btn bg-grey-table float-end me-2"><i class="bi bi-pencil-square me-1"></i>編集</a>
                                    </div>
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_copy')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span
                                                    class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span>
                                            </div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div
                                                class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            
                                            <div
                                                class="col-8 p-1 border border-top-0 customer_id_paper">{{($original_contract->Customer) ? $original_contract->Customer->name : __('message.404_not_found')}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div
                                                class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div
                                                class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div
                                                class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div
                                                class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div
                                                class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span
                                                class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                        <div
                                            class="fw-bold justify-content-center d-flex font-small font-strong header-table border-bottom border-top py-1"
                                            style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center text-wrap" style="width:120px;">
                                                {{__('admin.product_name')}}
                                            </div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_purchage')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div
                                                    class="d-flex justify-content-center align-items-center border-bottom detail_memo"
                                                    data-id="{{$item->id}}">
                                                    <div class="px-1 py-2 text-center text-wrap product_cover"
                                                         style="width:120px;">
                                                        <!-- <div class="product_code text-grey">{{$item->product_code}}</div> -->
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <span class="product_id d-none">{{$item->product_id}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color"
                                                         style="width:29px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number"
                                                         style="width:29px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard"
                                                         style="width:29px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity"
                                                         style="width:29px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit"
                                                         style="width:29px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center buy_in_discount_rate"
                                                         style="width:29px">{{number_format($item->buy_in_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center buy_price"
                                                         style="width:50px">{{number_format($item->buy_price)}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate"
                                                         style="width:29px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price"
                                                         style="width:50px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment"
                                                         style="width:29px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:29px"><span
                                                            class="tax">{{$item->tax}}</span>%
                                                    </div>
                                                    <div class="px-1 py-2 text-center delivery_term"
                                                         style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <div class="trade_size_1 d-none">{{$item->trade_size_1}}</div>
                                                    <div class="trade_size_2 d-none">{{$item->trade_size_2}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end">{{$original_contract->created_person}}</div>
                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/edit-memo-original-contract.js"></script>
    <script>
        $(document).ready(function() {
            id = {!! $original_contract->id !!}
            getOriginalTotal()
            $('.btn-preview').click(function(){
            data = getDataMemoContractPreview();
            //var win = window.open('/original_contract/preview?'+$.param(data), '_blank');
            var win = window.open('/original_contract/preview?is_detail='+id, '_blank');
            if (win) {
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        })
        function getDataMemoContractPreview(){
            data_contract = {
                is_detail : id ,
                order_number : $('.form-all input.order_number').val(),
                order_date : $('.form-all input.order_date').val(),
                place_of_import : $('.form-all input.place_of_import').val(),
                created_date : $('.form-all input.created_date').val(),
                slip_number : $('.form-all input.slit_number').val(),
                person_in_charge : $('.form-all input.person_in_charge').val(),
                order_code : $('.form-all input.order_code').val(),
                supplier_id : $('.form-all .supplier').data('id'),
                customer_id : $('.form-all .customer').data('id'),
                delivery_destination : $('.form-all input.delivery_destination').val(),
                delivery_phone_number : $('.form-all input.delivery_phone_number').val(),
                delivery_address : $('.form-all input.delivery_address').val(),
                serial_number: $('.form-all input.serial_number').val(),
                created_person: $('.form-all input.created_person').val(),
                note : $('.form-all .note').text(),
                status : $('.status').val(),
                item_contract : [],
            }
            $('#copy .detail_memo').each(function( index ){
                element = {
                    product_code : $(this).find('.product_code').text(),
                    product_name: $(this).find('.product_name').text(),
                    
                    color: $(this).find('.color').text(),
                    reciprocal_number: $(this).find('.reciprocal_number').text(),
                    standard: $(this).find('.standard').text(),
                    quantity: $(this).find('.quantity').text().replace(/,/g, ''),
                    unit: $(this).find('.unit').text(),

                    buy_in_discount_rate: $(this).find('.buy_in_discount_rate').text().replace(/,/g, ''),
                    buy_price: $(this).find('.buy_price').text().replace(/,/g, ''),
                    sales_discount_rate: $(this).find('.sales_discount_rate').text(),
                    price: $(this).find('.price').text().replace(/,/g, ''),

                    tax: $(this).find('.tax').text(),
                    delivery_term: $(this).find('.delivery_term').text(),
                    consignment: $(this).find('.consignment').text().replace(/,/g, ''),
                    note : $(this).find('.description_paper').text(),
                    trade_size_1 : $(this).find('.trade_size_1').text(),
                    trade_size_2 : $(this).find('.trade_size_2').text(),
                }
                data_contract.item_contract.push(element);
            })
            return data_contract;
        }
        });
    </script>
@endsection



