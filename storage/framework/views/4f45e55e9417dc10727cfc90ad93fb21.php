<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Departments</h1>
        <p class="text-sm text-slate-500 mt-1">Manage company departments</p>
    </div>
    <div class="flex gap-2">
        <form action="<?php echo e(route('departments.destroyAll')); ?>" method="POST" onsubmit="return confirm('Delete ALL departments?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="<?php echo e(route('departments.create')); ?>" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Department
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <table class="w-full text-sm text-left">
        <thead class="text-slate-500 border-b"><tr><th class="pb-3">Name</th><th class="pb-3">Code</th><th class="pb-3">Employees</th><th class="pb-3 text-right">Actions</th></tr></thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50">
                <td class="py-3 font-bold"><?php echo e($dept->name); ?></td>
                <td class="py-3 text-slate-600"><?php echo e($dept->code ?? '-'); ?></td>
                <td class="py-3 text-slate-600"><span class="bg-brand-50 text-brand-600 px-2 py-1 rounded-md text-xs font-bold"><?php echo e($dept->employees_count); ?></span></td>
                <td class="py-3 text-right space-x-2">
                    <a href="<?php echo e(route('departments.edit', $dept)); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>
                    <form action="<?php echo e(route('departments.destroy', $dept)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="4" class="py-8 text-center text-slate-500">No departments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-4"><?php echo e($departments->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/departments/index.blade.php ENDPATH**/ ?>