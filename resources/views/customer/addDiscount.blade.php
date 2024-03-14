<div class="table-responsive mt-3">
    <div class="col-12">
        <strong>Thêm sản phẩm khuyến mãi</strong>
    </div>
    <table class="table align-middle table-bordered">
        <thead class="table-light">
        <tr>
            <th style="width: 50px">
                <button type="button" class="btn btn-sm btn-outline-primary border-0 add-record btn-clone-row"
                        title="Thêm">
                    <div class="font-13" style="margin-right: 5px;">
                        <i class="lni lni-plus"></i>
                    </div>
                </button>
            </th>
            <th class="col-3">Danh mục</th>
            <th class="col-3">Sản phẩm</th>
            <th>Phần trăm giảm giá</th>
            <th>Giá</th>
            <th>Giá khuyến mãi</th>
        </tr>
        </thead>
        <tbody>
        <tr class="discount-row">
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-remove-row" title="Xóa">
                    <div class="font-13" style="margin-right: 5px;">
                        <i class="lni lni-close"></i>
                    </div>
                </button>
            </td>
            <td>
                <select class="form-select category" required="">
                    <option selected="" disabled="" value="">Chọn...</option>
                    @foreach($categories as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_id[]" class="form-select product" required="">
                    <option selected="" disabled="" value="">Chọn...</option>
                </select>
            </td>
            <td>
                <div class="input-group has-validation">
                    <input name="discount_percent[]" type="text" class="form-control discountPercent" required=""
                           placeholder="000.00" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </td>
            <td class="price">
                0
            </td>
            <td class="priceDiscount">
                0
            </td>
        </tr>

        </tbody>
    </table>
</div>
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('change', '.category', function (event) {
                event.preventDefault();

                const categoryId = $(this).val();
                const $product = $(this).closest('tr').find('.product');
                const productIdNotIn = getAllSelectedProduct();
                $(this).closest('tr').find('.price').text('0');
                $(this).closest('tr').find('.priceDiscount').text('0');
                $('.product').each(function () {
                    if (!($(this).find('option:selected'))) {

                    }
                });

                $product.empty().append($('<option selected disabled>').text('Chọn...'));
                $.ajax({
                    url: '{{ route("product.getByCategoryId") }}',
                    type: 'GET',
                    data: {categoryId: categoryId, productIdNotIn: productIdNotIn},
                    success: function (products) {
                        $.each(products, function (index, product) {
                            $product.append($(`<option data-price="${product.price}"></option>`).val(product.id).text(product.product_name));
                        });
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
            $(document).on('change', '.product', function (event) {
                const productSelectedOption = $(this).find('option:selected');
                const price = productSelectedOption.data('price');
                if (!isNaN(price)) {
                    const formattedPrice = new Intl.NumberFormat().format(price);
                    const $price = $(this).closest('tr').find('.price');
                    const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
                    const $discountPercent = $(this).closest('tr').find('.discountPercent');
                    const discountPercent = parseFloat($discountPercent.val());
                    if (!isNaN(discountPercent)) {
                        $priceDiscount.text(new Intl.NumberFormat().format(price - (discountPercent * price) / 100))
                    } else {
                        $priceDiscount.text(formattedPrice);
                    }
                    $price.text(formattedPrice);
                }
                $('.category').trigger('change');
            });
            $(document).on('keyup', '.discountPercent', function (event) {
                let discountPercent = $(this).val();
                if (isNaN($(this).val()) || [".."].includes(event.key)) {
                    $(this).val('');
                    return false;
                }
                let number = ($(this).val().split('.'));
                let intPart = number[0];
                let decPart = number[1];

                if (intPart !== undefined && intPart.length > 3) {
                    $(this).val('');
                    return false;
                }
                discountPercent = parseFloat($(this).val());
                if (discountPercent <= 0) {
                    $(this).val('');
                }
                if (decPart !== undefined && decPart.length > 2) {
                    $(this).val(discountPercent.toFixed(2));
                }
            });
            $(document).on('blur', '.discountPercent', function (event) {
                const $price = $(this).closest('tr').find('.price');
                const $priceDiscount = $(this).closest('tr').find('.priceDiscount');
                const price = parseFloat($price.text().replace(/,/g, ''));
                const discountPercent = parseFloat($(this).val());
                if (isNaN(discountPercent)) {
                    $priceDiscount.text('0');
                    return false;
                }
                $priceDiscount.text(new Intl.NumberFormat().format(price - (discountPercent * price) / 100))
            });

            $(document).on('click', '.btn-clone-row', function () {
                const newRow = $('.discount-row').first().clone();
                newRow.find('input[type="text"]').val('');
                newRow.insertAfter($('.discount-row').first());
            });

            $(document).on('click', '.btn-remove-row', function () {
                if ($('.discount-row').length == 1) {
                    $(this).closest('tr').find('input[type="text"], select').val('');
                    $(this).closest('tr').find('.price, .priceDiscount').text('0');
                    $(this).closest('tr').find('.category').trigger('change');
                    return false;
                }
                const $productOptionSelected = $(this).closest('tr').find('.product option:selected').first().clone();
                $(this).closest('.discount-row').remove();
                $('.product').each(function () {
                    $productOptionSelected.insertAfter($(this).eq(1));
                });
            });

            function getAllSelectedProduct() {
                return $('.product option:selected')
                    .filter((index, option) => option.value != '' && option.value != '0')
                    .map((index, option) => option.value)
                    .get();
            }
        });
    </script>
@endsection
