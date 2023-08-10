<?php $__env->startSection('content'); ?>
<div class="gcspfullpagewapper mb-4">
<div class="gc-to-date">
	<div class="row">
		<div class="col-md-6 gcsptreeviewwapepe gcsphomepagetreevire">
			
			    <select name="site_id[]" multiple class="form-control dashboardchange site_id" id="exampleFormControlSelect1">
                    <?php echo GetSiteDropDown(); ?>

                </select>
			
		</div>
	   
	   <div class="col-md-6">
	   	    <div class="gc-testdate">
		   	    <!-- <form action="">				  -->
				  <div class="row">
                    <div class="col-md-4 mb-4"></div>
				    <div class="col-md-8 mb-4">
				      <div class="md-form">
				          <input type="text" class="gcspdaterangepicker dashboardchange" id="" name="filterdate" placeholder="<?php echo e(date('d M, Y')); ?>">
				  		<i class="fa fa-calendar gc-calendricon dashbord-dticon" aria-hidden="true"></i>
				        </div>
                <input type="hidden" name="ifchaneddate">
				    </div>
					  
				  </div>
				<!-- </form> -->
			</div>	
	   </div>
	</div>   
</div>



<div class="row row-eq-height gc-chartbox">
  <?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations')): ?>
  <div class="col-md-4 mb-4">
    <div class="card dashboard-card">
      <div class="card-body">
        <h6 class="card-title gc-cardtitle"><?php echo e(__('Near Miss by Rating')); ?></h6>
        <div class="columnchart">
          <div id="ObservationsbyCategories"></div>              
        </div>
      </div>
    </div>         
  </div>
  <?php endif; ?>
  <?php if($cuser->hasRole('Super Admin') || $cuser->can('Incident')): ?>
  <!-- <div class="col-md-4 mb-4">
    <div class="card dashboard-card">
      <div class="card-body">
        <h6 class="card-title gc-cardtitle"><?php echo e(__('Incidents by Categories')); ?></h6>
        <div class="columnchart">
          <div id="IncidentsbyCategories"></div>              
        </div>        
      </div>
    </div> 
  </div> -->
  <div class="col-md-4 mb-4">
    <div class="card dashboard-card">
      <div class="card-body">
        <h6 class="card-title gc-cardtitle"><?php echo e(__('Incidents by Rating')); ?></h6>
        <div class="columnchart">
          <div id="IncidentsbyRating"></div>              
        </div>
        
      </div>
    </div> 
  </div>
  <?php endif; ?>
  <?php if($cuser->hasRole('Super Admin') || $cuser->can('Actions')): ?>
  <div class="col-md-4 mb-4">
    <div class="card dashboard-card">
      <div class="card-body">
        <h6 class="card-title gc-cardtitle"><?php echo e(__('Actions')); ?></h6>
        <div class="columnchart">
          <div id="ActionsByStatus"></div>              
        </div>
      </div>
    </div> 
  </div>
  <?php endif; ?>
</div>

<?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations') || $cuser->can('Incident') || $cuser->can('Audit')): ?>  
<div class="row row-eq-height prodate">
  <div class="col-sm-6 col-md-4 col-le-3 mb-3">
    <div class="card dashboard-card-eqlhgt">
      <div class="card-body gc-cardbody">
   		 <h5><?php echo e(__('By type')); ?></h5>

	   		<div class="form-group">   
        <?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations')): ?>     
            <div class="form-check">
              <input class="form-check-input dashboardmodulechange" type="checkbox" name="moduletype[]" id="exampleRadios1" value="1" checked>
              <label class="form-check-label" for="exampleRadios1">
                <?php echo e(__('Near Miss')); ?>

              </label>
            </div>
        <?php endif; ?>
        <?php if($cuser->hasRole('Super Admin') || $cuser->can('Incident')): ?>
            <div class="form-check">
              <input class="form-check-input dashboardmodulechange" type="checkbox" name="moduletype[]" id="exampleRadios2" value="2" checked>
              <label class="form-check-label" for="exampleRadios2">
                <?php echo e(__('Incidents')); ?>

              </label>
            </div>
        <?php endif; ?>
        <?php if($cuser->hasRole('Super Admin') || $cuser->can('Audit')): ?>   
            <div class="form-check">
              <input class="form-check-input dashboardmodulechange" type="checkbox" name="moduletype[]" id="exampleRadios3" value="4" checked>
              <label class="form-check-label" for="exampleRadios3">
                <?php echo e(__('Audits')); ?>

              </label>
            </div> 
        <?php endif; ?>        
	   	 	</div>
        
  		</div>
	</div>
  </div>

    <div class="col-sm-6  col-md-8 col-le-9 mb-9">
	    <div class="card dashboard-card">
		    <div class="card-body">
		      <div class="gcspcalederwapper">
            <a href="javascript:void(0);" class="gcspcalprev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a href="javascript:void(0);" class="gcspcalnext"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <div class="clendervider">
                <div  id='calendar1'></div>  
            </div>
            <div class="clendervider">
                <div  id='calendar2'></div>  
            </div>
            <div class="clendervider">
                <div  id='calendar3'></div>  
            </div>
          </div>
		    </div>
	 	</div>
	</div>
</div>
<?php endif; ?>

</div>

<div id="modal-view-event" class="modal modal-top fade calendar-modal calendardetails">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span><button type="button" class="close" data-dismiss="modal">&times;</button></h4>
          <div class="event-body"></div>
        </div>
        
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/dashboard.blade.php ENDPATH**/ ?>