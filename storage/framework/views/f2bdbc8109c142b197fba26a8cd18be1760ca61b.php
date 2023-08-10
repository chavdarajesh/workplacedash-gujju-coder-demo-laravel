 <?php $__env->startSection('content'); ?>
<div class="mainmidsec">
  <div class="innerleftpanel">
    <div class="gc-observsntitle-wrap ">
      <div class="row">
        <div class="col-md-12">
          <div class="gc-obsrvtbsec">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation"> <a class="nav-link active incidentslist" data-value="1" id="gc-incidentopen-tab" data-toggle="tab" href="#gc-incidentopen" role="tab" aria-controls="open" aria-selected="true"><?php echo e(__('Open')); ?></a> </li>
              <li class="nav-item" role="presentation"> <a class="nav-link incidentslist" data-value="0" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-incidentopen" role="tab" aria-controls="profile" aria-selected="false"><?php echo e(__('Closed')); ?></a> </li>
            </ul>
          </div>
          <div class="gc-observsntitle-rightlbl clearfix">
            <ul>
              <li>
                <input type="radio" value="0" name="riskpotentiallevel" id="riskpotentiallevel0" checked="checked">
                <label for="riskpotentiallevel1" class="riskpotentiallevelinput1"><i class="fa fa-circle minor" data-value="1" aria-hidden="true"></i><?php echo e(__('Minor')); ?></label>
                <input type="radio" value="1" name="riskpotentiallevel" id="riskpotentiallevel1" class="incidentslist"> </li>
              <li>
                <label for="riskpotentiallevel2" class="riskpotentiallevelinput2"><i class="fa fa-circle serious" data-value="2" aria-hidden="true"></i><?php echo e(__('Serious')); ?></label>
                <input type="radio" value="2" name="riskpotentiallevel" id="riskpotentiallevel2" class="incidentslist"> </li>
              <li>
                <label for="riskpotentiallevel3" class="riskpotentiallevelinput3"><i class="fa fa-circle fatal" data-value="3" aria-hidden="true"></i><?php echo e(__('Fatal')); ?></label>
                <input type="radio" value="3" name="riskpotentiallevel" id="riskpotentiallevel3" class="incidentslist"> </li>
              <li><a href="#"><i class="fa fa-file-excel gc-excel" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-search gc-search" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-content gc-tabs" id="myTabContent">
      <div class="tab-pane fade show active" id="gc-incidentopen" role="tabpanel" aria-labelledby="gc-incidentopen-tab">
        <div class="row">
          <div class="col-md-4">
            <div classs="gc-obserfilter gc-calendricon">
              <lable><?php echo e(__('Filter by date')); ?></lable>
              <br>
              <input type="text" name="filterdate" autocomplete="off" value="" class=" gcspdaterangepicker gc-picker incidentslist" placeholder="<?php echo e(date('d M, Y')); ?>">
              <input type="hidden" name="ifchaneddate"> <i class="fa fa-calendar gc-calendricon" aria-hidden="true"></i> </div>
          </div>
          <div class="col-md-4">
            <div classs="gc-obserfilter">
              <div class="form-group gcsptreeviewwapepe">
                <label ><?php echo e(__('Category')); ?></label>
                <select name="filtercat" class="oc_id incidentslist"> <?php echo GetCatDropDown(2,$filtercat); ?> </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div classs="gc-obserfilter">
              <div class="form-group gcsptreeviewwapepe">
                <label ><?php echo e(__('Sites')); ?></label>
                <select name="filtersite" class="form-control site_id incidentslist" id="exampleFormControlSelect1"> <?php echo GetSiteDropDown(null,$filtersite); ?> </select>
              </div>
            </div>
          </div>
          <div class="col-md-4 gcspfilterreset">
            <button type="reset" class="btn btn-primary"><?php echo e(__('Reset')); ?></button>
          </div>
        </div>
        <div class="gc-observation-userdtl">
          <div class="row">
            <?php if($IncidentsOpen){
                            foreach ($IncidentsOpen as $key => $Incident_value) {
                        ?>
              <div class="col-md-6 mb-4 gcobseritem gcobseritem<?php echo e($Incident_value->im_id); ?>">
                <div class="gcspaction"> <?php if($Incident_value->im_ratinganincident): ?> <a href="<?php echo e(route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1])); ?>" class="ml-1"><i class="fa fa-eye"></i></a> <?php endif; ?> <?php if($cuser->can('Incident Edit') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))): ?> <a href="<?php echo e(route('incidentsedit',['id'=>$Incident_value->im_id])); ?>" class="ml-1 incidentsedit"><i class="fa fa-edit"></i></a> <?php endif; ?> <?php if($cuser->can('Incident Delete') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))): ?> <a on href="<?php echo e(route('incidentsdelete',['id'=>$Incident_value->im_id])); ?>" class="ml-1 incidentsdelete"><i class="fa fa-trash"></i></a> <?php endif; ?> </div>
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="innnerrightpanel">
    <div class="rightpanelinnerbox"> 
      <?php if($cuser->can('Incident Add')): ?>
        <?php echo $__env->make('incidents.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>  
     </div>
  </div>
</div> <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/incidents/incidents.blade.php ENDPATH**/ ?>