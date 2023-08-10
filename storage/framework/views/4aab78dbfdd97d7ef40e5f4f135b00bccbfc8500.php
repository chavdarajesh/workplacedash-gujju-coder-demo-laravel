<div class="gc-form-title">
         <h5><?php echo e(__('Reports an Incident')); ?></h5>
     </div>
     <form id="incidentsstore" action="<?php echo e(route('incidentsstore')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group gcsptreeviewwapepe">
                    <label for="exampleInputEmail1">1. <?php echo e(__('Select incident type')); ?><span class="required">*</span></label>
                    <select  name="im_ic_id" class="oc_id1"  >                    
                        <?php echo GetCatDropDown(2); ?>

                    </select>                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">2. <?php echo e(__('Describe your incident in few words')); ?>...<span class="required">*</span></label>
                    <textarea class="form-control" name="im_description" ><?php echo e(old('im_description')); ?></textarea>                
                </div>
            </div>    
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group gcsptreeviewwapepe">
                    <label for="exampleInputEmail1">3. <?php echo e(__('Whare? name the location, area, site')); ?>...<span class="required">*</span></label>
                    <select  class="site_id1" name="im_site_id">
                        <?php echo GetSiteDropDown(); ?>

                    </select>            
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">4. <?php echo e(__('Select Shift')); ?><span class="required">*</span></label>
                    <select name="im_shift" required class="form-control" >
                        <option><?php echo e(__('Select')); ?></option>
                        <?php if(count($Shifts)){
                            foreach ($Shifts as $key => $ShiftsValue) {?>
                             <option value="<?php echo e($ShiftsValue->sm_id); ?>"><?php echo e($ShiftsValue->sm_name); ?></option>
                         <?php   }
                     } ?>                    
                 </select>                
             </div>
         </div>    
     </div>

     <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">5. <?php echo e(__('When? select date and time')); ?><span class="required">*</span></label>
                <input required type="datetime-local" value="<?php echo e(old('im_datetime')); ?>" name="im_datetime" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control"  />
            </div>
        </div>
        <div class="col-md-12">

            <div class="form-group gc-uploadbtn">
                <label for="exampleInputEmail1">6. <?php echo e(__('Upload images or attach files')); ?></label>
                <div id="newfiletypeadded"></div>
                <div class="gcspuploadedwpr">
                 <label for="file-upload" class="custom-file-upload d-block">
                     <img src="<?php echo e(asset('images/attached-file.png')); ?>" alt="">
                 </label>
                 <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
             </div>    
             <div id="fileinstedt"></div>
             <div id="fileinstedtimg"></div>
         </div> 


         
     </div>    
    </div>

    <button type="submit" class="btn btn-primary"><?php echo e(__('Submit')); ?></button> 
    </form><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/incidents/create.blade.php ENDPATH**/ ?>