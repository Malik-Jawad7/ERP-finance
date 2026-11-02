<?php $__env->startSection("content"); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Employee</h1><p class="text-sm text-slate-500 mt-1">Add or update employee details</p></div>
    <a href="<?php echo e(route('employees.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-xl">
    <form action="<?php echo e(isset($employee) ? route('employees.update', $employee) : route('employees.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?> <?php if(isset($employee)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Full Name *</label><input type="text" name="name" value="<?php echo e($employee->name ?? ''); ?>" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Email</label><input type="email" name="email" value="<?php echo e($employee->email ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label><input type="text" name="phone" value="<?php echo e($employee->phone ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Designation</label><input type="text" name="designation" value="<?php echo e($employee->designation ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Department</label><select name="department_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($d->id); ?>" <?php echo e((isset($employee) && $employee->department_id == $d->id) ? 'selected' : ''); ?>><?php echo e($d->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status</label><select name="status" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="active" <?php echo e((isset($employee) && $employee->status == 'active') ? 'selected' : ''); ?>>Active</option><option value="inactive" <?php echo e((isset($employee) && $employee->status == 'inactive') ? 'selected' : ''); ?>>Inactive</option></select></div>
        <button type="submit" class="w-full sm:w-auto bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold"><?php echo e(isset($employee) ? 'Update' : 'Save'); ?> Employee</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/employees/create.blade.php ENDPATH**/ ?>