<div class="modal fade" id="addProductToOrderModal" tabindex="-1" aria-labelledby="addProductToOrderModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductToOrderModalLabel">Thêm sản phẩm vào đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header py-3 col-12">
                        <div class="row col-6 align-items-center" style="float: right">
                            <div class="col-6">
                                <select id="category" class="form-select">
                                    <option selected="" value="">Chọn danh mục</option>
                                    @foreach($categories as $categoryId => $categoryName)
                                        <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="ms-auto position-relative">
                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                class="bi bi-search"></i></div>
                                    <input id="searchProduct" class="form-control ps-5" type="text"
                                           placeholder="Tìm kiếm sản phẩm...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border shadow-none radius-10">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                </tr>
                                                </thead>
                                                <tbody id="productList">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="paginateCustom">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
