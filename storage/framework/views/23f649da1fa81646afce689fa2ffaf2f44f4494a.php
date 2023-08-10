<?php $__env->startSection('content'); ?>
<div class="gcspfullpagewapper">
  <form action="<?php echo e(route('rolesupdate')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo e($Roles->id); ?>">
    <input type="hidden" name="r_status" value="1">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Role Name')); ?></label>
                <input type="text" name="r_name" value="<?php echo e($Roles->r_name); ?>" required="required" class="form-control" >        
            </div>
        </div>  
        <div class="col-md-6"></div>    
    </div>   

    <div class="gcsppermissionwapper">    
    <div class="permissionLicensestable mt-3">
        <h4><?php echo e(__('Assign Licenses')); ?></h4>
        <table class="table tablefirst mt-3" >
            
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="55%"><?php echo e(__('Module Name')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Add')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Edit')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Delete')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><input value="57" <?php echo in_array(57, $permissions)?'checked':''; ?> type="checkbox" class="gcspparent57" id="NearMiss" name="upd_pm_id[]"><label for="NearMiss"><?php echo e(__('Near Miss')); ?></label> </th>
                    <td><input value="58" <?php echo in_array(58, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="59" <?php echo in_array(59, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="60" <?php echo in_array(60, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td><input <?php echo in_array(61, $permissions)?'checked':''; ?> class="gcsppermitcheck57" data-parent="57" value="61" id="Close61" type="checkbox" name="upd_pm_id[]"><label for="Close61"><?php echo e(__('Close')); ?></label></td>
                                <td><input <?php echo in_array(64, $permissions)?'checked':''; ?> class="gcsppermitcheck57" data-parent="57" value="64" id="Close64" type="checkbox" name="upd_pm_id[]"><label for="Close64"><?php echo e(__('Risk Potential Level')); ?></label></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
                <tr>
                    <th scope="row"><input <?php echo in_array(53, $permissions)?'checked':''; ?> value="53" type="checkbox" class="gcspparent53" id="Actions" name="upd_pm_id[]"><label for="Actions"><?php echo e(__('Actions')); ?></label> </th>
                    <td><input value="54" <?php echo in_array(54, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="55" <?php echo in_array(55, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="56" <?php echo in_array(56, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="1" <?php echo in_array(1, $permissions)?'checked':''; ?> class="gcspparent1" type="checkbox" id="Audit" name="upd_pm_id[]"><label for="Audit"><?php echo e(__('Audit')); ?></label> </th>
                    <td><input value="2" <?php echo in_array(2, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="3" <?php echo in_array(3, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="4" <?php echo in_array(4, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="5" <?php echo in_array(5, $permissions)?'checked':''; ?> class="gcspparent5"  type="checkbox" id="Incident" name="upd_pm_id[]"><label for="Incident"><?php echo e(__('Incident')); ?></label> </th>
                    <td><input value="6" <?php echo in_array(6, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="7" <?php echo in_array(7, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="8" <?php echo in_array(8, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td><input class="gcsppermitcheck5"  data-parent="5" <?php echo in_array(62, $permissions)?'checked':''; ?> value="62" id="Close62" type="checkbox" name="upd_pm_id[]"><label for="Close62"><?php echo e(__('Close')); ?></label></td>                                
                                <td><input class="gcsppermitcheck5"  data-parent="5" value="63" <?php echo in_array(63, $permissions)?'checked':''; ?> id="Reject63" type="checkbox" name="upd_pm_id[]"><label for="Reject63"><?php echo e(__('Approve')); ?>/<?php echo e(__('Reject')); ?></label></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
                <tr>
                    <th scope="row"><input value="9" <?php echo in_array(9, $permissions)?'checked':''; ?> type="checkbox" id="Permit" name="upd_pm_id[]" class="gcsppermitcheck gcspparent9"><label for="Permit"><?php echo e(__('Permit')); ?></label></th>
                    <td><input value="10" <?php echo in_array(10, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="11" <?php echo in_array(11, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="12" <?php echo in_array(12, $permissions)?'checked':''; ?> type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <td scope="row">
                        <table class="table Licensestableinner">
                            <tr>
                                <td ><input class="gcsppermitcheck9" data-parent="9" value="13" <?php echo in_array(13, $permissions)?'checked':''; ?> id="Revoke" type="checkbox"  name="upd_pm_id[]"><label for="Revoke"><?php echo e(__('Revoke')); ?></label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="14" <?php echo in_array(14, $permissions)?'checked':''; ?> id="Extend" type="checkbox" name="upd_pm_id[]"><label for="Extend"><?php echo e(__('Extend')); ?></label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="15" <?php echo in_array(15, $permissions)?'checked':''; ?> id="Close" type="checkbox" name="upd_pm_id[]"><label for="Close"><?php echo e(__('Close')); ?></label></td>
                                <td ><input class="gcsppermitcheck9" data-parent="9"  value="16" <?php echo in_array(16, $permissions)?'checked':''; ?> id="Reject" type="checkbox" name="upd_pm_id[]"><label for="Reject"><?php echo e(__('Reject')); ?></label></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3"></td>                    
                </tr>
            </tbody>
        
        </table>
    </div>

    <div class="permissionLicensestable mt-5 mb-5 aceessrole<?php echo e($Roles->id); ?>">
        <h4><?php echo e(__('Grant Admin Access Privileges')); ?></h4>
        <table class="table tablefirst tablesecond mt-3" >
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="55%"><?php echo e(__('Section Name')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Add')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Edit')); ?></th>
                    <th scope="col" width="15%" class="text-center"><?php echo e(__('Delete')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><input value="17" <?php echo in_array(17, $permissions)?'checked':''; ?>  type="checkbox" id="AuditTemplate" name="upd_pm_id[]"><label for="AuditTemplate"><?php echo e(__('Audit Template')); ?></label> </th>
                    <td><input value="18" <?php echo in_array(18, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="19" <?php echo in_array(19, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="20" <?php echo in_array(20, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="21" <?php echo in_array(21, $permissions)?'checked':''; ?>  type="checkbox" id="Categories" name="upd_pm_id[]"><label for="Categories"><?php echo e(__('Categories')); ?></label> </th>
                    <td><input value="22" <?php echo in_array(22, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="23" <?php echo in_array(23, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="24" <?php echo in_array(24, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="25" <?php echo in_array(25, $permissions)?'checked':''; ?>  type="checkbox" id="HIRA" name="upd_pm_id[]"><label for="HIRA"><?php echo e(__('HIRA')); ?></label> </th>
                    <td><input value="26" <?php echo in_array(26, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="27" <?php echo in_array(27, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="28" <?php echo in_array(28, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="29" <?php echo in_array(29, $permissions)?'checked':''; ?>  type="checkbox" id="PermitTemplates" name="upd_pm_id[]"><label for="PermitTemplates"><?php echo e(__('Permit Templates')); ?></label> </th>
                    <td><input value="30" <?php echo in_array(30, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="31" <?php echo in_array(31, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="32" <?php echo in_array(32, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="33" <?php echo in_array(33, $permissions)?'checked':''; ?>  type="checkbox" id="RootCause" name="upd_pm_id[]"><label for="RootCause"><?php echo e(__('Root Cause')); ?></label> </th>
                    <td><input value="34" <?php echo in_array(34, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="35" <?php echo in_array(35, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="36" <?php echo in_array(36, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="37" <?php echo in_array(37, $permissions)?'checked':''; ?>  type="checkbox" id="Roles" name="upd_pm_id[]"><label for="Roles"><?php echo e(__('Roles')); ?></label> </th>
                    <td><input value="38" <?php echo in_array(38, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="39" <?php echo in_array(39, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="40" <?php echo in_array(40, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="41" <?php echo in_array(41, $permissions)?'checked':''; ?>  type="checkbox" id="Sites" name="upd_pm_id[]"><label for="Sites"><?php echo e(__('Sites')); ?></label> </th>
                    <td><input value="42" <?php echo in_array(42, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="43" <?php echo in_array(43, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="44" <?php echo in_array(44, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="45" <?php echo in_array(45, $permissions)?'checked':''; ?>  type="checkbox" id="User" name="upd_pm_id[]"><label for="User"><?php echo e(__('Users')); ?></label> </th>
                    <td><input value="46" <?php echo in_array(46, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="47" <?php echo in_array(47, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="48" <?php echo in_array(48, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>
                <tr>
                    <th scope="row"><input value="49" <?php echo in_array(49, $permissions)?'checked':''; ?>  type="checkbox" id="Workflows" name="upd_pm_id[]"><label for="Workflows"><?php echo e(__('Workflows')); ?></label></th>
                    <td><input value="50" <?php echo in_array(50, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="51" <?php echo in_array(51, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                    <td><input value="52" <?php echo in_array(52, $permissions)?'checked':''; ?>  type="checkbox" name="upd_pm_id[]"></td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>     
    
    
    <button type="submit" class="btn btn-primary mb-5"><?php echo e(__('Submit')); ?></button> 
</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/roles/edit.blade.php ENDPATH**/ ?>