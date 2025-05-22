<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StockRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hasStock = Product::where('id', $value)
            ->where('stock', '>', 0)
            ->where('is_active', true)
            ->exists();

        if (!$hasStock) {
            $fail('The selected product is out of stock.');
        }
    }
}
