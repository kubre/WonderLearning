<?php

namespace App;

/** @static string approvals() */
class CacheKey
{

    public const APPROVALS = 'approvals';
    public const PAYMENT_DUE = 'payment_due';
    public const FEES = 'fees';
    public const ADMISSION = 'admission';
    public const ENQUIRY = 'enquiry';
    public const CONVERSION = 'conversion';
    public const RECEIVABLE = 'receivable';
    public const DEPOSITED = 'deposited';

    public static function for(string $key): string
    {
        return school()->code . '_' . $key;
    }
}
