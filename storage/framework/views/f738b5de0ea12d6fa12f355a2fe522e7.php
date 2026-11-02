<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Invoices</h1>
        <p class="text-sm text-slate-500 mt-1">Track and manage your billing</p>
    </div>
    <div class="flex gap-2">
        <form action="<?php echo e(route('invoices.destroyAll')); ?>" method="POST" onsubmit="return confirm('Delete ALL invoices?');">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="<?php echo e(route('invoices.create')); ?>" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Create Invoice
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="table-responsive">
        <table class="w-full text-sm text-left min-w-[700px]">
            <thead class="bg-slate-50 text-slate-500 border-b">
                <tr><th class="px-6 py-4">Invoice #</th><th class="px-6 py-4">Client</th><th class="px-6 py-4">Date</th><th class="px-6 py-4 text-right">Amount</th><th class="px-6 py-4">Status</th><th class="px-6 py-4 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php 
                    $statusColors = [
                        'paid'    => 'bg-emerald-50 text-emerald-600',
                        'sent'    => 'bg-sky-50 text-sky-600',
                        'draft'   => 'bg-slate-100 text-slate-600',
                        'overdue' => 'bg-rose-50 text-rose-600', 'partial' => 'bg-purple-50 text-purple-600',
                        'cancelled' => 'bg-slate-100 text-slate-500',
                    ];
                ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-900"><?php echo e($inv->invoice_no); ?></td>
                    <td class="px-6 py-4 text-slate-600"><?php echo e($inv->client->name ?? 'Deleted Client'); ?></td>
                    <td class="px-6 py-4 text-slate-600"><?php echo e($inv->issued_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 text-right font-bold text-slate-800"><?php echo e(currency_symbol()); ?><?php echo e(number_format($inv->total, 2)); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($statusColors[$inv->status] ?? 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e(ucfirst($inv->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <?php if(in_array($inv->status, ['sent', 'overdue', 'partial'])): ?>
                        <a href="<?php echo e(route('invoices.pay', $inv)); ?>" class="text-emerald-600 font-medium hover:underline">Record Payment</a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('invoices.edit', $inv)); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="<?php echo e(route('invoices.destroy', $inv)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No invoices found. Create one to get started.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6"><?php echo e($invoices->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/invoices/index.blade.php ENDPATH**/ ?>