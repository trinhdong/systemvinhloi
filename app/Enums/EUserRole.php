<?php

namespace App\Enums;

abstract class EUserRole
{

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const PRODUCT_MANAGER = 3;
    const ACCOUNTANT= 4;
    const SELLER = 5;
    const SELL_DEPARTMENT  = 6;

    public static function getArray()
    {
        $array = [
            self::SUPER_ADMIN => 'スーパー管理者',
            self::ADMIN => '営業所ごと管理者',
            self::PRODUCT_MANAGER => '商品管理',
            self::ACCOUNTANT => '総務・経理',
            self::SELLER => '営業',
            self::SELL_DEPARTMENT => '営業事務',
        ];
        return $array;
    }

    public static function changeValueToName($value)
    {
        switch ($value) {
            case self::SUPER_ADMIN:
                return "スーパー管理者";
            case self::ADMIN:
                return "営業所ごと管理者";
            case self::PRODUCT_MANAGER:
                return "商品管理";
            case self::ACCOUNTANT:
                return "総務・経理";
            case self::SELLER:
                return "営業";
            case self::SELL_DEPARTMENT:
                return "営業事務";
        }
    }
}
