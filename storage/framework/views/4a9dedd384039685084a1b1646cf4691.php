<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
        <p class="text-sm font-medium text-slate-500 mt-1">Live financial metrics for your business.</p>
    </div>
    <a href="<?php echo e(route('invoices.create')); ?>" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> New Invoice
    </a>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
<?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="gsap-fade-up bg-white rounded-2xl shadow-card p-6 border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
    <div class="absolute right-0 top-0 w-24 h-24 bg-<?php echo e($k['color']); ?>-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
    <div class="relative z-10">
        <p class="text-sm font-semibold text-slate-500"><?php echo e($k['label']); ?></p>
        <p class="text-xl md:text-2xl lg:text-3xl font-extrabold text-slate-900 mt-2 truncate w-full block"><?php echo e($k['value']); ?></p>
        <div class="mt-4 flex items-center gap-2 text-sm font-medium">
            <span class="<?php echo e($k['up'] ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50'); ?> px-2 py-1 rounded-md flex items-center gap-1">
                <?php echo e($k['up'] ? '↑' : '↓'); ?> <?php echo e($k['delta']); ?>

            </span>
            <span class="text-slate-400">vs last month</span>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Charts & Top Clients -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="gsap-fade-up lg:col-span-2 bg-white rounded-2xl shadow-card p-6 border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">Cashflow Analytics</h2>
        <div class="h-72 w-full"><canvas id="cashflowChart"></canvas></div>
    </div>
    <div class="gsap-fade-up bg-white rounded-2xl shadow-card p-6 border border-slate-100">
        <h2 class="text-lg font-bold text-slate-900 mb-6">Top Clients</h2>
        <div class="space-y-5">
        <?php $__empty_1 = true; $__currentLoopData = $topClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div>
                <div class="flex justify-between text-sm font-semibold mb-1"><span class="text-slate-700"><?php echo e($c->name); ?></span><span class="text-slate-900">$<?php echo e(number_format($c->paid_total ?? 0)); ?></span></div>
                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-brand-500 rounded-full" style="width:<?php echo e((($c->paid_total??0)/max($topClients->max('paid_total'),1))*100); ?>%"></div></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-500 text-center py-4">No top clients yet.</p>
        <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Invoices -->
    <div class="gsap-fade-up bg-white rounded-2xl shadow-card border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-slate-900">Recent Invoices</h2>
            <a href="<?php echo e(route('invoices.index')); ?>" class="text-xs font-bold text-brand-600 hover:underline">View All</a>
        </div>
        <div class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-3 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-slate-800 text-sm"><?php echo e($inv->invoice_no); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($inv->client->name ?? 'Unknown'); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-slate-800 text-sm">$<?php echo e(number_format($inv->total, 2)); ?></p>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?php echo e($inv->status == 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'); ?>"><?php echo e(ucfirst($inv->status)); ?></span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-slate-500 text-center py-4">No recent invoices.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="gsap-fade-up bg-white rounded-2xl shadow-card border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-slate-900">Recent Transactions</h2>
            <a href="<?php echo e(route('transactions.index')); ?>" class="text-xs font-bold text-brand-600 hover:underline">View All</a>
        </div>
        <div class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-3 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-slate-800 text-sm"><?php echo e($tx->title ?? $tx->reference); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($tx->occurred_at->format('M d, Y')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm <?php echo e($tx->type == 'income' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                            <?php echo e($tx->type == 'income' ? '+' : '-'); ?>$<?php echo e(number_format($tx->amount, 2)); ?>

                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-slate-500 text-center py-4">No recent transactions.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush("scripts"); ?>
<script>
    document.addEventListener("DOMContentLoaded", () => { 
        gsap.to(".gsap-fade-up", {opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: "power3.out"}); 
    });
    
    const ctx = document.getElementById('cashflowChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($cashflow->pluck('label')); ?>,
            datasets: [
                { label: 'Income', data: <?php echo json_encode($cashflow->pluck('income')); ?>, backgroundColor: '#3b82f6', borderRadius: 6, barPercentage: 0.6 },
                { label: 'Expenses', data: <?php echo json_encode($cashflow->pluck('expense')); ?>, backgroundColor: '#f43f5e', borderRadius: 6, barPercentage: 0.6 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, font: { family: 'Plus Jakarta Sans', weight: 'bold' } } } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { color: '#64748b', callback: function(value) { return '$' + value.toLocaleString(); } } },
                x: { grid: { display: false }, ticks: { color: '#64748b' } }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/dashboard.blade.php ENDPATH**/ ?>