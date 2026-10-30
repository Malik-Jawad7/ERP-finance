@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Account</h1><p class="text-sm text-slate-500 mt-1">Add or update a bank/cash account</p></div>
    <a href="{{ route('accounts.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-xl">
    <form action="{{ isset($account) ? route('accounts.update', $account) : route('accounts.store') }}" method="POST" class="space-y-5">
        @csrf
        @if(isset($account)) @method('PUT') @endif
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Account Name *</label><input type="text" name="name" value="{{ $account->name ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Account Number</label><input type="text" name="account_number" value="{{ $account->account_number ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Type *</label><select name="type" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="bank" {{ (isset($account) && $account->type == 'bank') ? 'selected' : '' }}>Bank</option><option value="cash" {{ (isset($account) && $account->type == 'cash') ? 'selected' : '' }}>Cash</option></select></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Balance ($) *</label><input type="number" step="0.01" name="balance" value="{{ $account->balance ?? '0' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($account) ? 'Update' : 'Save' }} Account</button>
    </form>
</div>
@endsection