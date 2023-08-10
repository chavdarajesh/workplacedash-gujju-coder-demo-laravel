<div class="row">
  <?php if($IncidentsOpen){
    foreach ($IncidentsOpen as $key => $Incident_value) {
      ?>
      <div class="col-md-6 mb-4 gcobseritem gcobseritem<?php echo e($Incident_value->im_id); ?>">
        <div class="gcspaction"> <?php if($Incident_value->im_ratinganincident): ?> <a href="<?php echo e(route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1])); ?>" class="ml-1"><i class="fa fa-eye"></i></a> <?php endif; ?> <?php if($cuser->can('Incident Edit') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))): ?> <a href="<?php echo e(route('incidentsedit',['id'=>$Incident_value->im_id])); ?>" class="ml-1 incidentsedit"><i class="fa fa-edit"></i></a> <?php endif; ?> <?php if($cuser->can('Incident Delete') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))): ?> <a  href="<?php echo e(route('incidentsdelete',['id'=>$Incident_value->im_id])); ?>" class="ml-1 incidentsdelete"><i class="fa fa-trash"></i></a> <?php endif; ?> </div>
        <div class="card colorfatalboder colorborder<?php echo e($Incident_value->rating_type); ?>">
          <div class="card-body"> <span class="d-flex gc-observsntitle " <?php if($Incident_value->im_ratinganincident): ?> onclick="location.href='<?php echo e(route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1])); ?>';" <?php endif; ?>><?php echo e($Incident_value->category_name); ?> - <?php echo e($Incident_value->im_srno); ?></span> <span class="gc-fatal-incidents colorrating<?php echo e($Incident_value->rating_type); ?>" data-toggle="modal" data-target="#myModal<?php echo e($Incident_value->im_id); ?>">
            <?php 
            if($Incident_value->im_ratinganincident){
              echo $Incident_value->rating.' - '.$Incident_value->rating_text;
            }else{
              echo ' > '.__('Set Rating').' ';
            }
            ?>
          </span>
          <?php if($cuser->hasRole('Super Admin')){?>
            <div id="myModal<?php echo e($Incident_value->im_id); ?>" class="modal fade" role="dialog"> <?php echo $__env->make('incidents.ratingpopup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
          <?php } ?>
          <div <?php if($Incident_value->im_ratinganincident): ?> onclick="location.href='<?php echo e(route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1])); ?>';" <?php endif; ?> >
            <div class="gc-incident-carddtl"> <span class="d-flex"><?php echo e(date('d M, Y D h:ia',strtotime($Incident_value->im_datetime))); ?></span> <span class="d-flex"><?php echo e($Incident_value->site_name); ?></span>
              <p class="card-text"><?php echo e(substr($Incident_value->im_description,0,57)); ?>...</p>
            </div>
            <div class="gc-observsntitle-userdtl clearfix">
              <div class="gc-observsntitle-nametag"> <span class="d-flex"><?php echo e(__('By')); ?>:<?php echo e($Incident_value->name); ?></span> <span class="d-flex"><?php echo e(date('d M, Y D h:ia',strtotime($Incident_value->created_at))); ?></span> </div>
              <div class="gc-observsntitle-subtag">
                <label for="tag"><?php echo e(__('Open')); ?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } } ?>
</div><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/incidents/incidentsajax.blade.php ENDPATH**/ ?>