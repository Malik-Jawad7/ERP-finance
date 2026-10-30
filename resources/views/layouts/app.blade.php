<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8fafc]">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ DB::table('settings')->where('key', 'company_name')->value('value') ?? 'FinERP' }}</title>

{{-- Dynamic Favicon --}}
@php $favicon = DB::table("settings")->where("key", "favicon")->value("value"); @endphp
@if($favicon) <link rel="icon" href="{{ asset($favicon) }}"> @endif

<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{fontFamily:{sans:["Plus Jakarta Sans","sans-serif"]},colors:{brand:{50:"#eff6ff",500:"#3b82f6",600:"#2563eb",900:"#1e3a8a"}},boxShadow:{card:"0 4px 20px -2px rgba(0,0,0,0.05)"}}}};</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body{font-family:"Plus Jakarta Sans",sans-serif;-webkit-font-smoothing:antialiased}
    .gsap-fade-up{opacity:0;transform:translateY(20px)}
    .glass-panel{background:rgba(255,255,255,0.85);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.5)}
    ::-webkit-scrollbar{width:6px} ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:10px}
    .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
</style>
</head>
<body class="h-full text-slate-800 overflow-hidden">
<div class="flex h-screen">
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-slate-100 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <div class="h-20 flex items-center gap-3 px-6 border-b border-slate-50 overflow-hidden">
            @php $logo = setting("logo"); $companyName = setting("company_name", "FinERP."); @endphp
            @if($logo)
                <div class="h-10 w-10 shrink-0 rounded-xl overflow-hidden flex items-center justify-center border border-slate-100 bg-white p-1">
                    <img src="{{ asset($logo) }}" alt="Logo" class="h-full w-full object-contain">
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900 truncate">{{ $companyName }}</span>
            @else
                <div class="h-10 w-10 shrink-0 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2"/></svg>
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900 truncate">{{ $companyName }}</span>
            @endif
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg> Dashboard
            </a>
            <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('invoices.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Invoices
            </a>
            <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('expenses.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Expenses
            </a>
            <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('clients.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Clients
            </a>
            <a href="{{ route('payrolls.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('payrolls.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Payroll
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('transactions.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg> Transactions
            </a>
            <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('accounts.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Accounts
            </a>
            <a href="{{ route('vendors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('vendors.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Vendors
            </a>
                        <a href="{{ route('departments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('departments.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Departments
            </a>
            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('employees.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Employees
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('projects.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg> Projects
            </a>
<a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('settings') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Settings
            </a>
        </nav>
        
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 bg-[#f8fafc]">
        <!-- Topbar -->
        <header class="h-20 glass-panel flex items-center justify-between px-4 md:px-8 z-10 sticky top-0">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="relative w-64 md:w-96 hidden sm:block">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    <input type="text" placeholder="Search anything..." class="w-full pl-11 pr-4 py-2.5 bg-slate-100/50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all">
                </div>
            </div>
            
            <div class="flex items-center gap-4 relative">
                <!-- Notification Bell -->
                <div class="relative">
                    @php 
                        $notifications = \App\Models\CustomNotification::where("user_id", auth()->id())->orderByDesc("created_at")->take(5)->get();
                        $unreadCount = \App\Models\CustomNotification::where("user_id", auth()->id())->where("is_read", false)->count();
                    @endphp
                    <button onclick="document.getElementById('notif-menu').classList.toggle('hidden'); markNotificationsAsRead();" class="relative p-2 text-slate-400 hover:bg-slate-100 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadCount > 0)
                            <span id="notif-badge" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-rose-500 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div id="notif-menu" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">
                        <div class="px-5 py-3 border-b border-slate-50 bg-slate-50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">Notifications</h3>
                            <button onclick="clearAllNotifications()" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Clear All</button>
                        </div>
                        <div class="divide-y divide-slate-50 max-h-80 overflow-y-auto">
                            @forelse($notifications as $notif)
                                <a href="#" class="block px-5 py-4 hover:bg-slate-50 transition {{ $notif->is_read ? 'opacity-60' : 'bg-blue-50/30' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 h-6 w-6 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $notif->title }}</p>
                                            <p class="text-xs text-slate-600 mt-0.5">{{ $notif->message }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-5 py-6 text-center text-slate-500 text-sm">No new notifications</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="relative">
                    <button onclick="document.getElementById('user-menu').classList.toggle('hidden')" class="flex items-center gap-3 p-1.5 pr-3 rounded-full hover:bg-slate-100 border border-transparent hover:border-slate-200 transition-all focus:outline-none">
                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Admin User' }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 capitalize leading-tight">{{ auth()->user()->role ?? 'Admin' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 hidden sm:block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="user-menu" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs font-medium text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@finerp.test' }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('settings') }}" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Account Settings
                            </a>
                        </div>
                        <div class="border-t border-slate-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield("content")
        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('mobile-overlay').classList.toggle('hidden');
    }

    function markNotificationsAsRead() {
        fetch("{{ route('notifications.read') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(() => {
            const badge = document.getElementById('notif-badge');
            if (badge) badge.remove();
        });
    }

    document.addEventListener('click', function(event) {
        const notifMenu = document.getElementById('notif-menu');
        const userMenu = document.getElementById('user-menu');
        if (notifMenu && !event.target.closest('#notif-menu') && !event.target.closest('button[onclick*="notif-menu"]')) notifMenu.classList.add('hidden');
        if (userMenu && !event.target.closest('#user-menu') && !event.target.closest('button[onclick*="user-menu"]')) userMenu.classList.add('hidden');
    });
</script>
@stack("scripts")
<script>
    // Mark as read (existing)
    function markNotificationsAsRead() {
        fetch("{{ route('notifications.read') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(() => {
            const badge = document.getElementById('notif-badge');
            if (badge) badge.remove();
        });
    }

    // Clear All Notifications (new)
    function clearAllNotifications() {
        if(!confirm('Are you sure you want to clear all notifications?')) return;
        
        fetch("{{ route('notifications.clear') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  // Clear the list in UI
                  document.querySelector('#notif-menu .divide-y').innerHTML = '<div class="px-5 py-6 text-center text-slate-500 text-sm">No new notifications</div>';
                  // Remove the badge
                  const badge = document.getElementById('notif-badge');
                  if (badge) badge.remove();
              }
          });
    }
</script>
</body>
</html>