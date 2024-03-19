<?php

const SUPER_ADMIN = 0;
const ADMIN = 1;
const SALE = 2;
const ROLE_TYPE_LIST = [
    ADMIN => 'ADMIN',
    SALE => 'SALE',
];
const ROLE_TYPE_NAME = [
    SUPER_ADMIN => 'SUPER_ADMIN',
    ADMIN => 'ADMIN',
    SALE => 'SALE',
];
const AWAITING = 1;
const CONFIRMED = 2;
const STATUS_ORDER_TYPE = [
    AWAITING => 'Chờ xác nhận',
    CONFIRMED => 'Đã xác nhận,'
];