<div class="modal fade" id="Auditcreatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Schedule audit')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="auditsstore" action="<?php echo e(route('auditsstore')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1"><?php echo e(__('Audit Name')); ?><span class="required">*</span></label>
                        <select required  name="adm_atm_id" class="form-control"  >
                            <?php echo GetAuditTemplateDropDown(); ?>                                                                                   
                        </select>
                    </div>
                </div>        
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1"><?php echo e(__('Select Site(s)')); ?><span class="required">*</span></label>
                        <select required class="site_id2 adm_site_id_change" data-formtype="add" name="adm_site_id">
                            <?php echo GetSiteDropDown(); ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-6">                
                    <div class="form-group gcsptreeviewwapepe adm_site_id_replace_html">
                        <label for="exampleInputEmail1"><?php echo e(__('Select Auditor')); ?><span class="required">*</span></label>
                        <select required name="adm_auditor" class="form-control"  >
                            <option value=""><?php echo e(__('Select name')); ?></option>
                        </select>
                    </div>                
                </div>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1"><?php echo e(__('Frequency')); ?><span class="required">*</span></label>
                        <select required class="form-control" name="adm_af_id">
                            <?php echo GetAuditFrequencyDropDown(); ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-6">                
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1"><?php echo e(__('Select Type')); ?><span class="required">*</span></label>
                        <select required name="adm_ac_id" class="form-control" >
                            <?php echo GetCatDropDown(4); ?>                                                                                   
                        </select>
                    </div>                
                </div>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1"><?php echo e(__('Start from')); ?><span class="required">*</span></label>
                        <input required type="text" value="" autocomplete="off" name="adm_start_from" class="form-control gcspdatepickerstart"/>
                    </div>
                </div>
                <div class="col-md-6">    
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo e(__('End on')); ?><span class="required">*</span></label>
                        <input required type="text" value="" autocomplete="off" name="adm_end_on"  class="form-control gcspdatepickerend"  />
                    </div>
                </div>    
            </div>
            <div class="modal-footer border-0">        
                <button type="submit" class="btn btn-primary m-auto"><?php echo e(__('Schedule')); ?></button>
            </div>
        </form>

      </div>
      
    </div>
  </div>
</div><?php /**PATH C:\xampp\htdocs\workplacedash\resources\views/audits/create.blade.php ENDPATH**/ ?>