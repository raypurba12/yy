<?php

if (!function_exists('rupiah')) {
    /**
     * Format number to Rupiah currency
     *
     * @param int|float $amount
     * @return string
     */
    function rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
