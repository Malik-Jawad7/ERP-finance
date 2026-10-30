@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">{{ isset($transaction) ? 'Edit Transaction' : 'Record Transaction' }}</h1><p class="text-sm text-slate-500 mt-1">Add a new income or expense</p></div>
    <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ isset($transaction) ? route('transactions.update', $transaction) : route('transactions.store') }}" method="POST" class="space-y-5">
        @csrf
        @if(isset($transaction)) @method('PUT') @endif
        
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Title *</label><input type="text" name="title" value="{{ $transaction->title ?? '' }}" placeholder="e.g. Office Rent, Client Payment" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Type *</label><select name="type" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="income" {{ (isset($transaction) && $transaction->type == 'income') ? 'selected' : '' }}>Income</option><option value="expense" {{ (isset($transaction) && $transaction->type == 'expense') ? 'selected' : '' }}>Expense</option></select></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Amount ({{ currency_symbol() }}) *</label><input type="number" step="0.01" name="amount" value="{{ $transaction->amount ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Account</label><select name="account_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option>@foreach($accounts as $a)<option value="{{ $a->id }}" {{ (isset($transaction) && $transaction->account_id == $a->id) ? 'selected' : '' }}>{{ $a->name }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Vendor</label><select name="vendor_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option>@foreach($vendors as $v)<option value="{{ $v->id }}" {{ (isset($transaction) && $transaction->vendor_id == $v->id) ? 'selected' : '' }}>{{ $v->name }}</option>@endforeach</select></div>
            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Date *</label><input type="date" name="occurred_at" value="{{ isset($transaction) ? $transaction->occurred_at->format('Y-m-d') : date('Y-m-d') }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Description</label><textarea name="description" rows="3" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">{{ $transaction->description ?? '' }}</textarea></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($transaction) ? 'Update' : 'Save' }} Transaction</button>
    </form>
</div>
@endsection