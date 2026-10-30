@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Generate Payroll</h1><p class="text-sm text-slate-500 mt-1">Create a new salary record</p></div>
    <a href="{{ route('payrolls.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('payrolls.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Select Employee *</label>
                <select name="user_id" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                    <option value="">-- Choose Employee --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Month *</label>
                <input type="text" name="month" value="{{ date('F Y') }}" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none" placeholder="e.g. October 2026">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Basic Salary ($) *</label>
                <input type="number" step="0.01" name="basic_salary" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Allowances ($)</label>
                <input type="number" step="0.01" name="allowances" value="0" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deductions ($)</label>
                <input type="number" step="0.01" name="deductions" value="0" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Date (if paid)</label>
                <input type="date" name="payment_date" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
            </div>
        </div>
        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Save Payroll</button>
    </form>
</div>
@endsection