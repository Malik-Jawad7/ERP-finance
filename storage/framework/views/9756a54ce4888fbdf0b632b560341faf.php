<?php $__env->startSection("content"); ?>
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Employees</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your workforce</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
        <form action="<?php echo e(route('employees.destroyAll')); ?>" method="POST" onsubmit="return confirm('Delete ALL employees?')" class="w-full sm:w-auto">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="w-full sm:w-auto bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2.5 rounded-xl text-sm font-semibold border border-rose-200 transition-all">Delete All</button>
        </form>
        <a href="<?php echo e(route('employees.create')); ?>" class="w-full sm:w-auto justify-center bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Employee
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
    <div class="table-responsive">
        <table class="w-full text-sm text-left min-w-[600px]">
            <thead class="text-slate-500 border-b">
                <tr><th class="pb-3 px-2">Name</th><th class="pb-3 px-2">Department</th><th class="pb-3 px-2">Designation</th><th class="pb-3 px-2">Status</th><th class="pb-3 px-2 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-2 font-bold text-slate-800"><?php echo e($emp->name); ?></td>
                    <td class="py-3 px-2 text-slate-600"><?php echo e($emp->department->name ?? '-'); ?></td>
                    <td class="py-3 px-2 text-slate-600"><?php echo e($emp->designation ?? '-'); ?></td>
                    <td class="py-3 px-2"><span class="bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md text-xs font-bold"><?php echo e(ucfirst($emp->status)); ?></span></td>
                    <td class="py-3 px-2 text-right space-x-2 whitespace-nowrap">
                        <a href="<?php echo e(route('employees.edit', $emp)); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="<?php echo e(route('employees.destroy', $emp)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-rose-600 font-medium hover:underline">Delete</button></form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="py-8 text-center text-slate-500">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4"><?php echo e($employees->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/employees/index.blade.php ENDPATH**/ ?>