<div class="gc-form-title">
    <h5>{{__('Edit Audit')}}<a class="float-right audittemplatescreate" href="{{route('audittemplatescreate')}}"><i class="fa fa-times"></i></a></h5>
</div>
<form id="audittemplatesupdate" action="{{route('audittemplatesupdate')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="atm_id" value="{{ $AuditTemplates->atm_id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">{{__('Audit Name')}}<span class="required">*</span></label>
                <input type="text" required class="form-control" value="{{ $AuditTemplates->atm_audit_name }}" name="atm_audit_name">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description')}}<span class="required">*</span></label>
                <textarea required name="atm_description"  class="form-control">{{ $AuditTemplates->atm_description }}</textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">{{__('Audit ID')}}<span class="required">*</span></label>
                <input type="text" class="form-control" value="{{ $AuditTemplates->atm_audit_id }}" name="atm_audit_id">
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
                 <input id="file-upload" class="file-upload-single" name="atm_icon" type="file" accept="image/*" />
             </div>    
             <div id="fileinstedt"></div>
             <div id="fileinstedtimg"></div>
             @if($AuditTemplates->atm_icon)
             <span  class="pip pip{{$AuditTemplates->atm_id}}">
                <img class="imageThumb" src="{{url('storage/'.$AuditTemplates->atm_icon)}}" ><br><span data-href="{{route('audittemplatesdeleteicon',['id'=>$AuditTemplates->atm_id])}}" class="removeimgsingle removeimgsingleicon "><i class="fa fa-times-circle"></i></span>
             </span>
             @endif
         </div> 
        </div>      
        <div class="col-md-12">
            <div class="form-group">            
                <label for="exampleInputEmail1">{{__('Scoring Required?')}}<span class="required">*</span></label>
                <div class="rightcheckbox">
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_scoring_required" id="exampleRadios1" value="1" {{ ($AuditTemplates->atm_scoring_required==1)?'checked':'' }}  />
                        <label class="form-check-label" for="exampleRadios1">
                            {{__('Yes')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_scoring_required" id="exampleRadios12" value="0" {{ ($AuditTemplates->atm_scoring_required==0)?'checked':'' }} />
                        <label class="form-check-label" for="exampleRadios12">
                            {{__('No')}}
                        </label>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-md-12">
            <div class="form-group">            
                <label for="exampleInputEmail1">{{__('Status')}}<span class="required">*</span></label>
                <div class="rightcheckbox">
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_status" id="exampleRadios3" value="1" {{ ($AuditTemplates->atm_status==1)?'checked':'' }} />
                        <label class="form-check-label" for="exampleRadios3">
                            {{__('Yes')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_status" id="exampleRadios14" value="0" {{ ($AuditTemplates->atm_status==0)?'checked':'' }} />
                        <label class="form-check-label" for="exampleRadios14">
                            {{__('No')}}
                        </label>
                    </div>
                </div>
            </div>
        </div>    
    </div>
<button type="submit" class="btn btn-primary gcspaddobservation">{{__('Submit')}}</button>
</form>