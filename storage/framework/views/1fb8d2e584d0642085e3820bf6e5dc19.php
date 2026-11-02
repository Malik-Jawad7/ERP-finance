<?php $__env->startSection("content"); ?>
<div class="max-w-3xl mx-auto px-4">
    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <a href="<?php echo e(route('payments.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back to Payments</a>
        <button onclick="window.print()" class="w-full sm:w-auto bg-brand-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Receipt
        </button>
    </div>

    <!-- Receipt Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-10" id="receipt-content">
        
        <!-- Header (Logo + Receipt Info) -->
        <div class="flex flex-col sm:flex-row justify-between items-start border-b-2 border-slate-200 pb-6 mb-6 gap-4">
            <div class="w-full sm:w-auto">
                <?php $logo = \App\Models\Setting::where("key", "logo")->value("value"); ?>
                <?php if($logo): ?> 
                    <img src="<?php echo e(asset($logo)); ?>" alt="Logo" class="h-10 md:h-12 mb-2 object-contain"> 
                <?php endif; ?>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 break-words"><?php echo e(\App\Models\Setting::where('key', 'company_name')->value('value') ?? 'FinERP'); ?></h1>
                <p class="text-xs md:text-sm text-slate-500 break-words"><?php echo e(\App\Models\Setting::where('key', 'company_email')->value('value') ?? ''); ?></p>
            </div>
            <div class="w-full sm:w-auto text-left sm:text-right">
                <h2 class="text-base md:text-lg font-bold text-emerald-600 uppercase">Payment Receipt</h2>
                <p class="text-sm text-slate-700 font-mono font-bold break-all"><?php echo e($payment->receipt_no); ?></p>
                <p class="text-xs md:text-sm text-slate-500"><?php echo e($payment->paid_at->format('M d, Y')); ?></p>
            </div>
        </div>

        <!-- Client Info & Payment Method -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-6">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Received From</p>
                <p class="font-bold text-slate-900 text-sm md:text-base break-words"><?php echo e($payment->invoice->client->name ?? 'N/A'); ?></p>
                <p class="text-xs md:text-sm text-slate-600 break-words"><?php echo e($payment->invoice->client->email ?? ''); ?></p>
                <p class="text-xs md:text-sm text-slate-600 break-words"><?php echo e($payment->invoice->client->company ?? ''); ?></p>
            </div>
            <div>
                <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Payment Method</p>
                <p class="font-bold text-slate-900 text-sm md:text-base"><?php echo e(ucfirst(str_replace('_', ' ', $payment->method))); ?></p>
                <?php if($payment->reference): ?> 
                    <p class="text-xs md:text-sm text-slate-600 break-all">Ref: <?php echo e($payment->reference); ?></p> 
                <?php endif; ?>
            </div>
        </div>

        <!-- Amount (Highlighted) -->
        <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-4 md:p-6 mb-6">
            <p class="text-xs md:text-sm text-emerald-700 font-semibold mb-1">Amount Received</p>
            <p class="text-2xl md:text-4xl font-black text-emerald-700 break-all"><?php echo e(currency_symbol()); ?><?php echo e(number_format($payment->amount, 2)); ?></p>
            <p class="text-xs md:text-sm text-emerald-600 mt-1">For Invoice: <strong><?php echo e($payment->invoice->invoice_no); ?></strong></p>
        </div>

        <!-- Notes -->
        <?php if($payment->notes): ?>
        <div class="mb-6">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase mb-1">Notes</p>
            <p class="text-xs md:text-sm text-slate-700 break-words"><?php echo e($payment->notes); ?></p>
        </div>
        <?php endif; ?>

        <!-- Footer (Signature) -->
        <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6">
            <div class="text-[10px] md:text-xs text-slate-500">
                <p>This is a computer-generated receipt.</p>
                <p>Generated on: <?php echo e(now()->format('M d, Y H:i')); ?></p>
            </div>
            <div class="text-center w-full sm:w-auto">
                <div class="border-t-2 border-slate-400 w-40 mx-auto sm:mx-0 mb-1"></div>
                <p class="text-[10px] md:text-xs text-slate-600">Authorized Signature</p>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body * { visibility: hidden; }
    #receipt-content, #receipt-content * { visibility: visible; }
    #receipt-content { 
        position: absolute; 
        left: 0; 
        top: 0; 
        width: 100%; 
        box-shadow: none !important;
        border: none !important;
        padding: 20px !important;
    }
    .bg-emerald-50 { background: #ecfdf5 !important; -webkit-print-color-adjust: exact; }
    .text-emerald-700 { color: #047857 !important; }
    .border-emerald-200 { border-color: #a7f3d0 !important; }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/payments/show.blade.php ENDPATH**/ ?>