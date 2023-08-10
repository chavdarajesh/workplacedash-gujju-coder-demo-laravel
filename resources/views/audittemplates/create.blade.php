<div class="gc-form-title">
    <h5>{{__('Create a new Audit template')}}</h5>
</div>
<form id="audittemplatesstore" action="{{route('audittemplatesstore')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">{{__('Audit Name')}}<span class="required">*</span></label>
                <input type="text" required class="form-control" value="{{ old('atm_audit_name') }}" name="atm_audit_name">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description')}}<span class="required">*</span></label>
                <textarea required name="atm_description"  class="form-control">{{ old('atm_description') }}</textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">{{__('Audit ID')}}<span class="required">*</span></label>
                <input type="text" class="form-control" value="{{ old('atm_audit_id') }}" name="atm_audit_id">
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
         </div> 
        </div>      
        <div class="col-md-12">
            <div class="form-group">            
                <label for="exampleInputEmail1">{{__('Scoring Required?')}}<span class="required">*</span></label>
                <div class="rightcheckbox">
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_scoring_required" id="exampleRadios1" value="1"  />
                        <label class="form-check-label" for="exampleRadios1">
                            {{__('Yes')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_scoring_required" id="exampleRadios12" value="0" checked />
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
                        <input class="form-check-input " type="radio" name="atm_status" id="exampleRadios3" value="1"  checked/>
                        <label class="form-check-label" for="exampleRadios3">
                            {{__('Yes')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="atm_status" id="exampleRadios14" value="0"  />
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

