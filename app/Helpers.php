<?php

if (!function_exists("setting")) {
    function setting($key, $default = null) {
        static $settings = null;
        if ($settings === null) {
            $settings = \Illuminate\Support\Facades\DB::table("settings")->pluck("value", "key")->toArray();
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists("currency_symbol")) {
    function currency_symbol() {
        $currency = setting("currency", "USD");
        $symbols = [
            "USD" => "$",
            "PKR" => "Rs ",
            "EUR" => "€",
            "GBP" => "£",
        ];
        return $symbols[$currency] ?? "$";
    }
}