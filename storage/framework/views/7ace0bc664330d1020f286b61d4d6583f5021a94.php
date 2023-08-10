<?php echo e(view('email.header')); ?>

<tr>
                <td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;"><?php echo e(__('Dear')); ?> <?php echo e($username); ?>,</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><?php echo e(__('Near Miss updated in')); ?> <?php echo e(get_site_name()); ?>.</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;"><?php echo e(__('Near Miss Details')); ?></h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Near Miss ID')); ?>:</strong> <?php echo e($observations['ob_srno']); ?></p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Near Miss Type')); ?>:</strong> <?php echo e($observations['observationtype']); ?></p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Description')); ?>:</strong> <?php echo e($observations['description']); ?></p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Sites')); ?>:</strong> <?php echo e($observations['sites']); ?></p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Date / Time')); ?>:</strong> <?php echo e($observations['datetime']); ?> </p>
                        <?php if($observations['risklevel']!=0): ?>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Risk Potential Level')); ?>:</strong> <?php echo e(__($observations['risklevel'])); ?></p>
                        <?php endif; ?>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Make a suggestion/recommendation')); ?>:</strong> <?php echo e($observations['comments']); ?></p> 
                        <?php if($observations['ob_information_required']!=''): ?>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong><?php echo e(__('Please give details of information required')); ?>:</strong> <?php echo e($observations['ob_information_required']); ?></p> 
                        <?php endif; ?>
                      </td>
                    </tr>

                   
                    <?php if($observations['actions']): ?>
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:20px; font-weight:normal; font-family: 'Roboto', sans-serif;"><?php echo e(__('Near Miss Actions')); ?></h4></td>
                    </tr>
                    <tr>
                      <td style="padding-bottom:20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; border-right:none;">
                          <tr>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Details')); ?></th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Control')); ?></th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Responsibility')); ?></th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Due Date')); ?></th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Status')); ?></th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;"><?php echo e(__('Remarks')); ?></th>
                          </tr>
                          <?php $__currentLoopData = $observations['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e($action['description']); ?></td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e($action['control']); ?></td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e($action['responsibility']); ?></td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e($action['due_date']); ?></td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e(__($action['status'])); ?></td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;"><?php echo e($action['remarks']); ?></td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                          
                        </table>
                      </td>
                    </tr>

                    <?php endif; ?>

                     
                  </table></td>
              </tr>
<?php echo e(view('email.footer')); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/email/observations_edit.blade.php ENDPATH**/ ?>