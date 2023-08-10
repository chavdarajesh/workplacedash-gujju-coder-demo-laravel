<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form id="addauditaction" action="{{route('addauditaction')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="atpq_id" value="{{$atpq_id}}">
        <input type="hidden" name="adm_id" value="{{$adm_id}}">
        <input type="hidden" name="atp_id" value="{{$atp_id}}">
        <input type="hidden" name="site_id" value="{{$Audits->adm_site_id}}">        
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{__('Add new action')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
            <div class="rowobjacrionwp">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Action details')}}</label>
                            <textarea class="form-control" required name="action_description"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Control')}}</label>
                            <select class="form-control multipleSelect"  required name="control">
                                <option value="">{{__('Select')}}</option>
                                <?php foreach ($Control as $key => $Control_value) {?>
                                    <option value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail11">{{__('Responsibility')}}</label>
                            <select class="form-control multipleSelect"  required name="user_id[]" multiple>
                                <option value="">{{__('Select')}}</option>
                                <?php foreach ($Users as $key => $Users_value) {?>
                                    <option value="{{$Users_value->id}}">{{$Users_value->name}}</option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Due Date')}}</label>
                            <input type="datetime-local" value="" required name="due_date" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control" /> </div>
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
                        </div> 
                    </div>  
                </div>    
                <button type="submit" class="btn btn-primary actionsfieldsrequred">{{__('Submit')}}</button> 
            </div>
        </div>
    </div>
</form>
</div>