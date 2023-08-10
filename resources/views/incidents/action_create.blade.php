<div class="opacityzero gcspactionrowfrmmain{{$insrno}}">
    <input type="hidden" name="insrno[]" value="{{$insrno}}">
    <input type="hidden" name="am_id[]" value="0">
    
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Action details')}}<span class="required">*</span></label>
            <textarea class="form-control" required  name="action_description[]" ></textarea>                
        </div>
    </div>
    <div class="col-md-3">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Type Control')}}<span class="required">*</span></label>
            <select  class="form-control selectControl multipleSelect2{{$insrno}}" id="multipleSelect2{{$insrno}}" required name="control[]" >
            <option value="">{{__('Select')}}</option>
            <?php foreach ($Control as $key => $Control_value) {?>
                <option  value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
            <?php } ?>                      
        </select>   
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail11">{{__('Responsibility')}}<span class="required">*</span></label>
            <select  class="form-control selectResponsibility multipleSelect{{$insrno}}" id="multipleSelect{{$insrno}}" required name="user_id[{{$insrno}}][]" multiple >
                <option value="">{{__('Select')}}</option>
                <?php foreach ($Users as $key => $Users_value) {?>
                    <option value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>
                <?php } ?>                      
            </select>                
        </div>
    </div>
    <div class="col-md-3 gcspactivefrmmain"> 
    <div class="gcspactivefrmdelete"><a href="javascript:void(0);" data-srno="{{$insrno}}"><i class="fa fa-times-circle"></i></a></div>   
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Due Date')}}<span class="required">*</span></label>
            <input  type="datetime-local" value="" required  name="due_date[]" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control"  />
        </div>
    </div>

</div>
</div>