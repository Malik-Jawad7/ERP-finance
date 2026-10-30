@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Edit Payroll</h1><p class="text-sm text-slate-500 mt-1">Update salary record for {{ $payroll->user->name }}</p></div>
    <a href="{{ route('payrolls.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('payrolls.update', $payroll) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Employee *</label>
                <select name="user_id" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ $payroll->user_id == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Month *</label>
                <input type="text" name="month" value="{{ $payroll->month }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                    <option value="pending" {{ $payroll->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $payroll->status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Basic Salary ($) *</label>
                <input type="number" step="0.01" name="basic_salary" value="{{ $payroll->basic_salary }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Allowances ($)</label>
                <input type="number" step="0.01" name="allowances" value="{{ $payroll->allowances }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deductions ($)</label>
                <input type="number" step="0.01" name="deductions" value="{{ $payroll->deductions }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Date</label>
                <input type="date" name="payment_date" value="{{ $payroll->payment_date?->format('Y-m-d') }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
        </div>
        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Update Payroll</button>
    </form>
</div>
@endsection