<?php
const FORMAT_DATE = 'Y-m-d';
const FORMAT_DATE_TIME = 'Y-m-d H:i:s';
const FORMAT_DATE_VN = 'd-m-Y';
const FORMAT_DATE_TIME_VN = 'd-m-Y H:i:s';

const SUPER_ADMIN = 0;
const ADMIN = 1;
const SALE = 2;
const ACCOUNTANT = 3;
const WAREHOUSE_STAFF = 4;
const ROLE_TYPE_LIST = [
    ADMIN => 'Admin',
    SALE => 'Nhân viên bán hàng',
    ACCOUNTANT => 'Kế toán',
    WAREHOUSE_STAFF => 'Nhân viên kho',
];
const ROLE_TYPE_NAME = [
    SUPER_ADMIN => 'SUPER_ADMIN',
    ADMIN => 'Admin',
    SALE => 'Nhân viên bán hàng',
    ACCOUNTANT => 'Kế toán',
    WAREHOUSE_STAFF => 'Nhân viên kho',
];
const DRAFT = 1;
const AWAITING = 2;
const CONFIRMED = 3;
const DELIVERY = 4;
const DELIVERED = 5;
const COMPLETE = 10;
const REJECTED = 11;

const STATUS_ORDER = [
    DRAFT => 'Chưa xác nhận',
    AWAITING => 'Chờ xác nhận',
    CONFIRMED => 'Đã xác nhận',
    DELIVERY => 'Đang giao hàng',
    DELIVERED => 'Đã giao',
    COMPLETE => 'Hoàn thành',
    REJECTED => 'Từ chối',
];

const UNPAID = 1;
const PARITAL_PAYMENT = 2;
const PAID = 3;
const CANCEL = 4;
const STATUS_PAYMENT = [
    UNPAID => 'Chưa thanh toán',
    PARITAL_PAYMENT => 'Đã cọc',
    PAID => 'Đã thanh toán',
    COMPLETE => 'Hoàn thành',
];
