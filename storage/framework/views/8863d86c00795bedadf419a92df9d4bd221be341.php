<?php $__env->startSection('content'); ?>
<div class="gcspfullpagewapper">
<div class="row">
  <div class="col-md-12">
      <div class="btn-group gc-testbtn">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo e(__('All Sites')); ?>

        </button>
        <div class="dropdown-menu dropdown-menu-right gc-text-dropdown">
          <button class="dropdown-item" type="button">Action</button>
          <button class="dropdown-item" type="button">Another action</button>
          <button class="dropdown-item" type="button">Something else here</button>
        </div>
      </div>
  </div>
</div>

 <div class="gc-observsntitle-wrap ">
    <div class="row">
        <div class="col-md-12">
            <div class="gc-obsrvtbsec">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="gc-today-tab" data-toggle="tab" href="#gc-today" role="tab" aria-controls="today" aria-selected="true">
                      Today </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-thisweek-tab" data-toggle="tab" href="#gc-thisweek" role="tab" aria-controls="thisweek" aria-selected="false">
                    This week </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-month-tab" data-toggle="tab" href="#gc-month" role="tab" aria-controls="month" aria-selected="false">
                     This month
                    </a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-filter-tab" data-toggle="tab" href="#gc-filter" role="tab" aria-controls="filter" aria-selected="false">
                      Filter bydate
                    </a>
                  </li>
                   

                </ul>
            </div>

             <div class="gc-observsntitle-rightlbl excel-export clearfix">
               <a href="#">Export to Excel<i class="fa fa-file-excel gc-excel" aria-hidden="true"></i></a>
                <!-- <li><i class="fa fa-circle gc-minor" aria-hidden="true"></i>Minor</li>
                <li><i class="fa fa-circle gc-serious" aria-hidden="true"></i>Serious</li>
                <li><i class="fa fa-circle gc-fatal" aria-hidden="true"></i>Fatal</li> -->
                <!--  <li><a href="#"><i class="fa fa-file-excel gc-excel" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-search gc-search" aria-hidden="true"></i></a></li> -->
           </div>
       </div>
 
    </div>   
</div>






<div class="tab-content gc-tabs" id="myTabContent">
  <div class="tab-pane fade show active" id="gc-today" role="tabpanel" aria-labelledby="gc-today-tab">
     <div class="row">
        <div class="col-md-4 mb-4">
           <div class="card">            
              <div class="card-body">
                 <h6>By type</h6>
                 <img src="<?php echo e(asset('images/1.jpg')); ?>">
              </div>
           </div>
        </div>
        <div class="col-md-4 mb-4">
           <div class="card">            
              <div class="card-body">
                 <h6>Last Six Months</h6>
                 <img src="<?php echo e(asset('images/2.jpg')); ?>">
              </div>
           </div>
        </div>
        <div class="col-md-4 mb-4">
           <div class="card">            
              <div class="card-body">
                 <h6>By Status</h6>
                 <img src="<?php echo e(asset('images/3.jpg')); ?>">
              </div>
           </div>
        </div>      
     </div>
  </div>

     <div class="tab-content gc-tabs" id="myTabContent">
      <div class="tab-pane fade show active" id="gc-thisweek" role="tabpanel" aria-labelledby="gc-thisweek-tab">
      </div>
    </div>

    <div class="tab-content gc-tabs" id="myTabContent">
      <div class="tab-pane fade show active" id="gc-month" role="tabpanel" aria-labelledby="gc-month-tab">
      </div>
    </div>

    <div class="tab-content gc-tabs" id="myTabContent">
      <div class="tab-pane fade show active" id="gc-filter" role="tabpanel" aria-labelledby="gc-filter-tab">
      </div>
    </div>

</div> <!--main tab over-->
<hr>

    <div class="gc-obsrvtbsec">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="gc-observsnopen-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="open" aria-selected="true">
                      All Permits </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-overdue-tab" data-toggle="tab" href="#gc-overdue" role="tab" aria-controls="overdue" aria-selected="false">
                    Requested </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-progress-tab" data-toggle="tab" href="#gc-progress" role="tab" aria-controls="progress" aria-selected="false">
                      Drafts
                    </a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-completed-tab" data-toggle="tab" href="#gc-completed" role="tab" aria-controls="completed" aria-selected="false">
                      Approved
                    </a>
                  </li>
                   <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnclose" role="tab" aria-controls="profile" aria-selected="false">
                    Revoked</a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnclose" role="tab" aria-controls="profile" aria-selected="false">
                    Rejected</a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnclose" role="tab" aria-controls="profile" aria-selected="false">
                    Closed</a>
                  </li>

                </ul>
            </div>

             <div class="gc-observsntitle-rightlbl clearfix">
             <ul>
                
                <li><a href="#"><i class="fa fa-search gc-search" aria-hidden="true"></i></a></li>
             </ul>
          </div>
       
     <div class="tab-content gc-tabs" id="myTabContent">
        <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">
                <div class="gc-observation-userdtl">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card" style="border-left: 6px solid #ffb536;">
                                <div class="card-body">
                                  <div class="gc-permit-title">
                                    <span class="d-flex gc-observsntitle">
                                      <i class="fa fa-snowflake" aria-hidden="true"></i><span> BD154148</span>
                                      <i class="fa fa-user gc-prmtuser" aria-hidden="true"></i>
                                      <span>1</span>
                                  </span> 
                                  <div class="gc-permit-timedtl"> <span>11:57 AM</span><p>29 jul, 2020</p> </div>
                                   <div class="gc-permit-timedtlicn"><i class="fa fa-clock" aria-hidden="true"></i><span> 11:57 AM</span><p>29 jul, 2020</p> </div>
                                   <span class="d-flex">test</span>
                                    <p class="card-text">Test</p>
                                    
                                    <div class="gc-observsntitle-userdtl clearfix">    
                                        <div class="gc-observsntitle-nametag gc-permttag">
                                            <span class="d-flex">Extended</span>
                                            
                                        </div> 
                                        <div class="gc-observsntitle-subtag gc-permits">
                                            <label for="tag">Privew</label>
                                        </div> 
                                    </div>      
                                </div>
                            </div>
            </div>
            </div>
          </div> 
        </div>
   </div>
 </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/permits/permits.blade.php ENDPATH**/ ?>