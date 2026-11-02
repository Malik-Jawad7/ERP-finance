<?php $__env->startSection("content"); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Department</h1><p class="text-sm text-slate-500 mt-1">Add or update department details</p></div>
    <a href="<?php echo e(route('departments.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-xl">
    <form action="<?php echo e(isset($department) ? route('departments.update', $department) : route('departments.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?> <?php if(isset($department)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Department Name *</label><input type="text" name="name" value="<?php echo e($department->name ?? ''); ?>" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Code</label><input type="text" name="code" value="<?php echo e($department->code ?? ''); ?>" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Description</label><textarea name="description" rows="3" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><?php echo e($department->description ?? ''); ?></textarea></div>
        <button type="submit" class="w-full sm:w-auto bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold"><?php echo e(isset($department) ? 'Update' : 'Save'); ?> Department</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/departments/create.blade.php ENDPATH**/ ?>