$(document).ready(function () {
    //select2
    $('#supplier_id').select2({
        theme: 'bootstrap4',
    });
    $('#customer_id').select2({
        theme: 'bootstrap4',
    });
    $('.person_in_charge').select2({
        theme: 'bootstrap4',
    });

    $('.order_date').bootstrapMaterialDatePicker({
        time: false,
        format: 'YYYY/MM/DD',
        cancelText: "戻る",
        okText: "選択",
        lang: "ja",
    });
    $('.order_date').on('dateSelected', function(e, date) {
        id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
    });

    $('.created_date').bootstrapMaterialDatePicker({
        time: false,
        format: 'YYYY/MM/DD',
        cancelText: "戻る",
        okText: "選択",
        lang: "ja",
    });
    $('.created_date').on('dateSelected', function(e, date) {
        id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
    });
    //handle button left right page memo
    $(".btn-close-col-left").click(function () {
        $(".col-left").toggle(100, "linear", function () {
            if ($(".col-left").is(":visible")) {
                $(".btn-close-col-left h5").html('プレビュー拡大<i class="fas fa-angle-double-left" style="margin-left: 8px"></i>').css({
                    "font-size": "20px",
                    "color": "black",
                    "position": "relative",
                    "left": "0px"
                }).hover(function () {
                    $(this).css("color", "rgb(121, 121, 121)");
                }, function () {
                    $(this).css("color", "black");
                });
            } else {
                $(".btn-close-col-left h5").html(' プレビュー拡大<i class="fas fa-angle-double-right" style="margin-left: 8px"></i>').css({
                    "font-size": "20px",
                    "color": "black",
                    "position": "relative",
                    "left": "10px"
                }).hover(function () {
                    $(this).css("color", "rgb(121, 121, 121)");
                }, function () {
                    $(this).css("color", "black");
                });
            }
        });
    });

    $('.delivery_term_1').bootstrapMaterialDatePicker({
        time: false,
        format: 'YYYY/MM/DD',
        cancelText: "戻る",
        okText: "選択",
        lang: "ja",
    });
    $('.delivery_term_1').on('dateSelected', function(e, date) {
        id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
    });
    //event
    $('.order_code').keyup(function () {
        $('.order_code_paper').text($(this).val());
    });

    $('.created_date').on('change', function () {
        created_date = $(this).val()
        $('.created_date_paper').text(created_date)
    });

    $('.order_date').on('change', function () {
        order_date = $(this).val()
        $('.order_date_paper').text(order_date)
    });

    $('.place_of_import').keyup(function () {
        $('.place_of_import_paper').text($(this).val());
    })
    $(".slip_number").on("input", function () {
        const slip_number = $(this).val();
        $('.slip_number_paper').text(slip_number);
    })

    $(document).on('change','select[name=person_in_charge]',function() {
        $('.person_in_charge_paper').text($('select[name=person_in_charge] option:selected').text())
    })

    $(document).on('change', 'select[name=supplier_id]', function () {
        $('.supplier_id_paper').text($('select[name=supplier_id] option:selected').text())
    });

    $(document).on('change', 'select[name=customer_id]', function () {
        $('.customer_id_paper').text($('select[name=customer_id] option:selected').text())
    });

    $('.delivery_destination').keyup(function () {
        $('.delivery_destination_paper').text($(this).val());
    });

    $('.delivery_phone_number').keyup(function () {
        $('.delivery_phone_number_paper').text($(this).val());
    });

    $('.delivery_address').keyup(function () {
        $('.delivery_address_paper').text($(this).val());
    });

    $('.serial_number').keyup(function () {
        $('.serial_number_paper').text($(this).val());
    });

    $('.created_person').keyup(function () {
        $('.created_person_paper').text($(this).val());
    });

    $('.note').keyup(function () {
        $('.note_paper').text($(this).val());
    });

    $('.add-line').click(function () {
        id = $('.form-memo:last-child').data('id');
        _html = getHTMLInputContract(id);
        $('.form-input-original-contract').append(_html);
    });

    $(document).on('click', '.delete-line', function () {
        $(this).parent().parent().remove();
        id = $(this).parent().parent().attr('data-id');
        $('.detail_memo[data-id=' + id + ']').remove();
        getOriginalTotal()
    });

    // open modal description detail
    if($('#descriptionModal').length > 0){
        var descriptionModal = new bootstrap.Modal($('#descriptionModal'), {});
        $(document).on('click', '.btn-modal-description', function () {
            id = $(this).parent().parent().attr('data-id')
            $('.save-change-desc').attr('data-id', id)
            $('.description').val('');
            description = "";
            if ($('.detail_memo[data-id=' + id + '] .product_cover .description_paper').length > 0) {
                description = $('#quotation .detail_memo[data-id=' + id + '] .product_cover .description_paper').text();
            }
            $('.description').val(description)
            descriptionModal.show();
        });
    }

    $('.save-change-desc').click(function () {
        description = $('.description').val();
        id = $(this).attr('data-id');
        count_desc = description.length; 
        if(count_desc >= 254){
            Lobibox.notify('error', {
                title: 'エラー',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: lang_ja['max_255_character'],
            });
            
            return false;
        }
        updateLineNotValidate();
        $('.detail_memo[data-id=' + id + '] .product_cover .description_paper').remove();
        $('.detail_memo[data-id=' + id + '] .product_cover').append('<div class="description_paper text-grey">' + description + '</div>');

        descriptionModal.hide();
    })

    //handle when click update-line
    $('.update-line').click(function () {
        updateLine()
    });
});
function updateLine(){
    _validate = true ;
    $('.form-memo').each(function (index) {
        id = $(this).data('id');
        data = {
            id: $(this).data('id'),
            product_name: $(this).find('.product_name').val(),
            product_code: $(this).find('.product_code').val(),
            color: $(this).find('.color').val(),
            reciprocal_number: $(this).find('.reciprocal_number').val(),
            standard: $(this).find('.standard').val(),
            quantity: $(this).find('.quantity').val(),
            unit: $(this).find('.unit').val(),
            buy_in_discount_rate: $(this).find('.buy_in_discount_rate').val(),
            buy_price: $(this).find('.buy_price').val(),
            sales_discount_rate: $(this).find('.sales_discount_rate').val(),
            price: $(this).find('.price').val(),
            tax: $(this).find('.tax').val(),
            consignment: $(this).find('.consignment').val(),
            delivery_term: $(this).find('.delivery_term_' + id).val(),
            trade_size_1 : $(this).find('.trade_size_1').val(),
            trade_size_2 : $(this).find('.trade_size_2').val(),
        }
        data = validateMemoContract(data)
        if (data == false) {
            _validate = false ;
            return false;
        }

        $('.detail_memo_empty').remove();

        if ($('.paper_memo').find('.detail_memo[data-id=' + data.id + ']').length > 0) {
            parent_memo = $('.paper_memo .detail_memo[data-id=' + data.id + ']');
            updatePaper2tabFirst(parent_memo, data);
            parent_memo_2 = $('.paper_memo_2 .detail_memo[data-id=' + data.id + ']');
            updatePaper2tabLast(parent_memo_2, data);
        } else {
            _html_memo_paper_2first = getHTMLMemoPaper2First(data);
            _html_memo_paper_2last = getHTMLMemoPaper2Last(data);
            $('.paper_memo').append(_html_memo_paper_2first);
            $('.paper_memo_2').append(_html_memo_paper_2last);
        }

    });
    getOriginalTotal()
    return _validate;
}

function updateLineNotValidate(){
    $('.form-memo').each(function (index) {
        id = $(this).data('id');
        data = {
            id: $(this).data('id'),
            product_name: $(this).find('.product_name').val(),
            product_code: $(this).find('.product_code').val(),
            color: $(this).find('.color').val(),
            reciprocal_number: $(this).find('.reciprocal_number').val(),
            standard: $(this).find('.standard').val(),
            quantity: $(this).find('.quantity').val(),
            unit: $(this).find('.unit').val(),
            buy_in_discount_rate: $(this).find('.buy_in_discount_rate').val(),
            buy_price: $(this).find('.buy_price').val(),
            sales_discount_rate: $(this).find('.sales_discount_rate').val(),
            price: $(this).find('.price').val(),
            tax: $(this).find('.tax').val(),
            consignment: $(this).find('.consignment').val(),
            delivery_term: $(this).find('.delivery_term_' + id).val(),
            trade_size_1 : $(this).find('.trade_size_1').val(),
            trade_size_2 : $(this).find('.trade_size_2').val(),
        }

        $('.detail_memo_empty').remove();

        if ($('.paper_memo').find('.detail_memo[data-id=' + data.id + ']').length > 0) {
            parent_memo = $('.paper_memo .detail_memo[data-id=' + data.id + ']');
            updatePaper2tabFirst(parent_memo, data);
            parent_memo_2 = $('.paper_memo_2 .detail_memo[data-id=' + data.id + ']');
            updatePaper2tabLast(parent_memo_2, data);
        } else {
            _html_memo_paper_2first = getHTMLMemoPaper2First(data);
            _html_memo_paper_2last = getHTMLMemoPaper2Last(data);
            $('.paper_memo').append(_html_memo_paper_2first);
            $('.paper_memo_2').append(_html_memo_paper_2last);
        }

    });
    getOriginalTotal()
}
//validate
function validateMemoContract(data){
    _validate = true;
    validate_parent = validateParent() ;
    if(validate_parent == false){
        _validate = false;
    }
    if( data.product_name == "" || data.quantity == "" || data.tax == "" ){
        if ( data.product_name == ""){
            Lobibox.notify('error', {
                title: 'エラー',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: lang_ja['product_name_require'],
            });
        }
        if (data.quantity == ""){
            Lobibox.notify('error', {
                title: 'エラー',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: lang_ja['quantity_require'],
            });
        }
        if(data.tax == ""){
            Lobibox.notify('error', {
                title: 'エラー',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: lang_ja['tax_require'],
            });
        }
        _validate = false;
    }else{
        if (data.price == ""){
            if(data.sales_discount_rate == "" || data.consignment == "" || data.tax == "" || data.product_name == ""){
                if(data.sales_discount_rate == ""){
                    Lobibox.notify('error', {
                        title: 'エラー',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: lang_ja['sales_discount_rate_require'],
                    });

                }
                if(data.consignment == ""){
                    Lobibox.notify('error', {
                        title: 'エラー',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: lang_ja['consignment_require'],
                    });
                }
                if(data.tax == ""){
                    Lobibox.notify('error', {
                        title: 'エラー',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: lang_ja['tax_require'],
                    });
                }
                if ( data.product_name == ""){
                    Lobibox.notify('error', {
                        title: 'エラー',
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: lang_ja['product_name_require'],
                    });
                }
                _validate = false;
            }
        }
    }
    if(_validate == false) {
        return false;
    }
    return data;
}

function getHTMLInputContract(id) {

    // html_option_product = '<option value="" disabled="disabled" selected></option>';
    // $('.item_product').each(function (index) {
    //     html_option_product += '<option class="item_product"  value="' + $(this).val() + '"  > ' + $(this).text() + '</option>'
    // });

    id++
    _html = '<div class="d-flex border-bottom form-memo" data-id=' + id + '>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:258px;;width:100%">'
    _html += '        <div class="input-group">'
    _html += '            <input type="text" class="form-control padding-input product_code" style="min-width:50px;">'
    _html += '            <input type="text" class="form-control padding-input product_name" id="product_name_'+id+'" style="min-width:200px;">'
    _html += '        </div>'
    _html += '    </div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input color" type="text"></div>'
    _html += '<div class="px-1 py-2 text-center trade-size" style="min-width:76px;width: 100%;">'
    _html += '    <button style="min-width:100%" class="btn btn-primary border trade-size-modal-btn" type="button" data-id="'+id+'">'
    _html += '        詳細'
    _html += '    </button>'
    _html += '    <div class="modal fade" id="trade-size-modal-'+id+'" tabindex="-1" aria-labelledby="trade-size-modal-'+id+'" aria-hidden="true" >'
    _html += '        <div class="modal-dialog modal-dialog-centered ">'
    _html += '            <div class="modal-content">'
    _html += '                <div class="modal-body">'
    _html += '                    <div class="row">'
    _html += '                        <div class="col-1"><label class="form-label">取引寸</label></div>'
    _html += '                        <div class="col-12">'
    _html += '                            <input type="text" class="form-control padding-input mb-2 trade_size_1" style="min-width:200px;">'
    _html += '                            <input type="text" class="form-control padding-input trade_size_2" style="min-width:200px;">'
    _html += '                        </div>'
    _html += '                    </div>'
    _html += '                </div>'
    _html += '                <div class="modal-footer">'
    _html += '                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#trade-size-modal-'+id+'">戻る</button>'
    _html += '                    <button type="button" class="btn btn-primary save-change-trade" data-bs-toggle="modal" data-bs-target="#trade-size-modal-'+id+'">作成</button>'
    _html += '                </div>'
    _html += '            </div>'
    _html += '        </div>'
    _html += '    </div>'
    _html += '</div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input reciprocal_number" type="number" min="1"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input standard" type="text"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input quantity" type="number" min="1"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input unit" type="text"></div>'

    _html += '    <div class="px-1 py-2 text-center" style="min-width:90px;width:100%"><input class="form-control padding-input buy_in_discount_rate" type="number"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:110px;width:100%"><input class="form-control padding-input buy_price" type="text"></div>'

    _html += '    <div class="px-1 py-2 text-center" style="min-width:90px;width:100%"><input class="form-control padding-input sales_discount_rate" type="text"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:110px;width:100%"><input class="form-control padding-input price" type="text"></div>'

    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input consignment" type="number"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%"><input class="form-control padding-input tax" type="number"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:110px;width:100%"><input class="form-control padding-input delivery_term_' + id + '" type="text"></div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:76px;width:100%">'
    _html += '        <a type="button" class="btn btn-modal-description" >'
    _html += '            <i class="bi bi-pencil-square"></i>'
    _html += '        </a>'
    _html += '    </div>'
    _html += '    <div class="px-1 py-2 text-center" style="min-width:66px;width:100%">'
    _html += '      <a  class="btn delete-line p-2">'
    _html += '          <i class="bi bi-trash-fill text-danger m-0"></i>'
    _html += '      </a>'
    _html += '    </div>'
    _html += '</div>'
    dateTime(id);
    select2OriginalProduct(id);
    return _html;
}

function dateTime(id) {
    $(document).ready(function () {
        $('.delivery_term_' + id).bootstrapMaterialDatePicker({
            time: false,
            format: 'YYYY/MM/DD',
            cancelText: "戻る",
            okText: "選択",
            lang: "ja",
        });
        $('.delivery_term_' + id).on('dateSelected', function(e, date) {
            id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
        });
    });
}

// function select2Product(id){
//     $(document).ready(function () {
//         $('#product_name_' + id).select2({
//             theme: 'bootstrap4',
//             ajax: {
//                 url: "/original_contract/list-original-product",
//                 delay: 1500,
//                 data: function (params) {
//                     var query = {
//                         search: params.term
//                     }
//                     // Query parameters will be ?search=[term]&type=public
//                     return query;
//                 },
//                 cache: false,
//                 processResults: function (data) {
//
//                     // Transforms the top-level key of the response object from 'items' to 'results'
//                     return {
//                         results: JSON.parse(data)
//                     };
//                 }
//             }
//         });
//     })
// }

function select2OriginalProduct(id) {
    $(document).ready(function () {
        var pageSize = 1;
        $('#product_name_' + id).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "/original_contract/list-original-product",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                $('#product_name_' + id).val(ui.item.label);
                return false;
            }
        });
    })
}

function getHTMLMemoPaper2First(data) {
    price = "";
    consignment = "";
    if(data.price != "")
    {
        price = parseFloat(data.price)
    }
    if(data.consignment != "")
    {
        consignment = parseFloat(data.consignment)
    }
    _html = '<div class="d-flex border-bottom detail_memo align-items-center" data-id=' + data.id + '>'
    _html += '<div class="px-1 py-2 text-center product_cover" style="width:180px;"><div class="product_code text-grey">' + data.product_code + '</div><span class="product_name">' + data.product_name + '</span></div>'
    _html += '<div class="px-1 py-2 text-center color" style="width:33px">' + data.color + '</div>'
    _html += '<div class="px-1 py-2 text-center reciprocal_number" style="width:33px">' + data.reciprocal_number + '</div>'
    _html += '<div class="px-1 py-2 text-center standard" style="width:33px">' + data.standard + '</div>'
    _html += '<div class="px-1 py-2 text-center quantity" style="width:33px">' + data.quantity + '</div>'
    _html += '<div class="px-1 py-2 text-center unit" style="width:33px">' + data.unit + '</div>'

    _html += '<div class="px-1 py-2 text-center sales_discount_rate" style="width:50px">' + data.sales_discount_rate + '</div>'
    _html += '<div class="px-1 py-2 text-center price" style="width:90px">'+price+'</div>'

    _html += '<div class="px-1 py-2 text-center consignment" style="width:33px">' + consignment + '</div>'
    _html += '<div class="px-1 py-2 text-center" style="width:33px"><span class="tax">' + data.tax + '</span>%</div> '
    _html += '<div class="px-1 py-2 text-center delivery_term" style="width:100px">' + data.delivery_term + '</div>'
    _html += '<div class="d-none product_code">' + data.product_code + '</div> '
    _html += '<div class="d-none trade_size_1">'+data.trade_size_1+'</div> '
    _html += '<div class="d-none trade_size_2">'+data.trade_size_2+'</div> '
    _html += '</div>'
    return _html;
}

function getHTMLMemoPaper2Last(data) {
    price = "";
    buy_price = "";
    consignment = "";
    if(data.price != "") {
        price = parseFloat(data.price)
    }
    if(data.buy_price != ""){
        buy_price = parseFloat(data.buy_price)
    }
    if(data.consignment != ""){
        consignment = parseFloat(data.consignment)
    }
    _html = '<div class="d-flex justify-content-center align-items-center border-bottom detail_memo" data-id=' + data.id + '>'
    _html += '<div class="px-1 py-2 text-center text-wrap product_cover" style="width:120px;"><div class="product_code text-grey">' + data.product_code + '</div><span class="product_name">' + data.product_name + '</span></div>'
    _html += '<div class="px-1 py-2 text-center color" style="width:29px">' + data.color + '</div>'
    _html += '<div class="px-1 py-2 text-center reciprocal_number" style="width:29px">' + data.reciprocal_number + '</div>'
    _html += '<div class="px-1 py-2 text-center standard" style="width:29px">' + data.standard + '</div>'
    _html += '<div class="px-1 py-2 text-center quantity" style="width:29px">' + data.quantity + '</div>'
    _html += '<div class="px-1 py-2 text-center unit" style="width:29px">' + data.unit + '</div>'

    _html += '<div class="px-1 py-2 text-center buy_in_discount_rate" style="width:29px">' + data.buy_in_discount_rate + '</div>'
    _html += '<div class="px-1 py-2 text-center buy_price" style="width:50px">' + buy_price + '</div>'

    _html += '<div class="px-1 py-2 text-center sales_discount_rate" style="width:29px">' + data.sales_discount_rate + '</div>'
    _html += '<div class="px-1 py-2 text-center price" style="width:50px">' + price + '</div>'

    _html += '<div class="px-1 py-2 text-center consignment" style="width:29px">' + consignment + '</div>'
    _html += '<div class="px-1 py-2 text-center" style="width:29px"><span class="tax">' + data.tax + '</span>%</div>'
    _html += '<div class="px-1 py-2 text-center delivery_term" style="width:90px">' + data.delivery_term + '</div>'
    _html += '<div class="d-none trade_size_1">'+data.trade_size_1+'</div> '
    _html += '<div class="d-none trade_size_2">'+data.trade_size_2+'</div> '
    _html += '</div>'
    return _html;
}

function updatePaper2tabFirst(parent_memo, data) {
    price = "" ;
    consignment = "" ;
    if(data.price != ""){
        price = parseFloat(data.price)
    }
    if(data.consignment != ""){
        consignment = parseFloat(data.consignment)
    }
    parent_memo.find('.product_code').text(data.product_code)
    parent_memo.find('.product_name').text(data.product_name)
    parent_memo.find('.color').text(data.color)
    parent_memo.find('.reciprocal_number').text(data.reciprocal_number)
    parent_memo.find('.standard').text(data.standard)
    parent_memo.find('.quantity').text(data.quantity)
    parent_memo.find('.unit').text(data.unit)
    parent_memo.find('.sales_discount_rate').text(data.sales_discount_rate)
    parent_memo.find('.price').text(price)
    parent_memo.find('.tax').text(data.tax)
    parent_memo.find('.delivery_term').text(data.delivery_term)
    parent_memo.find('.consignment').text(consignment)
    parent_memo.find('.trade_size_1').text(data.trade_size_1)
    parent_memo.find('.trade_size_2').text(data.trade_size_2)
    
}

function updatePaper2tabLast(parent_memo, data) {
    price = "" ;
    buy_price = "";
    consignment = "";
    if(data.price != ""){
        price = parseFloat(data.price)
    }
    if(data.buy_price != ""){
        buy_price = parseFloat(data.buy_price)
    }
    if(data.consignment != ""){
        consignment = parseFloat(data.consignment)
    }
    parent_memo.find('.product_code').text(data.product_code)
    parent_memo.find('.product_name').text(data.product_name)
    parent_memo.find('.color').text(data.color)
    parent_memo.find('.reciprocal_number').text(data.reciprocal_number)
    parent_memo.find('.standard').text(data.standard)
    parent_memo.find('.quantity').text(data.quantity)
    parent_memo.find('.unit').text(data.unit)

    parent_memo.find('.buy_in_discount_rate').text(data.buy_in_discount_rate)
    parent_memo.find('.buy_price').text(buy_price)
    parent_memo.find('.sales_discount_rate').text(data.sales_discount_rate)
    parent_memo.find('.price').text(price)

    parent_memo.find('.tax').text(data.tax)
    parent_memo.find('.delivery_term').text(data.delivery_term)
    parent_memo.find('.consignment').text(consignment)
    parent_memo.find('.trade_size_1').text(data.trade_size_1)
    parent_memo.find('.trade_size_2').text(data.trade_size_2)
}

function getOriginalTotal() {
    total_tax = 0;
    tax = 0;
    total = 0;
    tax_array = {};
    $('#copy .paper_memo_2 .detail_memo').each(function (index) {
        consignment = parseInt($(this).find('.consignment').text().replace(/,/g, ''))
        quantity = parseInt($(this).find('.quantity').text().replace(/,/g, ''))
        sales_discount_rate = parseFloat($(this).find('.sales_discount_rate').text().replace(/,/g, ''))
        price = parseInt($(this).find('.price').text().replace(/,/g, ''))
        tax = parseInt($(this).find('.tax').text().replace(/,/g, ''))

        total_price = 0;
        if (price) {
            total_tax += (quantity * price * tax / 100) + (quantity * price);
            total_price = (quantity * price);
            total += total_price
        } else {
            total_price = (quantity * sales_discount_rate * consignment/ 100)  + (quantity * sales_discount_rate)
            total += total_price
            //total_tax += (quantity * sales_discount_rate * consignment * tax / 100) + (quantity * sales_discount_rate * consignment);
            total_tax += (total_price * tax / 100) + (total_price);
        }
        if (!tax_array[tax]) {
            tax_array[tax] = 0;
        }
        tax_array[tax] += total_price;
    });

    $('.mask-total .total_tax').text(total_tax.toLocaleString('ja-JP'));
    $('.mask-total .total').text(total.toLocaleString('ja-JP'));
    tax = total_tax - total;
    $('.mask-total .tax').text(tax.toLocaleString('ja-JP'))

    html = "";
    title = 1;
    $.each(tax_array, function(tax, total_price ) {
        title_preview_items = '<span style="margin: 17px"></span>';
        if (title == 1){
            title_preview_items = lang_ja['preview_items'];
        }
        title++;
        html+= '<div class="row">'
        html+= '<div class="col-6 text-grey">'+title_preview_items+' <span class="percent_tax">'+tax+'</span>'+lang_ja['preview_percent_tax']+' </div>'
        html+= '<div class="col-6 text-end text-grey"><span class="total">'+total_price.toLocaleString('ja-JP')+'</span>  円</div>'
        html+= '<div class="col-6"></div>'
        tax_money = tax * total_price /100
        html+= '<div class="col-6 text-end text-grey"><span class="tax">'+tax_money.toLocaleString('ja-JP')+'</span>  円</div>'
        html+= '</div>'
    });
    $('.tax_percent').empty();
    $('.tax_percent').append(html);
}

function getDataMemoOriginalContract() {
    data_original_contract = {
        order_number: $('.form-all input.order_number').val(),
        order_date: $('.form-all input.order_date').val(),
        place_of_import: $('.form-all select.place_of_import option:selected').text(),
        created_date: $('.form-all input.created_date').val(),
        slip_number: $('.form-all input.slip_number').val(),
        person_in_charge: $('.form-all select.person_in_charge').val(),
        order_code: $('.form-all input.order_code').val(),
        supplier_id: $('.form-all select.supplier_id').val(),
        customer_id: $('.form-all select.customer_id').val(),
        delivery_destination: $('.form-all input.delivery_destination').val(),
        delivery_phone_number: $('.form-all input.delivery_phone_number').val(),
        delivery_address : $('.form-all select.delivery_address option:selected').text(),
        serial_number: $('.form-all input.serial_number').val(),
        created_person: $('.form-all input.created_person').val(),
        note: $('.form-all textarea.note').val(),
        status: $('.status').val(),
    }
    return data_original_contract;
}

function getDataMemoOriginalContractDetail() {
    data_original_contract_detail = [];
    $('#copy .detail_memo').each(function (index) {
        element = {
            product_code: $(this).find('.product_code').text(),
            product_name: $(this).find('.product_name').text(),
            color: $(this).find('.color').text(),
            reciprocal_number: $(this).find('.reciprocal_number').text(),
            standard: $(this).find('.standard').text(),
            quantity: $(this).find('.quantity').text().replace(/,/g, ''),
            unit: $(this).find('.unit').text(),

            buy_in_discount_rate: $(this).find('.buy_in_discount_rate').text().replace(/,/g, ''),
            buy_price: $(this).find('.buy_price').text().replace(/,/g, ''),
            sales_discount_rate: $(this).find('.sales_discount_rate').text().replace(/,/g, ''),
            price: $(this).find('.price').text().replace(/,/g, ''),

            tax: $(this).find('.tax').text(),
            delivery_term: $(this).find('.delivery_term').text(),
            consignment: $(this).find('.consignment').text().replace(/,/g, ''),
            note: $(this).find('.description_paper').text(),
            trade_size_1 : $(this).find('.trade_size_1').text(),
            trade_size_2 : $(this).find('.trade_size_2').text(),
        }
        data_original_contract_detail.push(element);
    })
    return data_original_contract_detail;
}
function validateParent(){
    validate = true ;
    if($('.form-all .order_number').val() == ""){
        noticationToast(lang_ja['supplier_contract_order_number_require']);
        validate = false ;
    }
    if($('.form-all .order_date').val() == ""){
        noticationToast(lang_ja['order_date_require']);
        validate = false ;
    }
    if($('.form-all select.place_of_import option:selected').val() == ""){
        noticationToast(lang_ja['place_of_import_require']);
        validate = false ;
    }
    if($('.form-all .created_date').val() == ""){
        noticationToast(lang_ja['created_date_require']);
        validate = false ;
    }
    if($('.form-all .slip_number').val() == ""){
        noticationToast(lang_ja['slip_number_require']);
        validate = false ;
    }
    if($('.form-all .supplier_id').val() == null){
        noticationToast(lang_ja['supplier_id_require']);
        validate = false ;
    }
    if($('.form-all .customer_id').val() == null){
        noticationToast(lang_ja['customer_id_require']);
        validate = false ;
    }
    if($('.form-all .delivery_destination').val() == ""){
        noticationToast(lang_ja['delivery_destination_require']);
        validate = false ;
    }
    return validate;
}
