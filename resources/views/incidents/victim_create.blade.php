<div class="gcspvictomfrmmain gcspvictomfrmmain{{$srno}}">
<div class="gcspvictomfrmdelete"><a href="javascript:void(0);" data-srno="{{$srno}}" ><i class="fa fa-times-circle"></i></a></div>    
<input type="hidden" name="srno[]" value="{{$srno}}">
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Select Victim Type')}}</label>
            <select  class="form-control multipleSelect2{{$srno}}" id="multipleSelect2{{$srno}}" required name="iv_vtm_id[]" >
                <option value="">{{__('Select')}}</option>
                <?php foreach ($VictimType as $key => $VictimType_value) {?>
                    <option  value="{{$VictimType_value->vtm_id}}">{{$VictimType_value->vtm_name}}</option>
                <?php } ?>                      
            </select>  
        </div>
    </div>
    <div class="col-md-4">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Name of victim')}}<span class="required">*</span></label>
            <input  type="text" value="" required  name="iv_name[]"  class="form-control"  />
        </div>
    </div>

    <div class="col-md-4">
        <label for="exampleInputEmail1">{{__('Gender')}}<span class="required">*</span></label>
        <div class="form-group">        
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="iv_gender[{{$srno}}]" id="exampleRadios11" value="1" checked  />
                <label class="form-check-label" for="exampleRadios11">
                    {{__('Male')}}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="iv_gender[{{$srno}}]" id="exampleRadios1" value="2"  />
                <label class="form-check-label" for="exampleRadios1">
                    {{__('Female')}}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="iv_gender[{{$srno}}]" id="exampleRadios1" value="3"  />
                <label class="form-check-label" for="exampleRadios1">
                    {{__('Other')}}
                </label>
            </div>
        </div>
    </div> 

</div>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="agerang{{$srno}}">{{__('Select age range')}}</label>
            <input name="iv_age_range[]" value="18 - 25" type="text" class="agerang border-0  bg-transparent" id="agerang{{$srno}}" readonly style="color:#f6931f;font-weight:bold;">
            <div id="slider-range{{$srno}}"></div>

        </div>
    </div>
    <div class="col-md-4">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Body Parts Injured')}}</label>
            <select  class="form-control multipleSelect{{$srno}}" id="multipleSelect{{$srno}}" required name="bpm_id[{{$srno}}][]" multiple>
                <option value="">{{__('Select')}}</option>
                <?php foreach ($BodyPart as $key => $BodyPart_value) {?>
                    <option  value="{{$BodyPart_value->bpm_id}}">{{$BodyPart_value->bpm_name}}</option>
                <?php } ?>                      
            </select> 
        </div>
    </div>
    <div class="col-md-4">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Details of injury')}}</label> 
            <textarea class="form-control" name="iv_details_injury[]" ></textarea>                       
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group gcspvictombtn">
            <label for="exampleInputEmail1">{{__('Was the victim taken to a hospital?')}}<span class="required">*</span></label>  
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary mr-2 iv_taken_hospital" data-value="1">
                    <input type="radio" name="iv_taken_hospital[{{$srno}}]" id="iv_taken_hospital1{{$srno}}" value="1" class="" > {{__('Yes')}}
                </label>
                <label class="btn btn-primary active  mr-2 iv_taken_hospital"  data-value="0">
                    <input type="radio" name="iv_taken_hospital[{{$srno}}]" id="iv_taken_hospital0{{$srno}}" value="0" class=""  checked> {{__('No')}}
                </label>
            </div>
        </div>            
    </div>

    <div class="col-md-4 gcsptakentotahehospital">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('When he will return to work')}}</label>            
            <input  type="text" value=""   name="iv_when_returntowork[]"  class="form-control" />
        </div>
    </div>
    <div class="col-md-4">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Details of treatment given')}}</label>
            <textarea class="form-control" name="iv_details_treatment[]" ></textarea>          
        </div>
    </div>

</div>
<hr> 
</div>