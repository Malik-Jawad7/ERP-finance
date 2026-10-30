<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Expenses</h1>
        <p class="text-sm text-slate-500 mt-1">Track spending</p>
    </div>
    <div class="flex gap-2">
        <form action="<?php echo e(route('expenses.destroyAll')); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete ALL expenses?');">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-lg text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="<?php echo e(route('expenses.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition-all">+ Add Expense</a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="table-responsive"><table class="w-full text-sm text-left min-w-[600px]">
        <thead class="text-slate-500 border-b"><tr><th class="pb-3">Title</th><th class="pb-3">Category</th><th class="pb-3 text-right">Amount</th><th class="pb-3 text-right">Actions</th></tr></thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold text-slate-800"><?php echo e($e->title); ?></td>
                <td class="py-3 text-slate-600"><?php echo e(ucfirst($e->category)); ?></td>
                <td class="py-3 text-right font-bold text-red-600">-$<?php echo e(number_format($e->amount,2)); ?></td>
                <td class="py-3 text-right space-x-3">
                    <a href="<?php echo e(route('expenses.edit', $e)); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>
                    <form action="<?php echo e(route('expenses.destroy', $e)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete <?php echo e($e->title); ?>?');">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-rose-600 font-medium hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="4" class="py-8 text-center text-slate-500">No expenses found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table></div>
</div>
<div class="mt-4"><?php echo e($expenses->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/expenses/index.blade.php ENDPATH**/ ?>