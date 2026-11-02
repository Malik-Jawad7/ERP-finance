<?php $__env->startSection("content"); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
    <div><h1 class="text-2xl font-bold text-slate-900">Manage Project</h1><p class="text-sm text-slate-500 mt-1">Add or update project details</p></div>
    <a href="<?php echo e(route('projects.index')); ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 max-w-xl">
    <form action="<?php echo e(isset($project) ? route('projects.update', $project) : route('projects.store')); ?>" method="POST" class="space-y-5">
        <?php echo csrf_field(); ?> <?php if(isset($project)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Project Name *</label><input type="text" name="name" value="<?php echo e($project->name ?? ''); ?>" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Client</label><select name="client_id" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="">-- Select --</option><?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e((isset($project) && $project->client_id == $c->id) ? 'selected' : ''); ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Budget *</label><input type="number" step="0.01" name="budget" value="<?php echo e($project->budget ?? '0'); ?>" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        <div><label class="block text-sm font-semibold text-slate-700 mb-2">Status</label><select name="status" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"><option value="pending" <?php echo e((isset($project) && $project->status == 'pending') ? 'selected' : ''); ?>>Pending</option><option value="ongoing" <?php echo e((isset($project) && $project->status == 'ongoing') ? 'selected' : ''); ?>>Ongoing</option><option value="completed" <?php echo e((isset($project) && $project->status == 'completed') ? 'selected' : ''); ?>>Completed</option></select></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label><input type="date" name="start_date" value="<?php echo e(isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
            <div><label class="block text-sm font-semibold text-slate-700 mb-2">End Date</label><input type="date" name="end_date" value="<?php echo e(isset($project) && $project->end_date ? $project->end_date->format('Y-m-d') : ''); ?>" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-brand-500 outline-none"></div>
        </div>
        <button type="submit" class="w-full sm:w-auto bg-brand-600 text-white px-6 py-3 rounded-xl shadow-md font-bold"><?php echo e(isset($project) ? 'Update' : 'Save'); ?> Project</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/projects/create.blade.php ENDPATH**/ ?>