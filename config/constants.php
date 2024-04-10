<?php
const FORMAT_DATE = 'Y-m-d';
const FORMAT_DATE_TIME = 'Y-m-d H:i:s';
const FORMAT_DATE_VN = 'd/m/Y';
const FORMAT_DATE_TIME_VN = 'd/m/Y H:i:s';

const SUPER_ADMIN = 0;
const ADMIN = 1;
const SALE = 2;
const ACCOUNTANT = 3;
const STOCKER = 4;
const WAREHOUSE_STAFF = 5;
const ROLE_TYPE_LIST = [
    ADMIN => 'Admin',
    SALE => 'Nhân viên bán hàng',
    ACCOUNTANT => 'Kế toán',
    STOCKER => 'Thủ kho',
    WAREHOUSE_STAFF => 'Nhân viên kho',
];
const ROLE_TYPE_NAME = [
    SUPER_ADMIN => 'SUPER_ADMIN',
    ADMIN => 'Admin',
    SALE => 'Nhân viên bán hàng',
    ACCOUNTANT => 'Kế toán',
    STOCKER => 'Thủ kho',
    WAREHOUSE_STAFF => 'Nhân viên kho',
];
const DRAFT = 1;
const IN_PROCESSING = 2;
const DELIVERY = 3;
const DELIVERED = 4;
const COMPLETE = 10;
const REJECTED = 11;

const STATUS_ORDER = [
    DRAFT => 'Mới',
    IN_PROCESSING => 'Đang xử lý',
    DELIVERY => 'Đang giao hàng',
    DELIVERED => 'Đã giao hàng',
    COMPLETE => 'Hoàn thành',
    REJECTED => 'Từ chối',
];
const STATUS_COLOR = [
    DRAFT => 'primary',
    IN_PROCESSING => 'info',
    DELIVERY => 'info',
    DELIVERED => 'success',
    COMPLETE => 'secondary',
    REJECTED => 'danger',
];

const STATUS_ORDER_BUTTON = [
    IN_PROCESSING => 'Gửi đơn hàng',
    DELIVERY => 'Giao hàng',
    DELIVERED => 'Đã giao hàng',
    COMPLETE => 'Hoàn thành',
    REJECTED => 'Từ chối',
];

const UNPAID = 1;
const DEPOSITED = 3;
const PAID = 4;
const STATUS_PAYMENT = [
    UNPAID => 'Chưa thanh toán',
    IN_PROCESSING => 'Đang xử lý',
    DEPOSITED => 'Đã cọc',
    PAID => 'Đã thanh toán',
    COMPLETE => 'Hoàn thành',
    REJECTED => 'Từ chối'
];
const STATUS_PAYMENT_COLOR = [
    UNPAID => 'primary',
    IN_PROCESSING => 'info',
    DEPOSITED => 'success',
    PAID => 'success',
    COMPLETE => 'secondary',
    REJECTED => 'danger'
];

const TRANFER = 1;
const CASH = 2;
const PAYMENTS_METHOD = [
    TRANFER => 'Chuyển khoản',
    CASH => 'Tiền mặt',
];

const PAY_FULL = 1;
const DEPOSIT = 2;
const PAYMENT_ON_DELIVERY = 3;
const PAYMENTS_TYPE = [
    PAY_FULL => 'Thanh toán toàn bộ',
    DEPOSIT => 'Đặt cọc',
    PAYMENT_ON_DELIVERY => 'Thanh toán sau khi nhận hàng',
];

const COMMENT_TYPE_ORDER = 1;
const COMMENT_TYPE_PAYMENT = 2;
const UNCHECK_PAYMENT = 1;
const SALE_CHECK_PAYMENT = 2;
const ACCOUNTANT_CHECK_PAYMENT = 3;
const ADMIN_CHECK_PAYMENT = 4;
const STATUS_CHECK_PAYMENT = [
    UNCHECK_PAYMENT => 'Chưa thanh toán',
    SALE_CHECK_PAYMENT => 'Nhân viên bán hàng đã xác nhận',
    ACCOUNTANT_CHECK_PAYMENT => 'Kế toán đã xác nhận',
    ADMIN_CHECK_PAYMENT => 'Admin đã xác nhận',
    REJECTED => 'Admin đã từ chối thanh toán',
];
const HAD_UPDATE_QUANTITY = 1;
const PRINTED_RED_INVOICE = 1;
const NOT_YET_RED_INVOICE = 0;
