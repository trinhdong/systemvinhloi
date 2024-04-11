<div class="table-responsive mt-3">
    <div class="col-12 position-relative">
        Thêm sản phẩm khuyến mãi
        <div class="col-8">
            <div class="col-12 position-relative">
                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                <input id="search_product" class="form-control ps-5 rounded" type="text" placeholder="Nhập sản phẩm">
            </div>
        </div>
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
            <th class="col-2">Danh mục</th>
            <th class="col-2">Sản phẩm</th>
            <th>Giá</th>
            <th>Chiết khấu (%)</th>
            <th>Số tiền chiết khấu</th>
            <th>Giá sau chiết khấu</th>
            <th class="col-2">Ghi chú</th>
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
                    <option selected="" disabled="" value="">Chọn</option>
                    @foreach($categories as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_id[]" class="form-select product">
                    <option selected="" disabled="" value="">Chọn</option>
                </select>
            </td>
            <td class="price">
                0
            </td>
            <td>
                <div class="input-group has-validation">
                    <input name="discount_percent[]" type="text" class="form-control discountPercent"
                           placeholder="0.000" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </td>
            <td>
                <div class="input-group has-validation">
                    <input name="discount_price[]" type="text" class="form-control discountPrice"
                           placeholder="0" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </td>
            <td class="priceDiscount">
                0
            </td>
            <td>
                <textarea name="note[]" cols="1" rows="1" class="form-control" placeholder="Nhập ghi chú"></textarea>
            </td>
        </tr>

        </tbody>
    </table>
</div>
