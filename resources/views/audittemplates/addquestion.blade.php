<div class="row mt-3 gcspquetionwpr gcspquetionwpr{{$divid}}">
    <form method="post" id="mainqustionfrm{{$divid}}" action="{{route('addupdatequstion')}}" class="addupdatequstion">
    <input type="hidden" name="atpq_id" value="{{$atpq_id}}">        
    <input type="hidden" name="atpq_divid" value="{{$divid}}">
    <input type="hidden" name="atpq_atp_id" value="{{$AuditQuestions->atpq_atp_id}}">
    <input type="hidden" name="atpq_atm_id" value="{{$AuditQuestions->atpq_atm_id}}">
    <div class="col-sm-8 gcspquetioninner">
        <div class="form_txt_edit"><textarea maxlength="500" name="atpq_question" class="form-control" ></textarea></div>
        <div class="questionruleswpr">
            <div class="mt-2">
                <div class="form-group hideDescription">
                    <label ><b>{{__('Description')}}</b></label>
                    <textarea name="atpq_description_text" class="form-control"></textarea>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="atpq_is_mandatory" type="checkbox" id="Mandatory{{$divid}}" value="1">
                    <label class="form-check-label" for="Mandatory{{$divid}}">{{__('Mandatory')}}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="atpq_is_description" class="form-check-input gcspshowdescription" data-divid="{{$divid}}" type="checkbox" id="Description{{$divid}}" value="1">
                    <label class="form-check-label" for="Description{{$divid}}">{{__('Description')}}</label>
                </div>      
            </div>
        </div>      
    </div>
    <div class="col-sm-4  gcspquetioninner gpqustiondelete">
        <a href="javascript:void(0);" data-divid="{{$divid}}" data-atpq_id="{{$atpq_id}}" class="gpqustiondeletetag gpqustionremove"><i class="fa fa-trash"></i></a>
        <select required class="form-control atpq_type" data-divid="{{$divid}}" data-atpq_id="{{$atpq_id}}" name="atpq_type">
            <option value="">{{__('Please choose option')}}</option>
            <option value="1">{{__('Attachments')}}</option>
            <option value="2">{{__('Check Box')}}</option>
            <option value="3">{{__('Date / Time')}}</option>
            <option value="4">{{__('Declaration')}}</option>
            <option value="5">{{__('Grid View')}}</option>
            <option value="6">{{__('Site List From Master')}}</option>
            <option value="7">{{__('Text Area')}}</option>
            <option value="8">{{__('Text Field')}}</option>
            <option value="9">{{__('User List From Master')}}</option>            
        </select>

        <a href="javascript:void(0);" data-toggle="modal" class="CheckBoxOptionModal CheckBoxOptionModal{{$divid}}" data-target="#CheckBoxOptionModal{{$divid}}"><i class="fa fa-plus"></i> {{__('Add options')}}</a>
    </div>
    </form>

    <div class="col-sm-12 gcsprulescontaner gcsprulescontanerhide gcsprulescontaner{{$divid}}"></div>
    
</div>
