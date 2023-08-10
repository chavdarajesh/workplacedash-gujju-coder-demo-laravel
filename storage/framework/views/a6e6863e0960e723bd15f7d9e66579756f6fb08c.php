<div class="gc-form-title">
    <h5><?php echo e(__('Edit an Near Miss')); ?> <a class="float-right observationscreate" href="<?php echo e(route('observationscreate')); ?>"><i class="fa fa-times"></i></a></h5>
</div>
<form action="<?php echo e(route('observationupdate')); ?>" id="observationupdate" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="ob_id" value="<?php echo e($Observation->ob_id); ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Near Miss Serial Number')); ?> : <?php echo e($Observation->ob_srno); ?></label>
            </div>    
        </div>    
    </div>    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe ">
                <label for="exampleInputEmail1"><?php echo e(__('Select Near Miss Type')); ?><span class="required">*</span></label>
                <select  name="oc_id" class="oc_id2 classoc_id"  >
                <?php echo GetCatDropDown(1,$Observation->oc_id); ?>                                           
                </select>
                <span class="invalid-feedback classoc_idmsg" role="alert"><strong><?php echo e(__('The Near Miss Type field is required.')); ?></strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Describe your near miss')); ?><span class="required">*</span></label>
                <textarea name="description"  class="form-control classdescription"><?php echo e($Observation->description); ?></textarea>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Description field is required.')); ?></strong></span>
            </div>
        </div>
  </div>  <!--first row over-->

<div class="row">
    <div class="col-md-12">
        <div class="form-group gcsptreeviewwapepe classsite_id">
            <label for="exampleInputEmail1"><?php echo e(__('Where? name the location, area, site')); ?>...<span class="required">*</span></label>
            <select  class="site_id2 gcspobservationsitelist" name="site_id">
                <?php echo GetSiteDropDown(null,$Observation->site_id); ?>

                <option <?php if($Observation->site_id==0): ?> selected <?php endif; ?> value="0"><?php echo e(__('Unsure / do not know')); ?></option>
            </select>            
        </div>
        <span class="invalid-feedback  mt-n2 mb-1" role="alert"><strong><?php echo e(__('Select Area field is required.')); ?></strong></span>
        <div class="form-check mb-3">
                <input class="form-check-input gcspobservationsitelist" <?php echo e(($Observation->ob_describethelocation)?'checked':''); ?> type="checkbox" name="ob_describethelocation_check" id="exampleRadios11" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                <?php echo e(__('Unsure / do not know')); ?>

                </label>
            </div>
        <div class="form-group <?php echo e(($Observation->ob_describethelocation)?'':'gcsphidediv'); ?> gcspobservationsite">
                <input type="text" value="<?php echo e($Observation->ob_describethelocation); ?>" name="ob_describethelocation" placeholder="Describe the location"  class="form-control"  />
        </div>
    </div>
     <div class="col-md-12">    
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo e(__('When? select date and time')); ?><span class="required">*</span></label>
            <input type="text" value="<?php echo e(date('m/d/Y, h:i a',strtotime($Observation->obdatetime))); ?>" name="obdatetime" placeholder=""  class="dateclass  form-control classobdatetime gcspdatetimepicker"  />
            <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Date and Time field is required.')); ?></strong></span>
        </div>        
    </div>    
</div>

<div class="row">
    <?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations Risk potential')): ?>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo e(__('Select risk potential level')); ?><span class="required">*</span></label><br />
            <div class="btn-group btn-group-toggle classriskpotentiallevel" data-toggle="buttons">
                <label class="btn btn-secondary minorbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==1)?'active':''; ?>"> <input type="radio" value="1" <?php echo ($Observation->riskpotentiallevel==1)?'checked':''; ?> name="riskpotentiallevel" id="option1"   /> <?php echo e(__('Minor')); ?> </label>
                <label class="btn btn-secondary seriousbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==2)?'active':''; ?>"> <input <?php echo ($Observation->riskpotentiallevel==2)?'checked':''; ?> value="2" type="radio" name="riskpotentiallevel" id="option2"  /> <?php echo e(__('Serious')); ?> </label>
                <label class="btn btn-secondary fatalbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==3)?'active':''; ?>"> <input <?php echo ($Observation->riskpotentiallevel==3)?'checked':''; ?> value="3" type="radio" name="riskpotentiallevel" id="option3"  /> <?php echo e(__('Fatal')); ?> </label>
            </div>
            <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Risk potential level field is required.')); ?></strong></span>            
        </div>
    </div>
    <?php else: ?>
        <input type="hidden" name="riskpotentiallevel" value="<?php echo e($Observation->riskpotentiallevel); ?>">
    <?php endif; ?>


    <?php if($cuser->hasRole('Super Admin') || $cuser->can('Actions Add')): ?>
    <div class="col-md-12">
        <div class="form-group">            
            <label for="exampleInputEmail1"><?php echo e(__('Action required')); ?><span class="required">*</span></label>
            <div class="rightcheckbox classaction_required">
                <div class="form-check">
                    <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios1" value="1" <?php echo ($Observation->action_required==1)?'checked':''; ?> />
                    <label class="form-check-label" for="exampleRadios1">
                        <?php echo e(__('Yes')); ?>

                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios12" value="0"  <?php echo ($Observation->action_required==0)?'checked':''; ?> />
                    <label class="form-check-label" for="exampleRadios12">
                        <?php echo e(__('No')); ?>

                    </label>
                </div>
            </div>
            <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Actions field is required')); ?></strong></span>
        </div>
        <div class="form-group gcsphideactionsmain <?php echo ($Observation->action_required==1)?'':'gcsphideactions'; ?> p-3">
           
        <div class="actionslists actionslists border-0 pt-0 mt-0">
            <div class="actionsec">
                <div class="acttitle"><h4 class="formtitle"> <?php echo e(__('Actions')); ?> <span>(<?php echo e(count($Actions)); ?>)</span></h4></div>
                <div class="actpopup"><a class="gcspaddaction" ><span>+</span> <?php echo e(__('Add Action')); ?></a></div>
            </div>

            <div class="actlisting">
              <ul>
                <?php $__currentLoopData = $Actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ActionsOpen_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <h5><?php echo e(substr($ActionsOpen_item->am_description,0,70)); ?></h5>
                    <p>Control: <?php echo e($ActionsOpen_item->cm_name); ?><br><span> Responsibility: <?php echo e(GetActionResponsibility($ActionsOpen_item->am_id)); ?> </span><br><span> Due by: <?php echo e(date('d M, Y',strtotime($ActionsOpen_item->am_due_date))); ?> | <span class="actlabel overdue"> <?php echo e(GetActionStatus($ActionsOpen_item->am_status)); ?></span></span></p>

                    <div class="reportaction">
                      <div class="repodtactimg">
                      <img src="<?php echo e(asset('images/PPE.png')); ?>" alt="">
                      </div>
                      <div class="repodtactext"><span><?php echo e($ActionsOpen_item->name); ?></span><span><?php echo e(date('d M, Y D h:ia',strtotime($ActionsOpen_item->created_at))); ?></span></div>
                   </div> 

                   <div class="gcspaction">
                    <?php if($cuser->hasRole('Super Admin') || $cuser->can('Actions Edit')): ?>
                      <a href="<?php echo e(route('actionsedit',['id'=>$ActionsOpen_item->am_id])); ?>" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                    <?php if($cuser->hasRole('Super Admin') || $cuser->can('Actions Delete')): ?>  
                      <a  href="<?php echo e(route('actionsdelete',['id'=>$ActionsOpen_item->am_id])); ?>" data-type="edit" data-parentid="<?php echo e($ActionsOpen_item->am_parent_id); ?>"  class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
                    <?php endif; ?>  
                   </div>  
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <div class="actionhtmlbefore"></div>
            </div>
         </div>
        </div>        
    </div> 
    <?php else: ?>
    <input type="hidden" name="action_required" value="<?php echo e($Observation->action_required); ?>">
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
            <?php 
            if($observations_attachement_rel){
                echo '<hr/>';
                foreach ($observations_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pip{{$value->oar_id}}"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a class="removeimgobserve"  href="{{ route('deletefile',['id'=>$value->oar_id])}}" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
                
            }
            ?>
        </div> 
    </div>*/?>

         <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Make a suggestion/recommendation')); ?><span class="required">*</span></label>
                <textarea  name="Comments" class="form-control classComments"><?php echo e($Observation->Comments); ?></textarea>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Make a suggestion field is required.')); ?></strong></span>
            </div>
         </div>

         <?php if($cuser->hasRole('Super Admin') || $cuser->can('Observations Close')): ?>


        <div class="col-md-12">
            <div class="form-group">                        
            <div class="rightcheckbox classlisting_type">
                <div class="form-check">
                    <input class="form-check-input" <?php echo e(($Observation->ob_more_information_required==1)?'checked':''); ?> type="checkbox" name="ob_more_information_required" id="ob_more_information_required" value="1"  />
                    <label class="form-check-label" for="ob_more_information_required">
                        <?php echo e(__('More information required')); ?>

                    </label>
                </div>                
            </div>            
            </div> 
        </div>

        <div class="col-md-12 ob_information_required" style="<?php echo e(($Observation->ob_more_information_required!=1)?'display: none;':''); ?>">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Please give details of information required')); ?><span class="required">*</span></label>
                <textarea  name="ob_information_required" <?php echo e(($Observation->ob_more_information_required==1)?'required':''); ?> class="form-control classComments"><?php echo e($Observation->ob_information_required); ?></textarea>                
            </div>
         </div>
          <?php if($Observation->ob_more_information_required==1): ?>

         <div class="col-md-12 ob_reply_information_requested ob_information_required">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Reply to more information requested')); ?><span class="required">*</span></label>
                <textarea  name="ob_reply_information_requested" required class="form-control classComments"><?php echo e($Observation->ob_reply_information_requested); ?></textarea>                
            </div>
         </div>
         <div class="col-md-12 ob_information_required">
        <div class="form-group gc-uploadbtn">
            <label for="exampleInputEmail1"><?php echo e(__('Reply to more information attachement')); ?><span class="required">*</span></label>
                <div id="newfiletypeaddedora"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload-ora" class="custom-file-upload">
                       <img src="<?php echo e(asset('images/attached-file.png')); ?>" alt="">
                    </label>
                    <input id="file-upload-ora" class="file-upload-ora" name="attachedmain_ora[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedtora"></div>
                <div id="fileinstedtimgora"></div>
            <?php 
            if($observations_reply_attachement){
                
                foreach ($observations_reply_attachement as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->ora_attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pipora<?php echo e($value->ora_id); ?>"><a title="<?php echo e($value->ora_attachement_name); ?>" href="<?php echo e(url('storage/'.$value->ora_attachament)); ?>" target="_blank"><img alt="<?php echo e($value->ora_attachement_name); ?>" class="imageThumb" src="<?php echo e($attachamentsrc); ?>" ></a><br><span class="removeimg"><a class="removeimgobserveora"  href="<?php echo e(route('deletefileora',['ora_id'=>$value->ora_id])); ?>" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
            }
            ?>
        </div> 
    </div>


         <?php endif; ?> 




         <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Status')); ?><span class="required">*</span></label>
                <select name="status" required class="form-control gcspchangeobsevationstatus">
                     <option value="" ><?php echo e(__('Select')); ?> <?php echo e(__('Status')); ?></option>   
                     <option value="1" <?php echo e(($Observation->status==1)?'selected="selected"':''); ?>><?php echo e(__('Open')); ?></option>   
                     <option value="0" <?php echo e(($Observation->status==0)?'selected="selected"':''); ?>><?php echo e(__('Close')); ?></option>   
                </select>
            </div>
         </div> 

         <div class="col-md-12 ob_closing_comments" style="<?php echo e(($Observation->status!=0)?'display: none;':''); ?>">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Closing Comments')); ?><span class="required">*</span></label>
                <textarea  name="ob_closing_comments" <?php echo e(($Observation->status!=1 && $Observation->status!=2)?'required':''); ?> class="form-control classComments"><?php echo e($Observation->ob_closing_comments); ?></textarea>
                <span class="invalid-feedback" role="alert"><strong><?php echo e(__('Closing Comments is required.')); ?></strong></span>
            </div>
         </div>
         <?php else: ?>
         <input type="hidden" name="status" value="<?php echo e($Observation->status); ?>">
         <input type="hidden" name="ob_more_information_required" value="<?php echo e($Observation->ob_more_information_required); ?>">
         <?php if($Observation->ob_more_information_required==1): ?>

         <div class="col-md-12 ob_reply_information_requested">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Please give details of information required.')); ?><span class="required">*</span></label>
                <textarea disabled  class="form-control classComments"><?php echo e($Observation->ob_information_required); ?></textarea>                
            </div>
         </div>

         <div class="col-md-12 ob_reply_information_requested">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo e(__('Reply to more information requested')); ?><span class="required">*</span></label>
                <textarea  name="ob_reply_information_requested" required class="form-control classComments"><?php echo e($Observation->ob_reply_information_requested); ?></textarea>                
            </div>
         </div>

    <div class="col-md-12">
        <div class="form-group gc-uploadbtn">
            <label for="exampleInputEmail1"><?php echo e(__('Reply to more information attachement')); ?><span class="required">*</span></label>
                <div id="newfiletypeaddedora"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload-ora" class="custom-file-upload">
                       <img src="<?php echo e(asset('images/attached-file.png')); ?>" alt="">
                    </label>
                    <input id="file-upload-ora" class="file-upload-ora" name="attachedmain_ora[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedtora"></div>
                <div id="fileinstedtimgora"></div>
            <?php 
            if($observations_reply_attachement){
                echo '<hr/>';
                foreach ($observations_reply_attachement as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->ora_attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pipora<?php echo e($value->ora_id); ?>"><a title="<?php echo e($value->ora_attachement_name); ?>" href="<?php echo e(url('storage/'.$value->ora_attachament)); ?>" target="_blank"><img alt="<?php echo e($value->ora_attachement_name); ?>" class="imageThumb" src="<?php echo e($attachamentsrc); ?>" ></a><br><span class="removeimg"><a class="removeimgobserveora"  href="<?php echo e(route('deletefileora',['ora_id'=>$value->ora_id])); ?>" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
            }
            ?>
        </div> 
    </div>
         <?php endif; ?>  


         <?php endif; ?> 

                    

    </div>
    <button type="submit" class="btn btn-primary observationupdate"><?php echo e(__('Submit')); ?></button>
</form>
</div>

<?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/observations/edit.blade.php ENDPATH**/ ?>