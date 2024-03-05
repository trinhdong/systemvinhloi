/*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
*/
var lang_ja = {
    'preview_items': '内訳',
    'preview_percent_tax': '%対象',

    'product_name_require': '商品名を入力してください。' ,
    'quantity_require': '数量を入力してください。' ,
    'tax_require': '税率を入力してください。' ,
    'sales_discount_rate_require': '掛率を入力してください。' ,
    'consignment_require': '上代を入力してください。' ,

    'supplier_contract_order_number_require' : '注文番号入力してください。',
    'order_date_require' : '発注日入力してください。',
    'place_of_import_require' : '入荷場所入力してください。',
    'created_date_require' : '作成日入力してください。',
    'slip_number_require' : '伝票区分入力してください。',
    'supplier_id_require' : '仕入先入力してください。',
    'customer_id_require' : '得意先入力してください。',
    'delivery_destination_require' : '納品先入力してください。',
    'max_255_character' : '備考に 255 文字を超えて入力されています。 備考欄に255文字以内で入力してください。',
};

function noticationToast(mess){
    Lobibox.notify('error', {
        title: 'エラー',
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        icon: 'bx bx-x-circle',
        msg: mess,
    });
}
