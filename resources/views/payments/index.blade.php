@extends("layouts.app")
@section("content")
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Payments & Receipts</h1>
        <p class="text-sm text-slate-500 mt-1">All customer payments received</p>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border p-6">
    <table class="w-full text-sm text-left">
        <thead class="text-slate-500 border-b">
            <tr>
                <th class="pb-3">Receipt #</th>
                <th class="pb-3">Invoice</th>
                <th class="pb-3">Client</th>
                <th class="pb-3">Date</th>
                <th class="pb-3">Method</th>
                <th class="pb-3 text-right">Amount</th>
                <th class="pb-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($payments as $p)
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold">{{ $p->receipt_no }}</td>
                <td class="py-3">{{ $p->invoice->invoice_no ?? '-' }}</td>
                <td class="py-3">{{ $p->invoice->client->name ?? '-' }}</td>
                <td class="py-3">{{ $p->paid_at->format('M d, Y') }}</td>
                <td class="py-3"><span class="px-2 py-1 bg-slate-100 rounded text-xs font-bold">{{ ucfirst($p->method) }}</span></td>
                <td class="py-3 text-right font-bold text-emerald-600">{{ currency_symbol() }}{{ number_format($p->amount, 2) }}</td>
                <td class="py-3 text-right space-x-2">
                    <a href="{{ route('payments.show', $p) }}" class="text-blue-600 font-semibold">View Receipt</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="py-8 text-center text-slate-500">No payments recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $payments->links() }}</div>
@endsection