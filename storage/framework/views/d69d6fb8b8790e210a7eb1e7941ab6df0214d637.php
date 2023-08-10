<div class="gc-form-title">
    <h5><?php echo e(__('Report an Near Miss')); ?></h5>
</div>
<div class="alert alert-secondary" role="alert">
        <?php echo e(__('Please note that your identity is safe - You have the option to submit this report anonymously if you do not wish to share your information. You will not be subject to disciplinary action for a Near-Miss submittal.')); ?>

    </div>
<form id="observationsstore" action="<?php echo e(route('observationsstore')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="row">

        <div class="col-md-12">
            <div class="form-check mb-3">
                <input class="form-check-input " type="checkbox" name="agree" required id="exampleRadios111" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                <?php echo e(__('I have read and understood the disclaimer.')); ?>

                </label>
            </div>
            <div class="form-group gcsptreeviewwapepe ">
                <label for="exampleInputEmail1"><?php echo e(__('Select Near Miss Type')); ?><span class="required">*</span></label>
                <select  name="oc_id" class="oc_id2 classoc_id"  >
                    <?php echo GetCatDropDown(1); ?>

                </select>
                <span class="invalid-feedback classoc_idmsg" role="alert"><strong><?php echo e(__('The Near Miss Type field is required.')); ?></strong></span>
            </div>

        </div>
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1"><?php echo e(__('Describe your near miss')); ?><span class="required">*</span></label>
                <textarea name="description"  class="form-control classdescription"><?php echo e(old('description')); ?></textarea>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Description field is required.')); ?></strong></span>
            </div>
        </div>
    </div>  <!--first row over-->

    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classsite_id">
                <label for="exampleInputEmail1"><?php echo e(__('Where? name the location, area, site')); ?>...<span class="required">*</span></label>
                <select  class="site_id2 " name="site_id" >
                    <?php echo GetSiteDropDown(); ?>

                    <option value="0"></option>
                </select>
            </div>
            <span class="invalid-feedback  mt-n2 mb-1" role="alert"><strong><?php echo e(__('Select Area field is required.')); ?></strong></span>
            <div class="form-check mb-3">
                <input class="form-check-input gcspobservationsitelist" type="checkbox" name="ob_describethelocation_check" id="exampleRadios11" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                <?php echo e(__('Unsure / do not know')); ?>

                </label>
            </div>
            <div class="form-group gcsphidediv gcspobservationsite">
                <input type="text" value="<?php echo e(old('ob_describethelocation')); ?>" name="ob_describethelocation" placeholder="<?php echo e(__('Describe the location')); ?>"  class="form-control"  />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1"><?php echo e(__('When? select date and time')); ?><span class="required">*</span></label>
                <input type="datetime" value="<?php echo e(old('obdatetime')); ?>" name="obdatetime"  class="dateclass placeholderclass gcspdatetimepicker form-control classobdatetime"  />
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Date and Time field is required.')); ?></strong></span>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations Risk potential')): ?>
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1"><?php echo e(__('Select risk potential level')); ?><span class="required">*</span></label><br />
                <div class="btn-group btn-group-toggle classriskpotentiallevel" data-toggle="buttons">
                    <label class="btn btn-secondary minorbg gc-formbtn active"> <input  type="radio" value="1" name="riskpotentiallevel" id="option1" autocomplete="off"  /> <?php echo e(__('Minor')); ?> </label>
                    <label class="btn btn-secondary seriousbg gc-formbtn"> <input value="2" type="radio" name="riskpotentiallevel" id="option2" autocomplete="off" /> <?php echo e(__('Serious')); ?> </label>
                    <label class="btn btn-secondary fatalbg gc-formbtn"> <input value="3" type="radio" name="riskpotentiallevel" id="option3" autocomplete="off" class="" /> <?php echo e(__('Fatal')); ?> </label>

                </div>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Risk potential level field is required.')); ?></strong></span>
            </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="riskpotentiallevel" value="0">
        <?php endif; ?>

        <?php if($cuser->hasRole('Super Admin') || $cuser->can('Actions Add')): ?>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Action required')); ?><span class="required">*</span></label>
                <div class="rightcheckbox classaction_required">
                    <div class="form-check">
                        <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios1" value="1"  />
                        <label class="form-check-label" for="exampleRadios1">
                            <?php echo e(__('Yes')); ?>

                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios12" value="0"  />
                        <label class="form-check-label" for="exampleRadios12">
                            <?php echo e(__('No')); ?>

                        </label>
                    </div>
                </div>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Actions field is required')); ?></strong></span>
            </div>
            <div class="form-group gcsphideactionsmain gcsphideactions p-2">
                <div class="gc-form-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><?php echo e(__('Actions')); ?>  </h5>
                        </div>
                        <div class="col-md-6 text-right pl-0">
                            <a href="javascript:void(0);" class="btn btn-primary gcspaddaction"><i class="fa fa-plus"></i> <?php echo e(__('Add Action')); ?></a>
                        </div>
                    </div>
                </div>
                <div class="actionhtmlbefore"></div>
            </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="action_required" value="0">
        <?php endif; ?>

    </div>

    <div class="row">
        <?php /*
        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
             <div id="newfiletypeadded"></div>
             <div class="gcspuploadedwpr">
                 <label for="file-upload" class="custom-file-upload">
                     <img src="{{ asset('images/attached-file.png') }}" alt="">
                 </label>
                 <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
             </div>
             <div id="fileinstedt"></div>
             <div id="fileinstedtimg"></div>
         </div>
     </div>
     <?php */?>

     <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo e(__('Make a suggestion/recommendation')); ?><span class="required">*</span></label>
            <textarea  name="Comments" class="form-control classComments"><?php echo e(old('Comments')); ?></textarea>
            <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Make a suggestion field is required.')); ?></strong></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo e(__('How would you like to submit this report')); ?><span class="required">*</span></label>
            <div class="rightcheckbox classlisting_type">
                <div class="form-check">
                    <input class="form-check-input" checked type="radio" name="listing_type" id="Anonymously" value="1"  />
                    <label class="form-check-label" for="Anonymously">
                        <?php echo e(__('Anonymously')); ?>

                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="listing_type" id="exampleRadios12" value="2"  />
                    <label class="form-check-label" for="Happytosharemydetails">
                        <?php echo e(__('Happy to share my details')); ?>

                    </label>
                </div>
            </div>
            <?php if($cuser->is_admin==6): ?>
            <div class="gcspuniversalnm mt-2 gcsphidediv">
                <div class="form-group">
                    <input type="text" value="<?php echo e(old('ob_fullname')); ?>" name="ob_fullname" placeholder="<?php echo e(__('Full Name')); ?>"  class="form-control"  />
                </div>
                <div class="form-group">
                    <input type="text" value="<?php echo e(old('ob_empid')); ?>" name="ob_empid" placeholder="<?php echo e(__('Employee ID')); ?>"  class="form-control"  />
                </div>
                <div class="form-group">
                    <input type="email" value="<?php echo e(old('ob_email')); ?>" name="ob_email" placeholder="<?php echo e(__('E-Mail Address')); ?>"  class="form-control"  />
                </div>
            </div>
            <?php endif; ?>


            <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Please select at least one is required')); ?></strong></span>
        </div>

        <div class="form-check mb-3">
                <input class="form-check-input " type="checkbox" name="agree" required id="exampleRadios111" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                <?php echo e(__('Please agree with disclaimer/terms of agreement before submitting.')); ?>

                </label>
            </div>
    </div>


</div>

<button type="submit"  class="btn btn-primary gcspaddobservation"><?php echo e(__('Submit')); ?></button>
</form>

<?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/observations/create.blade.php ENDPATH**/ ?>