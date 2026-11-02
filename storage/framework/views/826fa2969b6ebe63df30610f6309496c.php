<?php $__env->startSection("content"); ?>
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Record Payment</h1><p class="text-sm text-slate-500 mt-1">Enter payment details for invoice</p></div>
    <a href="<?php echo e(route('payments.index')); ?>" class="text-sm font-semibold text-slate-500">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border p-8 max-w-2xl">
    <form action="<?php echo e(route('payments.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Select Invoice *</label>
            <select name="invoice_id" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none">
                <option value="">-- Choose Invoice --</option>
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($inv->id); ?>" <?php echo e($selectedInvoice == $inv->id ? 'selected' : ''); ?>>
                        <?php echo e($inv->invoice_no); ?> - <?php echo e($inv->client->name ?? ''); ?> - <?php echo e(currency_symbol()); ?><?php echo e(number_format($inv->total, 2)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Amount (<?php echo e(currency_symbol()); ?>) *</label>
                <input type="number" step="0.01" name="amount" required class="w-full border p-3 rounded-xl">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Method *</label>
                <select name="method" class="w-full border p-3 rounded-xl">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="cheque">Cheque</option>
                    <option value="online">Online</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Date *</label>
                <input type="date" name="paid_at" value="<?php echo e(date('Y-m-d')); ?>" required class="w-full border p-3 rounded-xl">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Reference # (optional)</label>
                <input type="text" name="reference" class="w-full border p-3 rounded-xl" placeholder="Cheque/TXN ID">
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Notes</label>
            <textarea name="notes" rows="2" class="w-full border p-3 rounded-xl"></textarea>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold">Save & Generate Receipt</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/payments/create.blade.php ENDPATH**/ ?>