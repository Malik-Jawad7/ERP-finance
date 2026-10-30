@extends("layouts.app")
@section("content")
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Payroll</h1>
        <p class="text-sm text-slate-500 mt-1">Manage employee salaries</p>
    </div>
    <div class="flex gap-2">
        <form action="{{ route('payrolls.destroyAll') }}" method="POST" onsubmit="return confirm('Delete ALL payrolls?');">
            @csrf @method('DELETE')
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="{{ route('payrolls.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition-all">+ Generate Payroll</a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="table-responsive"><table class="w-full text-sm text-left min-w-[600px]">
        <thead class="text-slate-500 border-b">
            <tr>
                <th class="pb-3">Employee</th>
                <th class="pb-3">Month</th>
                <th class="pb-3 text-right">Net Salary</th>
                <th class="pb-3">Status</th>
                <th class="pb-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($payrolls as $p)
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold text-slate-800">{{ $p->user->name ?? 'Unknown' }}</td>
                <td class="py-3 text-slate-600">{{ $p->month }}</td>
                <td class="py-3 text-right font-bold text-emerald-600">${{ number_format($p->net_salary, 2) }}</td>
                <td class="py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $p->status == 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td class="py-3 text-right space-x-3">
                    <a href="{{ route('payrolls.edit', $p) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                    <form action="{{ route('payrolls.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Delete payroll?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 font-medium hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-8 text-center text-slate-500">No payroll records found.</td></tr>
            @endforelse
        </tbody>
    </table></div>
</div>
<div class="mt-4">{{ $payrolls->links() }}</div>
@endsection