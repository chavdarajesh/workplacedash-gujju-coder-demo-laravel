<div class="row">
    <?php if($Vaccination){
    foreach ($Vaccination as $key => $Vaccination_value) {
?>
    <div class="col-md-6 mb-4 gcobseritem gcobseritem<?php echo e($Vaccination_value->id); ?>">
        <div
            class="card riskpotentiallevel<?php echo e($Vaccination_value->vaccine_type == 'Other' ? $Vaccination_value->other_vaccine_type : $Vaccination_value->vaccine_type); ?>">
            <div class="gcspaction">
                <?php if($Vaccination_value->deleted_at == ''): ?>
                    <a href="<?php echo e(route('vaccinationedit', ['id' => $Vaccination_value->id])); ?>"
                        class="ml-1 vaccinationedit"><i class="fa fa-edit"></i></a>
                <?php if($cuser->hasRole('Super Admin')): ?>
                <a href="<?php echo e(route('vaccinationdelete', ['id' => $Vaccination_value->id])); ?>"
                        class="ml-1 vaccinationdelete"><i class="fa fa-trash"></i></a> <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="card-body gcspobservationdetails<?php echo e($Vaccination_value->deleted_at); ?>"> <span
                    class="d-flex gc-observsntitle"><?php echo e($Vaccination_value->id); ?> -
                    <?php echo e($Vaccination_value->vaccine_type == 'Other' ? $Vaccination_value->other_vaccine_type : $Vaccination_value->vaccine_type); ?></span>
                <span class="d-flex"> Date
                    administered :</span><span class="d-flex">
                    <?php echo e(date('d M, Y D h:ia', strtotime($Vaccination_value->date_administered))); ?></span>

                <div class="gc-observsntitle-userdtl clearfix">
                    <div class="gc-observsntitle-nametag"> <span
                            class="d-flex">By:<?php echo e($Vaccination_value->name); ?> (ID:
                            <?php echo e($Vaccination_value->empid); ?>)</span> <span
                            class="d-flex"><?php echo e(date('d M, Y D h:ia', strtotime($Vaccination_value->created_at))); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>
</div>
<?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/vaccinations/vaccinationsajax.blade.php ENDPATH**/ ?>