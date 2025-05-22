<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\User;
use App\Notifications\AlertCartNotification;
use Illuminate\Console\Command;

class AlertCartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert the user when the cart is too long';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $carts = Cart::select('user_id')
            ->where('updated_at', '<=', now())
            ->groupBy('user_id')
            ->get()
            ->pluck('user_id')
            ->toArray();

        $users = User::whereIn('id', $carts)->get();

        foreach ($users as $user) {
            // Send alert to user
            $user->notify(new AlertCartNotification);
        }
    }
}
