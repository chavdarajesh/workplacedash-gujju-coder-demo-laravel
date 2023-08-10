
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Schedule')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="auditsupdate" action="{{route('auditsupdate')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1">{{__('Select Site(s)')}}<span class="required">*</span></label>
                        <select disabled  class="site_id3 adm_site_id_change" data-formtype="edit" name="adm_site_id">
                            {!! GetSiteDropDown(null,$Audits->adm_site_id) !!}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">                
                    <div class="form-group gcsptreeviewwapepe adm_site_id_replace_html">
                        <label for="exampleInputEmail1">{{__('Select Auditor')}}<span class="required">*</span></label>
                        <select disabled  name="adm_auditor" class="form-control"  >
                            <option value="">Select name</option>
                            @foreach ($Auditor as $key => $AuditorItem) 
                                <option {{($AuditorItem->id==$Audits->adm_auditor)?'selected':''}} value="{{$AuditorItem->id}}">{{$AuditorItem->name.' - '.$AuditorItem->r_name}}</option>        
                            @endforeach
                        </select>
                    </div>                
                </div>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1">{{__('Frequency')}}<span class="required">*</span></label>
                        <select disabled  class="form-control" name="adm_af_id">
                            {!! GetAuditFrequencyDropDown($Audits->adm_af_id) !!}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">                
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1">{{__('Select Type')}}<span class="required">*</span></label>
                        <select disabled name="adm_ac_id" class="form-control" >
                            {!! GetCatDropDown(4,$Audits->adm_ac_id) !!}
                        </select>
                    </div>                
                </div>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group gcsptreeviewwapepe">
                        <label for="exampleInputEmail1">{{__('Start from')}}<span class="required">*</span></label>
                        <input required type="text" autocomplete="off" value="{{$Audits->adm_start_from}}" name="adm_start_from"  class="form-control gcspdatepickerstart"  />
                    </div>
                </div>
                <div class="col-md-6">    
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('End on')}}<span class="required">*</span></label>
                        <input required type="text" autocomplete="off" value="{{$Audits->adm_end_on}}" name="adm_end_on"  class="form-control gcspdatepickerend"  />
                    </div>
                </div>    
            </div>
            <div class="modal-footer border-0">        
                <button type="submit" class="btn btn-primary m-auto">{{__('Update Schedule')}}</button>
            </div>
        </form>

      </div>
      
    </div>
  </div>
</div>