@extends("layouts.app")
@section("content")
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Transactions</h1>
        <p class="text-sm text-slate-500 mt-1">Track income, expenses, and transfers</p>
    </div>
    <div class="flex gap-2">
        <form action="{{ route('transactions.destroyAll') }}" method="POST" onsubmit="return confirm('Delete ALL transactions?');">
            @csrf @method('DELETE')
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="{{ route('transactions.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Transaction
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="table-responsive">
        <table class="w-full text-sm text-left min-w-[600px]">
            <thead class="text-slate-500 border-b">
                <tr><th class="pb-3">Reference</th><th class="pb-3">Type</th><th class="pb-3">Account</th><th class="pb-3">Date</th><th class="pb-3 text-right">Amount</th><th class="pb-3 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transactions as $t)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 font-bold">{{ $t->reference }}</td>
                    <td class="py-3"><span class="px-2 py-1 rounded-md text-xs font-bold {{ $t->type == 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">{{ ucfirst($t->type) }}</span></td>
                    <td class="py-3 text-slate-600">{{ $t->account->name ?? '-' }}</td>
                    <td class="py-3 text-slate-600">{{ $t->occurred_at->format('M d, Y') }}</td>
                    <td class="py-3 text-right font-bold {{ $t->type == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">${{ number_format($t->amount, 2) }}</td>
                    <td class="py-3 text-right space-x-2">
                        <a href="{{ route('transactions.edit', $t) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="{{ route('transactions.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-slate-500">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $transactions->links() }}</div>
@endsection