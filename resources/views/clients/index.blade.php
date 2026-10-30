@extends("layouts.app")
@section("content")
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Clients</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your client database</p>
    </div>
    <div class="flex gap-2">
        <form action="{{ route('clients.destroyAll') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete ALL clients?');">
            @csrf @method('DELETE')
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-lg text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="{{ route('clients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition-all">+ Add Client</a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="table-responsive"><table class="w-full text-sm text-left min-w-[600px]">
        <thead class="text-slate-500 border-b"><tr><th class="pb-3">Name</th><th class="pb-3">Email</th><th class="pb-3 text-right">Actions</th></tr></thead>
        <tbody class="divide-y">
            @forelse($clients as $c)
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold text-slate-800">{{ $c->name }}</td>
                <td class="py-3 text-slate-600">{{ $c->email }}</td>
                <td class="py-3 text-right space-x-3">
                    <a href="{{ route('clients.edit', $c) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                    <form action="{{ route('clients.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Delete {{ $c->name }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 font-medium hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="py-8 text-center text-slate-500">No clients found.</td></tr>
            @endforelse
        </tbody>
    </table></div>
</div>
<div class="mt-4">{{ $clients->links() }}</div>
@endsection