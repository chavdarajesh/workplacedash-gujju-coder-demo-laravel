<div class="rowobjacrionwp p-1 rowobjacrionwp{{$srno}}">
    <div class="deleteaction"><i  data-srno="{{$srno}}" class="fa fa-trash"></i></div>
<input type="hidden" name="srno[]" value="{{$srno}}">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Action details')}}</label>
            <textarea class="form-control" required  name="action_description[]" ></textarea>                
        </div>
    </div>
    <div class="col-md-12">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Control')}}</label>
            <select  class="form-control multipleSelect2{{$srno}}" id="multipleSelect2{{$srno}}" required name="control[]" >
            <option value="">{{__('Select')}}</option>
            <?php foreach ($Control as $key => $Control_value) {?>
                <option  value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
            <?php } ?>                      
        </select>   
        </div>
    </div>
</div>
<div class="row">
    
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail11">{{__('Responsibility')}}</label>
            <select  class="form-control multipleSelect{{$srno}}" id="multipleSelect{{$srno}}" required name="user_id[{{$srno}}][]" multiple >
                <option value="">{{__('Select')}}</option>
                <?php foreach ($Users as $key => $Users_value) {?>
                    <option value="{{$Users_value->id}}">{{$Users_value->name}}</option>
                <?php } ?>			            
            </select>                
        </div>
    </div>
    <div class="col-md-12">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Select')}}</label>
            <input  type="datetime" value="" required  name="due_date[]"  class="dateclass  form-control gcspdatetimepickerclick gcspdatetimepicker{{$srno}}" />

        </div>
    </div>
</div>
<div class="row">
    
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Status')}}</label>
            <select name="am_status[]" required class="form-control" >
                <option value="">{{__('Select')}}</option>
                <option value="1">{{__('Open')}}</option>
                <option value="2">{{__('Overdue')}}</option>
                <option value="3">{{__('In Progress')}}</option>
                <option value="4">{{__('Completed')}}</option>
                <option value="5">{{__('Closed')}}</option>
            </select>                
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Remarks')}}:</label>
            <textarea class="form-control" required name="remark[]"  ></textarea>                
        </div>
    </div> 
</div>
<hr>
</div>
 
