<div class="table-responsive mt-3">
    <div class="col-12">
        <strong>Thêm sản phẩm khuyến mãi</strong>
    </div>
    <table class="table align-middle">
        <thead class="table-secondary">
        <tr>
            <th>Sản phẩm</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($products as $productId => $productName)
                    <td>{{ $productName }}</td>
                @endforeach
            </tr>

        </tbody>
    </table>
</div>