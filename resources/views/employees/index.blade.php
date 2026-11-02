@extends("layouts.app")
@section("content")
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Employees</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your workforce</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <form action="{{ route('employees.destroyAll') }}" method="POST" onsubmit="return confirm('Delete ALL employees?')" class="w-full sm:w-auto">
            @csrf @method('DELETE')
            <button type="submit" class="w-full sm:w-auto bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="{{ route('employees.create') }}" class="w-full sm:w-auto justify-center bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Employee
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
    <div class="table-responsive">
        <table class="w-full text-sm text-left min-w-[600px]">
            <thead class="text-slate-500 border-b">
                <tr><th class="pb-3 px-2">Name</th><th class="pb-3 px-2">Department</th><th class="pb-3 px-2">Designation</th><th class="pb-3 px-2">Status</th><th class="pb-3 px-2 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($employees as $emp)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-2 font-bold text-slate-800">{{ $emp->name }}</td>
                    <td class="py-3 px-2 text-slate-600">{{ $emp->department->name ?? '-' }}</td>
                    <td class="py-3 px-2 text-slate-600">{{ $emp->designation ?? '-' }}</td>
                    <td class="py-3 px-2"><span class="bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md text-xs font-bold">{{ ucfirst($emp->status) }}</span></td>
                    <td class="py-3 px-2 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('employees.edit', $emp) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-slate-500">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $employees->links() }}</div>
@endsection