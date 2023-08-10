<div class="table-responsive">
    <table class="table  table-hover gcspaudittable" >
    <thead>
        <tr >
            <th width="20%"><?php echo e(__('Audit title and description')); ?></th>
            <th width="20%"><?php echo e(__('Area')); ?></th>
            <th width="10%"><?php echo e(__('Score')); ?></th>
            <th width=""><?php echo e(__('Findings')); ?></th>
            <th width=""><?php echo e(__('Action')); ?></th>
            <th width=""><?php echo e(__('Frequency')); ?></th>
            <th width="16%"><?php echo e(__('Schedule')); ?></th>
            <th width="10%"><?php echo e(__('Status')); ?></th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($Audits)): ?>
        <?php $__currentLoopData = $Audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $AuditsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="tr<?php echo e($AuditsItem->adm_id); ?>">
            <td><div class="gcspaudirrowtitle"><b><?php echo e($AuditsItem->atm_audit_name); ?></b><span class="d-block"><?php echo e(__('Auditor')); ?>: <?php echo e($AuditsItem->auditor); ?></span></div></td>
            <td><b><?php echo e($AuditsItem->site_name); ?></b><span class="d-block"><?php echo e(__('Auditee')); ?>: <?php echo e($AuditsItem->auditee); ?></span></td>            
            <td>
                <?php if($AuditsItem->adm_status!=1): ?>    
                    <?php echo GetInspectionScore($AuditsItem->adm_id,$AuditsItem->adm_atm_id,1); ?>

                <?php else: ?>
                    -
                <?php endif; ?>  
            </td>
            <td><?php echo e(($AuditsItem->Findings)?$AuditsItem->Findings:'-'); ?></td>
            <td><?php echo e(($AuditsItem->actions)?$AuditsItem->actions:'-'); ?></td>
            <td><?php echo e($AuditsItem->af_name); ?></td>
            <td>
                <span class="d-block"><b><?php echo e(__('Start')); ?>: <?php echo e(date('d M, Y',strtotime($AuditsItem->adm_start_from))); ?></b></span>
                <span class="d-block"><?php echo e(__('Ends')); ?>: <?php echo e(date('d M, Y',strtotime($AuditsItem->adm_end_on))); ?></span>
            </td>
            <td>
                <?php if($AuditsItem->adm_status==2): ?>                    
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                        if($GetTimeline[$AuditsItem->adm_id][0]->atl_type==2){
                             echo __('In progress');
                        }else{
                            echo '<span class="text-danger">'.__('Rejected').'</span><span class="text-secondary">';
                            echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                        }
                       
                    }?>
                <?php elseif($AuditsItem->adm_status==3): ?>    
                    Overdue
                <?php elseif($AuditsItem->adm_status==4): ?>    
                    <span class="text-success"><?php echo e(__('Completed')); ?></span><span class="text-secondary">
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                       echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                    } ?>    
                     
                 </span>
                <?php elseif($AuditsItem->adm_status==5): ?>    
                    <span class="text-success"><?php echo e(__('Approved')); ?></span><span class="text-secondary">
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                       echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                    } ?>
                <?php else: ?>
                <?php echo e(__('Pending')); ?>                    
                <?php endif; ?>    
            </td>
            <td align="right" class="atm_list">
                <?php if($AuditsItem->adm_status==1 && (date("Y-m-d") == $AuditsItem->adm_start_from)): ?>
                <a href="<?php echo e(route('getauditsection',['adm_id'=>$AuditsItem->adm_id])); ?>" class="gcspauditstart"><?php echo e(__('Start')); ?></a>
                <?php endif; ?>
                <?php if($AuditsItem->adm_status==2): ?>
                <a href="<?php echo e(route('getauditsection',['adm_id'=>$AuditsItem->adm_id])); ?>" class="gcspauditstart"><?php echo e(__('Continue')); ?></a>
                <?php endif; ?>
                <?php if($AuditsItem->adm_status==1): ?>
                <a href="javascript:void(0);" data-adm_id="<?php echo e($AuditsItem->adm_id); ?>" class="gcspauditedit pr-2"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0);" data-adm_id="<?php echo e($AuditsItem->adm_id); ?>" class="gcspauditdelete"><i class="fa fa-trash"></i></a></td>
                <?php endif; ?>

                <?php if($AuditsItem->adm_status==4 || $AuditsItem->adm_status==5): ?>
                <a href="<?php echo e(route('getreport',['adm_id'=>$AuditsItem->adm_id])); ?>" ><?php echo e(__('View Summary')); ?></a>                
                <?php endif; ?>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <tr>
            <td colspan="9"><center><?php echo e(__('No records found')); ?></center></td>                        
        </tr>
        <?php endif; ?>
    </tbody>
</table>
</div><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/audits/audits_list.blade.php ENDPATH**/ ?>