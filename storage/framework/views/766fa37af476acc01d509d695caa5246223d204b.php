
          <div class="row">
            <?php if($ActionsOpen): ?>
            <?php $__currentLoopData = $ActionsOpen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ActionsOpen_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $mt=$ActionsOpen_item->am_module_type;
              $description=$srno=$category_name=$site_name=$GetActionResponsibility=$Whendatetime=$GetRiskLevel=$shifts=$colorborder='';              
              if($mt==1){
                  $description=$ActionsOpen_item->ob_description;
                  $srno=$ActionsOpen_item->ob_srno;
                  $category_name=$ActionsOpen_item->category_name;
                  $category_namePopup='<p><b>'.__('Near Miss Type').':</b> '.$ActionsOpen_item->category_name.'</p>';
                  $site_name=$ActionsOpen_item->site_name;
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                  $Whendatetime=$ActionsOpen_item->obdatetime;
                  $GetRiskLevel=$ActionsOpen_item->riskpotentiallevel;
                  $popuptitle=__('Near Miss Details').":";
                  $colorborder='riskpotentiallevel'.$ActionsOpen_item->riskpotentiallevel;
              }
              if($mt==2){
                  $description=$ActionsOpen_item->im_description;
                  $srno=$ActionsOpen_item->im_srno;                  
                  $category_name=$ActionsOpen_item->im_category_name;
                  $category_namePopup='<p><b>'.__('Incident Type').':</b> '.$ActionsOpen_item->im_category_name.'</p>';
                  $site_name=$ActionsOpen_item->im_site_name;
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                  $Whendatetime=$ActionsOpen_item->im_datetime;
                  $shifts=$ActionsOpen_item->sm_name;
                  $popuptitle=__('Incident Details').":";
                  $GetRiskLevel=$ActionsOpen_item->rating_text;
                  $colorborder='colorborder'.$ActionsOpen_item->rating_type;
              }

              if($mt==4){
                  $description=$ActionsOpen_item->im_description;
                  $srno=$ActionsOpen_item->adm_srno;                  
                  $category_name=$ActionsOpen_item->audit_category_name;
                  $category_namePopup='<p><b>'.__('Audit Type').':</b> '.$ActionsOpen_item->audit_category_name.'</p>';
                  $site_name=$ActionsOpen_item->auditsitename;    
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);                
                  $Whendatetime=$ActionsOpen_item->adm_start_from;                  
                  $popuptitle=__('Audit Details').":";                  
                  $colorborder='colorborder'.$ActionsOpen_item->adm_status;
              }

            ?>
            <div class="col-md-6 mb-4 gcobseritem gcactionitem<?php echo e($ActionsOpen_item->am_id); ?>">
            <div class="gcspaction">
                <a href="<?php echo e(route('actionsedit',['id'=>$ActionsOpen_item->am_id])); ?>" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
                <a href="<?php echo e(route('actionsdelete',['id'=>$ActionsOpen_item->am_id])); ?>" class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal<?php echo e($ActionsOpen_item->am_id); ?>" class="ml-1"><i class="fa fa-eye"></i></a>
              </div>

              <div id="myModal<?php echo e($ActionsOpen_item->am_id); ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title"><?php echo e($popuptitle); ?> <?php echo e($srno); ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>                      
                    </div>
                    <div class="modal-body">
                      <p><b><?php echo e(__('Description')); ?>:</b> <?php echo e($description); ?></p>
                      <?php echo $category_namePopup; ?>

                      <p><b><?php echo e(__('Date & Time')); ?>:</b> <?php echo e(date('d M, Y D h:ia',strtotime($Whendatetime))); ?></p>
                      <?php if($GetRiskLevel): ?>
                      <p><b><?php echo e(__('Risk Potential Level')); ?>:</b> <?php echo e(GetRiskLevel($GetRiskLevel)); ?></p>
                      <?php endif; ?>

                      <?php if($mt==2): ?>
                        <?php if($ActionsOpen_item->rating): ?>
                        <p><b><?php echo e(__('Rating')); ?>:</b> <?php echo e($ActionsOpen_item->rating); ?></p>
                        <?php endif; ?>
                        <?php if($ActionsOpen_item->severity): ?>
                        <p><b><?php echo e(__('Severity')); ?>:</b> <?php echo e($ActionsOpen_item->severity); ?></p>
                        <?php endif; ?>
                        <?php if($ActionsOpen_item->likelihood): ?>
                        <p><b><?php echo e(__('Likelihood')); ?>:</b> <?php echo e($ActionsOpen_item->likelihood); ?></p>
                        <?php endif; ?>
                      <?php endif; ?>

                      <?php if($shifts): ?>
                      <p><b><?php echo e(__('Shift')); ?>:</b> <?php echo e($shifts); ?></p>
                      <?php endif; ?>
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="card <?php echo e($colorborder); ?>">
                <div class="card-body gcspactiondetails" data-href="<?php echo e(route('actiondetails',['id'=>$ActionsOpen_item->am_id])); ?>" >
                  <span class="d-flex gc-observsntitle"><?php echo e($category_name); ?> - <?php echo e($srno); ?></span>
                  <div class="gc-observsntitle-nametag float-none">
                    <span class="d-flex"><?php echo e($site_name); ?></span>
                  </div>
                  <span class="d-flex"><?php echo e(substr($ActionsOpen_item->am_description,0,57)); ?>...</span>
                  <div class="gc-observsntitle-nametag float-none">
                      <span class="d-flex"><?php echo e(__('By')); ?>:<?php echo e($ActionsOpen_item->name); ?></span>
                      <span class="d-flex"><?php echo e(__('Responsibility')); ?>:<?php echo e($GetActionResponsibility); ?></span>
                  </div> 
                  

                  <div class="gc-observsntitle-userdtl clearfix">    
                    <div class="gc-observsntitle-subtag float-left colorgray">
                      <label for="tag"><?php echo e(__('Due Date')); ?>: <?php echo e(date('d M, Y',strtotime($ActionsOpen_item->am_due_date))); ?></label>
                    </div> 
                    <div class="gc-observsntitle-subtag">
                      <label for="tag"><?php echo e(GetActionStatus($ActionsOpen_item->am_status)); ?></label>
                    </div> 
                  </div>      
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

          </div>
   <?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/actions/actionsajax.blade.php ENDPATH**/ ?>