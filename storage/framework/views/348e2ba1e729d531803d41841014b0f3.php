<?php $__env->startSection("content"); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Payments & Receipts</h1>
        <p class="text-sm text-slate-500 mt-1">All customer payments received</p>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border p-6">
    <table class="w-full text-sm text-left">
        <thead class="text-slate-500 border-b">
            <tr>
                <th class="pb-3">Receipt #</th>
                <th class="pb-3">Invoice</th>
                <th class="pb-3">Client</th>
                <th class="pb-3">Date</th>
                <th class="pb-3">Method</th>
                <th class="pb-3 text-right">Amount</th>
                <th class="pb-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold"><?php echo e($p->receipt_no); ?></td>
                <td class="py-3"><?php echo e($p->invoice->invoice_no ?? '-'); ?></td>
                <td class="py-3"><?php echo e($p->invoice->client->name ?? '-'); ?></td>
                <td class="py-3"><?php echo e($p->paid_at->format('M d, Y')); ?></td>
                <td class="py-3"><span class="px-2 py-1 bg-slate-100 rounded text-xs font-bold"><?php echo e(ucfirst($p->method)); ?></span></td>
                <td class="py-3 text-right font-bold text-emerald-600"><?php echo e(currency_symbol()); ?><?php echo e(number_format($p->amount, 2)); ?></td>
                <td class="py-3 text-right space-x-2">
                    <a href="<?php echo e(route('payments.show', $p)); ?>" class="text-blue-600 font-semibold">View Receipt</a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="py-8 text-center text-slate-500">No payments recorded yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-4"><?php echo e($payments->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/payments/index.blade.php ENDPATH**/ ?>