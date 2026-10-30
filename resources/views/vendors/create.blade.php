@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Vendor</h1><p class="text-sm text-slate-500 mt-1">Add or update supplier details</p></div>
    <a href="{{ route('vendors.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-xl">
    <form action="{{ isset($vendor) ? route('vendors.update', $vendor) : route('vendors.store') }}" method="POST" class="space-y-5">
        @csrf
        @if(isset($vendor)) @method('PUT') @endif
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Vendor Name *</label><input type="text" name="name" value="{{ $vendor->name ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Company</label><input type="text" name="company" value="{{ $vendor->company ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Email</label><input type="email" name="email" value="{{ $vendor->email ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label><input type="text" name="phone" value="{{ $vendor->phone ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($vendor) ? 'Update' : 'Save' }} Vendor</button>
    </form>
</div>
@endsection