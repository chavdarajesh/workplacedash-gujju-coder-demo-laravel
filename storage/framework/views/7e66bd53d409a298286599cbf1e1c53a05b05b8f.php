<?php $__env->startSection('content'); ?>
<div class="gcspfullpagewapper">
<table class="table gcspmaintable" style="max-width: 60%;">
  <thead>
    <tr>      
      <th scope="col" class="border-top-0"><?php echo e(__('Name')); ?></th>
      <th scope="col" class="border-top-0"><?php echo e(__('Users')); ?></th>      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Roles as $key => $value) {?>
      <tr>      
      <td><?php echo e($value->r_name); ?>

        <?php if($cuser->can('Roles Edit')): ?>
          <a href="<?php echo e(route('rolesedit',['id'=>$value->id])); ?>" class="ml-3"><i class="fa fa-edit"></i></a>
        <?php endif; ?>
        <?php if($cuser->can('Roles Delete')): ?>
          <a href="<?php echo e(route('rolesdelete',['id'=>$value->id])); ?>" class="ml-3"><i class="fa fa-trash"></i></a>
        <?php endif; ?>
      </td>
      <td><?php echo e($value->users_count); ?></td>      
    </tr>      
    <?php } ?>    
  </tbody>
</table>
<?php if($cuser->can('Roles Add')): ?>
<button type="button" onclick="window.location.href='<?php echo e(route('rolescreate')); ?>'"  class="btn btn-primary">+ <?php echo e(__('New Role')); ?></button>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/roles/roles.blade.php ENDPATH**/ ?>