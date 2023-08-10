<div class="gc-form-title">
   <h5>{{__('Edit an Incident')}}<a class="float-right incidentscreate" href="{{route('incidentscreate')}}"><i class="fa fa-times"></i></a></h5>
</div>
   <form action="{{route('incidentsupdate')}}" id="incidentsupdate" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Incident Serial Number')}} : {{$Incident->im_srno}}</label>
            </div>    
        </div>    
    </div>    
    <div class="row">
        <div class="col-md-12 gcsptreeviewwapepe">
            <div class="form-group">
                <label for="exampleInputEmail1">1. {{__('Select incident type')}}<span class="required">*</span></label>                
                    <select  name="im_ic_id" class="oc_id1"  >
                        {!! GetCatDropDown(2,$Incident->im_ic_id) !!}                      
                    </select>                
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">2. {{__('Describe your incident in few words')}}...<span class="required">*</span></label>
                <textarea class="form-control" name="im_description" >{{ $Incident->im_description }}</textarea>                
            </div>
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">3. {{__('Whare? name the location, area, site')}}...<span class="required">*</span></label>
                <select  class="site_id1" name="im_site_id">
                {!! GetSiteDropDown(null,$Incident->im_site_id) !!}
                </select>
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">4. {{__('Select Shift')}}<span class="required">*</span></label>
                <select name="im_shift" required class="form-control" >
                    <option>{{__('Select')}}</option>
                    <?php if(count($Shifts)){
                    foreach ($Shifts as $key => $ShiftsValue) {?>
                       <option <?php echo ($Incident->im_shift==$ShiftsValue->sm_id)?'selected':''; ?> value="{{$ShiftsValue->sm_id}}">{{$ShiftsValue->sm_name}}</option>
                    <?php   }
                    } ?> 
                    
                </select>                
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">5. {{__('When? select date and time')}}<span class="required">*</span></label>
            <input required type="datetime-local" value="{{ date('Y-m-d',strtotime($Incident->im_datetime)) }}T{{ date('H:i:s',strtotime($Incident->im_datetime)) }}" name="im_datetime" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass  form-control"  />
            </div>
        </div>
        <div class="col-md-12">

        <div class="form-group ">
            <label for="exampleInputEmail1">6. {{__('Upload images or attach files')}}</label>
                <div id="newfiletypeadded"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload" class="custom-file-upload d-block">
                       <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedt"></div>
                <div id="fileinstedtimg"></div>
            <?php 
            if($incidents_attachement_rel){
                echo '<hr/>';
                foreach ($incidents_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}                    
                    ?>
                    <span class="pip pip{{$value->ia_id}}"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a class="incidentsdeletefile"  href="{{ route('incidentsdeletefile',['id'=>$value->ia_id])}}" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
                
            }
            ?>
        </div> 
    
        
    </div>    
   </div>
    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>

