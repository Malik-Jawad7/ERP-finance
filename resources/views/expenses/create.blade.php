@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Record Expense</h1><p class="text-sm text-slate-500 mt-1">Log a new company expense</p></div>
    <a href="{{ route('expenses.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2"><label class="block text-sm font-semibold text-slate-700 mb-2">Expense Title *</label><input type="text" name="title" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none" placeholder="e.g. Office Rent"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Amount ($) *</label><input type="number" step="0.01" name="amount" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Category</label><select name="category" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="general">General</option><option value="office">Office</option><option value="software">Software</option><option value="marketing">Marketing</option></select></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Date *</label><input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Save Expense</button>
    </form>
</div>
@endsection