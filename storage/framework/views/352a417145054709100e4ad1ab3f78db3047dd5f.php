<?php echo e(view('email.header')); ?>

<tr>
                <td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;"><?php echo e(__('Dear')); ?> <?php echo e($username); ?>,</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><?php echo e(__('Near Miss status has been changed in')); ?> <?php echo e(get_site_name()); ?>.</p>
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
                      </td>
                    </tr>

                  
                     
                  </table></td>
              </tr>
<?php echo e(view('email.footer')); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/email/observations_overdue.blade.php ENDPATH**/ ?>