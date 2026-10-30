@extends("layouts.app")
@section("content")
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Enterprise Settings</h1>
    <p class="text-sm text-slate-500 mt-1">Manage your company details, branding and system preferences.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-4xl">
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Branding Section -->
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Branding</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Company Logo</label>
                    @if(isset($settings['logo']))
                        <div class="mb-2 p-2 bg-slate-50 rounded-lg inline-block"><img src="{{ asset($settings['logo']) }}" class="h-12 object-contain"></div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full border border-slate-200 p-2 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700">
                    <p class="text-xs text-slate-500 mt-1">Recommended: PNG or SVG, max 2MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Favicon (Browser Icon)</label>
                    @if(isset($settings['favicon']))
                        <div class="mb-2 p-2 bg-slate-50 rounded-lg inline-block"><img src="{{ asset($settings['favicon']) }}" class="h-8 w-8 object-contain"></div>
                    @endif
                    <input type="file" name="favicon" accept="image/x-icon,image/png" class="w-full border border-slate-200 p-2 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700">
                    <p class="text-xs text-slate-500 mt-1">Recommended: ICO or PNG (32x32), max 1MB.</p>
                </div>
            </div>
        </div>

        <!-- Company Details -->
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Company Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Company Name</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'FinERP Ltd' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <input type="email" name="company_email" value="{{ $settings['company_email'] ?? 'info@finerp.com' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                    <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '+1 234 567 890' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                </div>
            </div>
        </div>

        <!-- Financial Settings -->
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Financial Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Currency</label>
                    <select name="currency" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                        <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="PKR" {{ ($settings['currency'] ?? '') == 'PKR' ? 'selected' : '' }}>PKR (Rs)</option>
                        <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Default Tax Rate (%)</label>
                    <input type="number" step="0.01" name="tax_rate" value="{{ $settings['tax_rate'] ?? '5.00' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" value="{{ $settings['invoice_prefix'] ?? 'INV-' }}" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                </div>
            </div>
        </div>

        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Save All Settings</button>
    </form>
</div>
@endsection