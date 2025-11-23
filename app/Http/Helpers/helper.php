<?php

use Illuminate\Support\Facades\Blade;

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

// Register blade directive
if (!Blade::hasDirective('rupiah')) {
    Blade::directive('rupiah', function ($expression) {
        return "<?php echo rupiah($expression); ?>";
    });
}
