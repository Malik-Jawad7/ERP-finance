<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Accounts</h1>
        <p class="text-sm text-slate-500 mt-1">Manage bank and cash accounts</p>
    </div>
    <div class="flex gap-2">
        <form action="<?php echo e(route('accounts.destroyAll')); ?>" method="POST" onsubmit="return confirm('Delete ALL accounts?');">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="<?php echo e(route('accounts.create')); ?>" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Account
        </a>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-2xl p-6 border shadow-sm hover:shadow-md transition">
        <div class="flex justify-between items-start mb-4">
            <div class="h-10 w-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 font-bold text-lg"><?php echo e(substr($a->name, 0, 1)); ?></div>
            <span class="px-2 py-1 bg-slate-100 text-xs rounded-lg text-slate-600 font-semibold"><?php echo e(ucfirst($a->type)); ?></span>
        </div>
        <h3 class="font-bold text-slate-900 text-lg"><?php echo e($a->name); ?></h3>
        <p class="text-xs text-slate-500 mb-4"><?php echo e($a->account_number ?? 'No account number'); ?></p>
        <div class="pt-4 border-t flex justify-between items-center">
            <div><p class="text-xs text-slate-400">Balance</p><p class="text-xl font-extrabold text-slate-800">$<?php echo e(number_format($a->balance, 2)); ?></p></div>
            <div class="space-x-2">
                <a href="<?php echo e(route('accounts.edit', $a)); ?>" class="text-blue-600 text-sm font-semibold hover:underline">Edit</a>
                <form action="<?php echo e(route('accounts.destroy', $a)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-rose-600 text-sm font-semibold hover:underline">Delete</button></form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full py-8 text-center text-slate-500 bg-white rounded-2xl border">No accounts found.</div>
    <?php endif; ?>
</div>
<div class="mt-6"><?php echo e($accounts->links()); ?></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/accounts/index.blade.php ENDPATH**/ ?>