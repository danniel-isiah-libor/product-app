<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'carts' => json_encode([Cart::factory()->create()]),
            'phone_number' => $this->faker->phoneNumber(),
            'billing_address' => $this->faker->address(),
            'card_number' => $this->faker->creditCardNumber(),
            'card_expiry' => $this->faker->creditCardExpirationDateString(),
            'card_name' => $this->faker->name(),
            'message' => $this->faker->sentence(),
        ];
    }
}
