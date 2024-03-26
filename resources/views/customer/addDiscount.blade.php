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

        </tbody>
    </table>
</div>
