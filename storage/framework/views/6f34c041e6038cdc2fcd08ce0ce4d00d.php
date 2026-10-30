<?php $__env->startSection("content"); ?>
<div class="mb-6 flex justify-between items-center">
    <div><h1 class="text-2xl font-bold text-slate-900">Add New Client</h1><p class="text-sm text-slate-500 mt-1">Enter client details to add to your database</p></div>
    <a href="<?php echo e(route('clients.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="<?php echo e(route('clients.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Client Name *</label><input type="text" name="name" required class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Company Name</label><input type="text" name="company" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label><input type="email" name="email" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label><input type="text" name="phone" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status</label><select name="status" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
        </div>
        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Save Client</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/clients/create.blade.php ENDPATH**/ ?>