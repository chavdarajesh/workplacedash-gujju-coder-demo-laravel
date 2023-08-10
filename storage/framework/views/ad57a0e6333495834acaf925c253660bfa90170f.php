 
<?php $__env->startSection('content'); ?>
<div class="pt-3">
  
<ul class="nav nav-tabs">
  <li class="nav-item ml-5">
    <a class="nav-link active" href="javascript:void(0);"><?php echo e(__('Audit-wise')); ?></a>
  </li>  
  <li class="nav-item">
    <a class="nav-link" href="<?php echo e(route('sitewise')); ?>"><?php echo e(__('Site-wise')); ?></a>
  </li>  
</ul>
</div>
<div class="gcspfullpagewapper">

    <div class="gc-observsntitle-wrap ">
        <div class="row">
            <div class="col-md-12">
                <div class="gc-obsrvtbsec">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item 1" role="presentation"> <a class="nav-link active getauditbystatus" data-value="1"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="open" aria-selected="true"> <?php echo e(__('Scheduled')); ?>(<span><?php echo e($AuditsScheduled); ?></span>) </a> </li>
                        <li class="nav-item 2" role="presentation"> <a class="nav-link getauditbystatus" data-value="2"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="overdue" aria-selected="false"><?php echo e(__('In Progress')); ?>(<span><?php echo e($AuditsInprogress); ?></span>) </a> </li>
                        <li class="nav-item 3" role="presentation"> <a class="nav-link getauditbystatus" data-value="3"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="progress" aria-selected="false"><?php echo e(__('Overdue')); ?>(<span><?php echo e($AuditsOverdue); ?></span>)</a> </li>
                        <li class="nav-item 4" role="presentation"> <a class="nav-link getauditbystatus" data-value="4"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="completed" aria-selected="false"><?php echo e(__('Completed')); ?>(<span><?php echo e($AuditsCompleted); ?></span>)</a> </li>
                        <li class="nav-item 5" role="presentation"> <a class="nav-link getauditbystatus" data-value="5" data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="profile" aria-selected="false"><?php echo e(__('Approved')); ?>(<span><?php echo e($AuditsApproved); ?></span>)</a> </li>
                    </ul>
                </div>
                <div class="gc-observsntitle-rightlbl clearfix">
                    <ul>
                        <li><a href="javascript:void(0);" class="filtersearch"><i class="fa fa-search gc-search " aria-hidden="true"></i><?php echo e(__('Search by Keywords')); ?></a></li>
                        <li><a href="javascript:void(0);" class="filternormal"><i class="fa fa-filter gc-excel " aria-hidden="true"></i><?php echo e(__('Filter by')); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="searchaudittop">
                <form id="auditsitewisesearch" action="<?php echo e(route('postauditwise')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="1">    
                    <input type="text" required name="searchbykeywords" placeholder="<?php echo e(__('Search by Keywords')); ?>" class="form-control">
                    <button type="submit" class="btn btn-primary ml-2"><?php echo e(__('Search')); ?></button><span class="searchaudittopclose">×</span>
                </form>
            </div>

            <div class="audittopfilter">
                <form id="auditsitewisefilter" autocomplete="off" action="<?php echo e(route('postauditwise')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="1">    
                <div class="audittopfilterinner">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label ><?php echo e(__('Frequency')); ?></label>
                                <select  class="form-control" name="adm_af_id">
                                    <?php echo GetAuditFrequencyDropDown(); ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group gcsptreeviewwapepe">
                                <label for="exampleInputEmail1"><?php echo e(__('Select Site(s)')); ?></label>
                                <select class="site_id3" data-formtype="add" name="adm_site_id">
                                    <?php echo GetSiteDropDown(); ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label ><?php echo e(__('Audit Type')); ?></label>
                                <select name="adm_ac_id" class="form-control" >
                                    <?php echo GetCatDropDown(4); ?>                                                                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label ><?php echo e(__('Date Range')); ?></label>
                                <input autocomplete="off" type="text" value="" class="gcspdaterangepicker form-control" name="filterdate" placeholder="<?php echo e(__('Select date & time')); ?>">
                            </div>
                        </div>
                    </div>    
                </div> 
                <div class="d-inline-block audittopfilterinner2">                       
                    <button type="submit" class="btn btn-primary ml-2"><?php echo e(__('Filtrar')); ?></button><span class="searchaudittopclose">×</span>
                </div>
                </form>
            </div>  
    <div class="tab-content gc-tabs" id="myTabContent">
        <div class="tab-pane fade active show" id="gc-audtis" role="tabpanel" aria-labelledby="gc-observsnopen-tab"> 
            <div class="gcspauditlistresponce gcspajaxresponcesitevise">
                <?php echo view('audits.audits_list',compact('Audits')); ?>

            </div>
        </div>
    </div>        

</div>
<?php echo $__env->make('audits.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="modal fade" id="AuditEditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>    
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/audits/audits.blade.php ENDPATH**/ ?>