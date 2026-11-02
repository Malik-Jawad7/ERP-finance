<?php $__env->startSection("content"); ?>
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Vendor</h1><p class="text-sm text-slate-500 mt-1">Add or update supplier details</p></div>
    <a href="<?php echo e(route('vendors.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-xl">
    <form action="<?php echo e(isset($vendor) ? route('vendors.update', $vendor) : route('vendors.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?>
        <?php if(isset($vendor)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Vendor Name *</label><input type="text" name="name" value="<?php echo e($vendor->name ?? ''); ?>" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Company</label><input type="text" name="company" value="<?php echo e($vendor->company ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Email</label><input type="email" name="email" value="<?php echo e($vendor->email ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label><input type="text" name="phone" value="<?php echo e($vendor->phone ?? ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold"><?php echo e(isset($vendor) ? 'Update' : 'Save'); ?> Vendor</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/vendors/create.blade.php ENDPATH**/ ?>