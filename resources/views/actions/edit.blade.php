<div class="gc-form-title">
    <h5>{{__('Edit')}} {{__($Actions->ct_name)}} {{__('Action')}}<a class="float-right actioncloseclick" data-parentid="{{$Actions->am_parent_id}}" href="javascript:void(0);"><i class="fa fa-times"></i></a></h5>
</div>

<form id="actionsupdate" action="{{route('actionsupdate')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="am_id" value="{{$Actions->am_id}}">
    <input type="hidden" name="am_parent_id" value="{{$Actions->am_parent_id}}">
   <div class="row">
    

    <div class="col-md-12">
     <div class="form-group">
         <label for="exampleInputEmail1">{{__('Action details')}}<span class="required">*</span></label>
         <textarea class="form-control" required name="description" >{{$Actions->am_description}}</textarea>                
     </div>
     </div>

     <div class="col-md-12">    
    <div class="form-group">
        <label for="exampleInputEmail1">{{__('Control')}}<span class="required">*</span></label>
        <select  class="form-control selectControl multipleSelect" required name="control" >
        <option value="">{{__('Select')}}</option>
        <?php foreach ($Control as $key => $Control_value) {?>
            <option <?php if($Control_value->cm_id==$Actions->am_control){echo 'selected';} ?> value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
        <?php } ?>                      
    </select>                            
    </div>
</div>


</div>

<div class="row">

<div class="col-md-12">
 <div class="form-group">
     <label for="exampleInputEmail1">{{__('Responsibility')}}<span class="required">*</span></label>
     <select required class="form-control selectResponsibility multipleSelect" name="user_id[]" multiple >
        <option value="">{{__('Select')}}</option>
        <?php foreach ($Users as $key => $Users_value) {?>
            <option <?php if(in_array($Users_value->id, $actions_responsible)){echo 'selected';} ?> value="{{$Users_value->id}}">{{$Users_value->name}}</option>
        <?php } ?>			            
    </select>                
</div>
</div>

<div class="col-md-12">    
    <div class="form-group">
        <label for="exampleInputEmail1">{{__('Due Date')}}<span class="required">*</span></label>
        <input required type="text" value="{{ date('m/d/Y, h:i',strtotime($Actions->am_due_date)) }}"   name="due_date"  class="gcspdatetimepicker  form-control"  />

    </div>
</div>

</div>


<div class="row">

<div class="col-md-12">
 <div class="form-group">
     <label for="exampleInputEmail1">{{__('Status')}}<span class="required">*</span></label>
     <select name="status" required class="form-control" >
         <option value="">Select</option>
         <option <?php if($Actions->am_status==1){echo 'selected';} ?> value="1">{{__('Open')}}</option>
         <option <?php if($Actions->am_status==2){echo 'selected';} ?> value="2">{{__('Overdue')}}</option>
         <option <?php if($Actions->am_status==3){echo 'selected';} ?> value="3">{{__('In Progress')}}</option>
         <option <?php if($Actions->am_status==4){echo 'selected';} ?> value="4">{{__('Completed')}}</option>
         <option <?php if($Actions->am_status==5){echo 'selected';} ?> value="5">{{__('Closed')}}</option>
     </select>                
 </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="exampleInputEmail1">{{__('Remarks')}}:</label>
        <textarea class="form-control" name="remark">{{$Actions->am_remark}}</textarea>                
    </div>
    </div> 

</div> 

<div class="row">
          
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
        if($actions_attachement_rel){
            echo '<hr/>';
            foreach ($actions_attachement_rel as $key => $value) {                    
                $attachamentsrc=url('storage/'.$value->attachament);
                $path_info = pathinfo($attachamentsrc);                    
                if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                

                ?>
                <span class="pip pip{{$value->aa_id}}"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a  href="{{ route('actionsdeletefile',['id'=>$value->aa_id])}}" class="removeactiondoc"><i class="fa fa-times-circle"></i></a></span></span>
        <?php }
            
        }
        ?>
    </div> 
</div>  
</div>    

<button type="submit" class="btn btn-primary actionsfieldsrequred">{{__('Submit')}}</button> 
</form>


