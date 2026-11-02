<?php $__env->startSection("content"); ?>
<div class="max-w-3xl mx-auto px-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <a href="<?php echo e(route('expenses.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back to Expenses</a>
        <button onclick="window.print()" class="w-full sm:w-auto bg-rose-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Voucher
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10" id="voucher-content">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start border-b-2 border-slate-200 pb-6 mb-6 gap-4">
            <div>
                <?php $logo = \App\Models\Setting::where("key", "logo")->value("value"); ?>
                <?php if($logo): ?> <img src="<?php echo e(asset($logo)); ?>" alt="Logo" class="h-10 md:h-12 mb-2 object-contain"> <?php endif; ?>
                <h1 class="text-xl md:text-2xl font-black text-slate-900"><?php echo e(\App\Models\Setting::where('key', 'company_name')->value('value') ?? 'FinERP'); ?></h1>
                <p class="text-xs md:text-sm text-slate-500"><?php echo e(\App\Models\Setting::where('key', 'company_email')->value('value') ?? ''); ?></p>
            </div>
            <div class="text-left sm:text-right">
                <h2 class="text-base md:text-lg font-bold text-rose-600 uppercase">Expense Voucher</h2>
                <p class="text-sm text-slate-700 font-mono font-bold">EXP-<?php echo e(str_pad($expense->id, 5, '0', STR_PAD_LEFT)); ?></p>
                <p class="text-xs md:text-sm text-slate-500"><?php echo e($expense->spent_at->format('M d, Y')); ?></p>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-6">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Expense For</p>
                <p class="font-bold text-slate-900 text-base md:text-lg"><?php echo e($expense->title); ?></p>
                <p class="text-xs md:text-sm text-slate-600 mt-1">Category: <?php echo e(ucfirst($expense->category)); ?></p>
            </div>
            <div>
                <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Recorded By</p>
                <p class="font-bold text-slate-900 text-sm md:text-base"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                <p class="text-xs md:text-sm text-slate-600"><?php echo e(now()->format('M d, Y H:i')); ?></p>
            </div>
        </div>

        <!-- Amount -->
        <div class="bg-rose-50 border-2 border-rose-200 rounded-xl p-4 md:p-6 mb-6">
            <p class="text-xs md:text-sm text-rose-700 font-semibold mb-1">Total Amount Paid</p>
            <p class="text-2xl md:text-4xl font-black text-rose-700 break-all"><?php echo e(currency_symbol()); ?><?php echo e(number_format($expense->amount, 2)); ?></p>
        </div>

        <!-- Notes -->
        <?php if($expense->notes): ?>
        <div class="mb-6">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Notes</p>
            <p class="text-xs md:text-sm text-slate-700"><?php echo e($expense->notes); ?></p>
        </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6">
            <div class="text-[10px] md:text-xs text-slate-500">
                <p>This is a computer-generated voucher.</p>
                <p>Generated on: <?php echo e(now()->format('M d, Y H:i')); ?></p>
            </div>
            <div class="text-center">
                <div class="border-t-2 border-slate-400 w-40 mb-1"></div>
                <p class="text-[10px] md:text-xs text-slate-600">Authorized Signature</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #voucher-content, #voucher-content * { visibility: visible; }
    #voucher-content { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; border: none !important; padding: 20px !important; }
    .bg-rose-50 { background: #fef2f2 !important; -webkit-print-color-adjust: exact; }
    .text-rose-700 { color: #b91c1c !important; }
    .border-rose-200 { border-color: #fecaca !important; }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/expenses/show.blade.php ENDPATH**/ ?>