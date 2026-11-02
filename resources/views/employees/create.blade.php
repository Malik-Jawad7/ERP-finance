@extends("layouts.app")
@section("content")
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Employee</h1><p class="text-sm text-slate-500 mt-1">Add or update employee details</p></div>
    <a href="{{ route('employees.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-xl">
    <form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST" class="space-y-5">
        @csrf @if(isset($employee)) @method('PUT') @endif
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Full Name *</label><input type="text" name="name" value="{{ $employee->name ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Email</label><input type="email" name="email" value="{{ $employee->email ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label><input type="text" name="phone" value="{{ $employee->phone ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Designation</label><input type="text" name="designation" value="{{ $employee->designation ?? '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Department</label><select name="department_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ (isset($employee) && $employee->department_id == $d->id) ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status</label><select name="status" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="active" {{ (isset($employee) && $employee->status == 'active') ? 'selected' : '' }}>Active</option><option value="inactive" {{ (isset($employee) && $employee->status == 'inactive') ? 'selected' : '' }}>Inactive</option></select></div>
        <button type="submit" class="w-full sm:w-auto bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($employee) ? 'Update' : 'Save' }} Employee</button>
    </form>
</div>
@endsection