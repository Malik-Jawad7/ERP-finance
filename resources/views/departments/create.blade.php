@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Department</h1><p class="text-sm text-slate-500 mt-1">Add or update department details</p></div>
    <a href="{{ route('departments.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-xl">
    <form action="{{ isset($department) ? route('departments.update', $department) : route('departments.store') }}" method="POST" class="space-y-5">
        @csrf @if(isset($department)) @method('PUT') @endif
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Department Name *</label><input type="text" name="name" value="{{ $department->name ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Code</label><input type="text" name="code" value="{{ $department->code ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Description</label><textarea name="description" rows="3" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">{{ $department->description ?? '' }}</textarea></div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($department) ? 'Update' : 'Save' }} Department</button>
    </form>
</div>
@endsection