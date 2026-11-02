@extends("layouts.app")
@section("content")
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Expenses</h1>
        <p class="text-sm text-slate-500 mt-1">Track company spending</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <form action="{{ route('expenses.destroyAll') }}" method="POST" onsubmit="return confirm('Delete ALL expenses?');" class="w-full sm:w-auto">
            @csrf @method('DELETE')
            <button type="submit" class="w-full sm:w-auto bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="{{ route('expenses.create') }}" class="w-full sm:w-auto justify-center bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Expense
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
    <div class="table-responsive">
        <table class="w-full text-sm text-left min-w-[500px]">
            <thead class="text-slate-500 border-b">
                <tr><th class="pb-3 px-2">Expense</th><th class="pb-3 px-2">Category</th><th class="pb-3 px-2">Date</th><th class="pb-3 px-2 text-right">Amount</th><th class="pb-3 px-2 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($expenses as $e)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-2 font-bold text-slate-800">{{ $e->title }}</td>
                    <td class="py-3 px-2"><span class="px-2 py-1 bg-slate-100 rounded text-xs font-bold">{{ ucfirst($e->category) }}</span></td>
                    <td class="py-3 px-2 text-slate-600">{{ $e->spent_at->format('M d, Y') }}</td>
                    <td class="py-3 px-2 text-right font-bold text-rose-600">{{ currency_symbol() }}{{ number_format($e->amount, 2) }}</td>
                    <td class="py-3 px-2 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('expenses.show', $e) }}" class="text-emerald-600 font-medium hover:underline">Voucher</a>
                        <a href="{{ route('expenses.edit', $e) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="{{ route('expenses.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-slate-500">No expenses found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $expenses->links() }}</div>
@endsection