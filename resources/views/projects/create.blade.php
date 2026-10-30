@extends("layouts.app")
@section("content")
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Project</h1><p class="text-sm text-slate-500 mt-1">Add or update project details</p></div>
    <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-xl">
    <form action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" method="POST" class="space-y-5">
        @csrf @if(isset($project)) @method('PUT') @endif
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Project Name *</label><input type="text" name="name" value="{{ $project->name ?? '' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Client</label><select name="client_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option>@foreach($clients as $c)<option value="{{ $c->id }}" {{ (isset($project) && $project->client_id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Budget ($) *</label><input type="number" step="0.01" name="budget" value="{{ $project->budget ?? '0' }}" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status</label><select name="status" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="pending" {{ (isset($project) && $project->status == 'pending') ? 'selected' : '' }}>Pending</option><option value="ongoing" {{ (isset($project) && $project->status == 'ongoing') ? 'selected' : '' }}>Ongoing</option><option value="completed" {{ (isset($project) && $project->status == 'completed') ? 'selected' : '' }}>Completed</option></select></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label><input type="date" name="start_date" value="{{ isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">End Date</label><input type="date" name="end_date" value="{{ isset($project) && $project->end_date ? $project->end_date->format('Y-m-d') : '' }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">{{ isset($project) ? 'Update' : 'Save' }} Project</button>
    </form>
</div>
@endsection