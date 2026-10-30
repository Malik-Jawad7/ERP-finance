@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">{{ isset($invoice) ? 'Edit Invoice ' . $invoice->invoice_no : 'Create Invoice' }}</h1><p class="text-sm text-slate-500 mt-1">Generate a new invoice for a client</p></div>
    <a href="{{ route('invoices.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ isset($invoice) ? route('invoices.update', $invoice) : route('invoices.store') }}" method="POST" class="space-y-6">
        @csrf @if(isset($invoice)) @method('PUT') @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Select Client *</label><select name="client_id" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Choose Client --</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ (isset($invoice) && $invoice->client_id == $c->id) ? 'selected' : '' }}>{{ $c->name }} ({{ $c->company ?? 'Individual' }})</option>@endforeach</select></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Amount ({{ currency_symbol() }}) *</label><input type="number" step="0.01" name="amount" value="{{ $invoice->amount ?? '' }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Tax ({{ currency_symbol() }})</label><input type="number" step="0.01" name="tax" value="{{ $invoice->tax ?? '0' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Issue Date *</label><input type="date" name="issued_at" value="{{ isset($invoice) ? $invoice->issued_at->format('Y-m-d') : date('Y-m-d') }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status *</label><select name="status" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="draft" {{ (isset($invoice) && $invoice->status == 'draft') ? 'selected' : '' }}>Draft</option><option value="sent" {{ (isset($invoice) && $invoice->status == 'sent') ? 'selected' : '' }}>Sent</option><option value="paid" {{ (isset($invoice) && $invoice->status == 'paid') ? 'selected' : '' }}>Paid</option><option value="overdue" {{ (isset($invoice) && $invoice->status == 'overdue') ? 'selected' : '' }}>Overdue</option></select></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($invoice) ? 'Update' : 'Save' }} Invoice</button>
    </form>
</div>
@endsection