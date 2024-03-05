<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: aozoraminchomedium;
        }
        .container {
            margin: 0 auto;
            width: 100%;
            height: 1000px;
        }
        @page {
            size: a4;
            margin: 20px;
        }
        table {
            width: 100%;
        }
        th, td {
            /* text-align: center; */
        }
        .info-pdf {
            height: max-content;
            box-sizing: border-box;
        }
        .info-pdf-left {
            float: left;
            height: max-content;
            width: 50%;
            padding: 10px;
            box-sizing: border-box;
        }
        .info-pdf-right {
            float: right;
            padding: 10px;
            height: max-content;
            width: 47%;
            box-sizing: border-box;
            line-height: 20px;
        }
        .w30 {
            width: 30%;
        }
        .text-center{
            text-align: center;
        }
        .title {
            text-align: center;
            margin-top: 20px;
            font-size: 40px;
        }
        p {
            margin: 0px 0px 30px 0px;
        }
        small {
            font-size: 10px;
        }
        .title-table {
            margin-left: 10px;
        }
        .w-10 {
            width: 10%;
        }
        .align-left {
            text-align: left;
            padding-left: 10px;
        }
        .p-l-30{
            padding-left: 30px;
        }
        .m-p-0 {
            margin: 0px;
            padding: 0px;
        }
        .total-money {
            width: 35%;
            float: right;
            border-collapse: collapse;
            margin-right: 20px;
        }
        .total-money tr {
            border-bottom: 1px solid gray;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <p class="title">{{$data['name']}}</p>
        </div>
        <div class="info-pdf">
            <div class="info-pdf-left">
                <p>木更津市長　渡辺　芳邦　様</p>
                <table>
                    <tr>
                        <td class="w30">工事名</td>
                        <td>〇〇修繕工事</td>
                    </tr>
                    <tr>
                        <td class="w30">工事場所</td>
                        <td>千葉県木更津市〇〇</td>
                    </tr>
                    <tr>
                        <td class="w30">工事期間</td>
                        <td>2022/11/01　〜　2022/12/31</td>
                    </tr>
                    <tr>
                        <td class="w30">支払条件</td>
                        <td>従来通り</td>
                    </tr>
                    <tr>
                        <td class="w30">有効期限</td>
                        <td>30日</td>
                    </tr>
                </table>
            </div>
            <div class="info-pdf-right">
                <div>請求書No</div>
                <div style="margin-bottom: 20px;">発行日　令和 4年 4 月 4日</div>
                <div>南総電機株式会社</div>
                <div>代表取締役　近藤　雄文</div>
                <div>292-0801　千葉県木更津市請西1-10-28</div>
                <div>電話 0438-37-0031  FAX 0438-37-0033</div>
                <div>HP  :  https://www.nanso-denki.com</div>
            </div>
        </div>
        <div>
            <p class="title-table">ご請求金額　　33,000円 <small>（内消費税 3,000円）</small> </p>
            <hr style="margin-top:-15px; width:95%;">
            <table>
                <tbody>
                    <tr>
                        <td class="align-left">名称</td>
                        <td>規格</td>
                        <td class="w-10">数量</td>
                        <td class="w-10">単位</td>
                        <td class="w-10">単価</td>
                        <td class="w-10">金額</td>
                    </tr>
                    <tr>
                        <td class="align-left">調査</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">10,000</td>
                        <td class="w-10">10,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査1</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査2 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査3 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査4 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査5 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査6 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left p-l-30">モーター調査7 <p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p><p class="m-p-0"><small>(ここに備考テキストが入ります。ここに備考テキストが入ります。)</small></p></td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">5,000</td>
                        <td class="w-10">5,000</td>
                    </tr>
                    <tr>
                        <td class="align-left">調査</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">10,000</td>
                        <td class="w-10">10,000</td>
                    </tr>
                    <tr>
                        <td class="align-left">調査</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">10,000</td>
                        <td class="w-10">10,000</td>
                    </tr>
                    <tr>
                        <td class="align-left">調査</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">10,000</td>
                        <td class="w-10">10,000</td>
                    </tr>
                    <tr>
                        <td class="align-left">調査</td>
                        <td></td>
                        <td class="w-10">1</td>
                        <td class="w-10">式</td>
                        <td class="w-10">10,000</td>
                        <td class="w-10">10,000</td>
                    </tr>
                </tbody>
            </table>
            <hr style="margin-top:15px; width:95%; border-width: thin;">
        </div>
        <div>
            <table class="total-money">
                <tbody>
                    <tr>
                        <td>小計</td>
                        <td>30,000　円</td>
                    </tr>
                    <tr>
                        <td>消費税</td>
                        <td>3,000　円</td>
                    </tr>
                    <tr>
                        <td>合計</td>
                        <td>33,000　円</td>
                    </tr>
                    <tr>
                        <td>内訳　　10%対象</td>
                        <td>30,000　円</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>3,000　円</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
