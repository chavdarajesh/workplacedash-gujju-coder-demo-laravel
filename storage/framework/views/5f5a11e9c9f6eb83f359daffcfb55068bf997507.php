<div class="gc-form-title">
    <h5><?php echo e(__('Edit Vaccinations')); ?></h5>
</div>
<div class="alert alert-secondary" role="alert">
    <?php echo e(__("By completing this form, you acknowledge you're reporting your vaccination status in an accurate and honest manner. Thank you for choosing to report your vaccination status.")); ?>

</div>
<form id="vaccinationupdate" action="<?php echo e(route('vaccinationupdate')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo e($Vaccination->id); ?>">
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Have you been vaccinated')); ?><span
                        class="required">*</span></label>
                <div class="rightcheckbox classvaccinated">
                    <div class="form-check">
                        <input class="form-check-input vaccinated" type="radio" name="vaccinated" id="exampleRadios1"
                            value="1" <?php echo $Vaccination->vaccinated == 1 ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="exampleRadios1">
                            <?php echo e(__('Yes')); ?>

                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input vaccinated" type="radio" name="vaccinated" id="exampleRadios12"
                            value="0" <?php echo $Vaccination->vaccinated == 0 ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="exampleRadios12">
                            <?php echo e(__('No')); ?>

                        </label>
                    </div>
                </div>
                <span class="invalid-feedback"
                    role="alert"><strong><?php echo e(__('vaccinated field is required')); ?></strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Date administered')); ?><span class="required">*</span></label>
                <input type="datetime-local"
                    value="<?php echo e(date('Y-m-d', strtotime($Vaccination->date_administered))); ?>T<?php echo e(date('H:i:s', strtotime($Vaccination->date_administered))); ?>"
                    required name="date_administered" placeholder="" onClick="$(this).removeClass('placeholderclass')"
                    class="dateclass  form-control" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classvaccine_type">
                <label for="exampleInputEmail1"><?php echo e(__('Vaccine type')); ?><span class="required">*</span></label>
                <?php echo GetVaccinetypeDropDown(false, false, $Vaccination->vaccine_type, $Vaccination->other_vaccine_type); ?>

            </div>
            <span class="invalid-feedback  mt-n2 mb-1"
                role="alert"><strong><?php echo e(__('Vaccine type field is required.')); ?></strong></span>
        </div>

        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
                <div class="gcspuploadedwpr">
                    <label for="vc-file-upload" class="custom-file-upload">
                        <img src="<?php echo e(asset('images/attached-file.png')); ?>" alt="">
                    </label>
                    <input id="vc-file-upload" class="vc-file-upload" name="picture" type="file" accept="image/*" />
                </div>
                <div id="vcfileinstedtimg"></div>
            </div>
        </div>
    </div>

    <button type="button" <?php echo $Vaccination->second_vaccinated == 1 ? 'style="display:none"' : 'style="display:inline"'; ?>
        class="btn btn-primary addsecondvaccinations"><?php echo e(__('+ Add Vaccination')); ?></button>

    <div class="secondvaccinations row" <?php echo $Vaccination->second_vaccinated == 1 ? 'style="display:block"' : 'style="display:none"'; ?>>
        <div class="col-md-12">
            <button type="button" class="btn closesecondvaccinations"><?php echo e(__('X')); ?></button>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Have you been vaccinated')); ?><span
                        class="required">*</span></label>
                <div class="rightcheckbox classsecond_vaccinated">
                    <div class="form-check">
                        <input class="form-check-input second_vaccinated" type="radio" name="second_vaccinated"
                            id="exampleRadios1" value="1" <?php echo $Vaccination->second_vaccinated == 1 ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="exampleRadios1">
                            <?php echo e(__('Yes')); ?>

                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input second_vaccinated" type="radio" name="second_vaccinated"
                            id="exampleRadios12" value="0" <?php echo $Vaccination->second_vaccinated == 0 ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="exampleRadios12">
                            <?php echo e(__('No')); ?>

                        </label>
                    </div>
                </div>
                <span class="invalid-feedback"
                    role="alert"><strong><?php echo e(__('second_vaccinated field is required')); ?></strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Date administered')); ?><span class="required">*</span></label>
                <input type="datetime-local"
                    value="<?php echo e($Vaccination->second_date_administered ? date('Y-m-d', strtotime($Vaccination->second_date_administered)) . 'T' . date('H:i:s', strtotime($Vaccination->second_date_administered)) : ''); ?>"
                    name="second_date_administered" placeholder="" onClick="$(this).removeClass('placeholderclass')"
                    class="dateclass placeholderclass form-control" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classvaccine_type">
                <label for="exampleInputEmail1"><?php echo e(__('Vaccine type')); ?><span class="required">*</span></label>
                <?php echo GetVaccinetypeDropDown(
                    false,
                    true,
                    $Vaccination->second_vaccine_type,
                    $Vaccination->second_other_vaccine_type,
                ); ?>

            </div>
            <span class="invalid-feedback  mt-n2 mb-1"
                role="alert"><strong><?php echo e(__('Vaccine type field is required.')); ?></strong></span>
        </div>

        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
                <div class="gcspuploadedwpr">
                    <label for="second-vc-file-upload" class="custom-file-upload">
                        <img src="<?php echo e(asset('images/attached-file.png')); ?>" alt="">
                    </label>
                    <input id="second-vc-file-upload" class="second-vc-file-upload" name="second_picture"
                        type="file" accept="image/*" />
                </div>
                <div id="secondvcfileinstedtimg"></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary gcspaddvaccinations"><?php echo e(__('Submit')); ?></button>
</form>
<?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/vaccinations/edit.blade.php ENDPATH**/ ?>