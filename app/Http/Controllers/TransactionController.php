<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Auth::user()->transactions;

        $transactions = $transactions->map(function ($transaction) {
            $carts = collect($transaction->carts)->map(function ($cart) {
                $cart->total = $cart->product->price * $cart->quantity;

                return $cart;
            });

            $transaction->total = $carts->pluck('total')->sum();

            return $transaction;
        });

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('checkout.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form = $request->validate([
            'phone_number' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'card_number' => 'required|string|max:255',
            'card_expiry' => 'required|string|max:255',
            'card_name' => 'required|string|max:255',
            'message' => 'nullable|string|max:255',
        ]);

        $form['user_id'] = Auth::user()->id;

        $carts = Auth::user()->carts;

        $form['carts'] = $carts->toArray();

        Transaction::create($form);

        $carts->each(function ($cart) {
            $cart->delete();
        });

        return redirect()->route('transactions.index');

        // $transaction = new Transaction;
        // $transaction->user_id = auth()->user()->id;
        // $transaction->phone_number = $request->phone_number;
        // $transaction->billing_address = $request->billing_address;
        // $transaction->card_number = $request->card_number;
        // $transaction->card_expiry = $request->card_expiry;
        // $transaction->card_name = $request->card_name;
        // $transaction->message = $request->message;
        // $transaction->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
