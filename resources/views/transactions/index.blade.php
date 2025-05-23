<x-layouts.app :title="__('Transaction History')">

    <ul role="list" class="divide-y divide-gray-100">
        @foreach($transactions as $transaction)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                <div class="min-w-0 flex-auto">
                    <p class="text-sm/6 font-semibold text-gray-900">Transaction ID: {{ $transaction->id }}</p>
                    <p class="mt-1 truncate text-xs/5 text-gray-500">${{ $transaction->total }}</p>
                </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <p class="mt-1 text-xs/5 text-gray-500">{{ $transaction->created_at->diffForHumans() }}</p>
                </div>
            </li>
        @endforeach
    </ul>

</x-layouts.app>
