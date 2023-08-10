<div class="row">
    <?php if($ObservationOpen){
    foreach ($ObservationOpen as $key => $ObservationOpen_value) {?>
    <div class="col-md-6 mb-4 gcobseritem gcobseritem<?php echo e($ObservationOpen_value->ob_id); ?>">
      <div class="card riskpotentiallevel<?php echo e($ObservationOpen_value->riskpotentiallevel); ?>">
        <div class="gcspaction">
          
                  <?php if($ObservationOpen_value->deleted_at==''): ?>
                  <?php if((($cuser->hasRole('Super Admin') || $cuser->can('Observations Edit')))): ?> 
                  <?php if($ObservationOpen_value->status==1 || $ObservationOpen_value->status==2): ?>
                  <a href="<?php echo e(route('observationedit',['id'=>$ObservationOpen_value->ob_id])); ?>" class="ml-1 observationedit"><i class="fa fa-edit"></i></a> <?php endif; ?> <?php endif; ?>
                  <?php if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete')))): ?> <a  href="<?php echo e(route('observationdelete',['id'=>$ObservationOpen_value->ob_id])); ?>" class="ml-1 observationdelete"><i class="fa fa-trash"></i></a> <?php endif; ?>
                  <?php else: ?>
                  <?php if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete')))): ?> <a title="<?php echo e(__('Permanent delete')); ?>" href="<?php echo e(route('observationdelete',['id'=>$ObservationOpen_value->ob_id])); ?>" class="ml-1 observationdelete"><i class="fa fa-trash"></i></a>
                  <?php endif; ?>
                  <?php if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete')))): ?> <a title="<?php echo e(__('Restaurar')); ?>"  href="<?php echo e(route('observationrestore',['id'=>$ObservationOpen_value->ob_id])); ?>" class="ml-1 observationrestore"><i class="fa fa-trash-restore-alt"></i></a> <?php endif; ?>
                  <?php endif; ?>

                  
        </div>
        <div class="card-body gcspobservationdetails<?php echo e($ObservationOpen_value->deleted_at); ?>" data-href="<?php echo e(route('observationdetails',['id'=>$ObservationOpen_value->ob_id])); ?>"> <span class="d-flex gc-observsntitle"><?php echo e($ObservationOpen_value->category_name); ?> - <?php echo e($ObservationOpen_value->ob_srno); ?></span> <span class="d-flex"><?php echo e(date('d M, Y D h:ia',strtotime($ObservationOpen_value->obdatetime))); ?></span> <span class="d-flex"><?php echo e(($ObservationOpen_value->site_name)?$ObservationOpen_value->site_name:$ObservationOpen_value->ob_describethelocation); ?></span>
          <p class="card-text"><?php echo e(substr($ObservationOpen_value->description,0,57)); ?>...</p>
          <div class="gc-observsntitle-userdtl clearfix">
            <div class="gc-observsntitle-nametag"> <?php if($ObservationOpen_value->listing_type!=1): ?><span class="d-flex">By:<?php echo e(($ObservationOpen_value->ob_fullname)?$ObservationOpen_value->ob_fullname:$ObservationOpen_value->name); ?> (ID: <?php echo e(($ObservationOpen_value->ob_empid)?$ObservationOpen_value->ob_empid:$ObservationOpen_value->empid); ?>)</span><?php endif; ?> <span class="d-flex"><?php echo e(date('d M, Y D h:ia',strtotime($ObservationOpen_value->created_at))); ?></span> </div>
            <!-- <div class="gc-observsntitle-subtag">
              <label for="tag">0 of 1 <?php echo e(__('Closed')); ?></label>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <?php } } ?>
</div><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/observations/observationsajax.blade.php ENDPATH**/ ?>