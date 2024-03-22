<div class="table-responsive mt-3">
    <div class="col-12">
        <label>Thêm sản phẩm khuyến mãi</strong>
    </div>
    <table class="table align-middle table-bordered mt-2">
        <thead class="table-light">
        <tr>
            <th style="width: 50px">
                <button type="button" class="btn btn-sm btn-outline-primary border-0 btn-clone-row"
                        title="Thêm">
                    <div class="font-13" style="margin-right: 5px;">
                        <i class="lni lni-plus"></i>
                    </div>
                </button>
            </th>
            <th class="col-3">Danh mục</th>
            <th class="col-3">Sản phẩm</th>
            <th>Chiết khấu</th>
            <th>Giá</th>
            <th>Giá sau chiết khấu</th>
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
                <select class="form-select category">
                    <option selected="" disabled="" value="">Chọn...</option>
                    @foreach($categories as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_id[]" class="form-select product">
                    <option selected="" disabled="" value="">Chọn...</option>
                </select>
            </td>
            <td>
                <div class="input-group has-validation">
                    <input name="discount_percent[]" type="text" class="form-control discountPercent"
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
        @foreach($discounts as $discount)
            <tr class="discount-row" id="discount{{$discount->id}}">
                <td>
                    <a href="javascript:;" id="deleteDiscountModalBtn" class="btn btn-sm btn-outline-danger border-0"
                       title="Xóa"
                       data-bs-toggle="modal"
                       data-bs-target="#deleteDiscountModal"
                       data-discount-id="{{$discount->id}}">
                        <div class="font-13" style="margin-right: 5px;">
                            <i class="lni lni-close"></i>
                        </div>
                    </a>
                </td>
                <td>
                    {{$categories[$categoryIds[$discount->product_id]] ?? ''}}
                </td>
                <td>
                    <input type="hidden" name="product_id[]" value="{{$discount->product_id}}">
                    {{$products[$discount->product_id]}}
                </td>
                <td>
                    <div class="input-group has-validation">
                        <input name="discount_percent[]"
                               value="{{number_format(floatval($discount->discount_percent))}}" type="text"
                               class="form-control discountPercent" required=""
                               placeholder="000.00" autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>
                </td>
                <td class="price">
                    {{number_format($productPrice[$discount->product_id] ?? 0)}}
                </td>
                <td class="priceDiscount">
                    {{number_format(max($productPrice[$discount->product_id] - ($productPrice[$discount->product_id] * $discount->discount_percent) / 100, 0))}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="deleteDiscountModal" tabindex="-1" aria-labelledby="deleteDiscountModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDiscountModalLabel">Xóa khuyến mãi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Bạn có chắc muốn xóa khuyến mãi này?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button id="deleteDiscount" type="button" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>
