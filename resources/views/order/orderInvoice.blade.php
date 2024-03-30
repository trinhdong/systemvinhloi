<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
    <style>
        body, h1, h2, p, table {
            margin: 0;
            padding: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            grid-column: span 2;
            text-align: center;
        }

        .customer-info,
        .order-details,
        .total,
        .print-button {
            background-color: #f2f2f2;
            padding: 20px;
        }

        .print-button {
            text-align: center;
        }

        table {
            width: 100%;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<div id="printableArea" class="d-none">
    <div class="container">
        <div class="header">
            <h1>Thông tin đơn hàng</h1>
        </div>
        <div class="customer-info">
            <h2>Thông tin khách hàng</h2>
            <p><strong>Tên:</strong> John Doe</p>
            <p><strong>Địa chỉ:</strong> 123 ABC Street, City</p>
            <p><strong>Email:</strong> john@example.com</p>
        </div>
        <div class="order-details">
            <h2>Chi tiết đơn hàng</h2>
            <table>
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Product A</td>
                    <td>2</td>
                    <td>$20.00</td>
                </tr>
                <tr>
                    <td>Product B</td>
                    <td>1</td>
                    <td>$15.00</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="total">
            <p><strong>Tổng cộng:</strong> $55.00</p>
        </div>
    </div>
</div>
</body>
</html>
