<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form id="Editauditaction" action="{{route('posteditactionpopup')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="am_id" value="{{$Actions->am_id}}">        
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{__('Edit action')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
            <div class="rowobjacrionwp">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Action details')}}</label>
                            <textarea class="form-control" required name="action_description">{{$Actions->am_description}}</textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Control')}}</label>
                            <select  class="form-control selectControl multipleSelect" required name="control" >
        <option value="">{{__('Select')}}</option>
        <?php foreach ($Control as $key => $Control_value) {?>
            <option <?php if($Control_value->cm_id==$Actions->am_control){echo 'selected';} ?> value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
        <?php } ?>                      
    </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail11">{{__('Responsibility')}}</label>
                            <select required class="form-control selectResponsibility multipleSelect" name="user_id[]" multiple >
        <option value="">{{__('Select')}}</option>
        <?php foreach ($Users as $key => $Users_value) {?>
            <option <?php if(in_array($Users_value->id, $actions_responsible)){echo 'selected';} ?> value="{{$Users_value->id}}">{{$Users_value->name}}</option>
        <?php } ?>                      
    </select>     
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('Due Date')}}</label>
                            <input type="datetime-local" value="{{ date('Y-m-d',strtotime($Actions->am_due_date)) }}T{{ date('H:i:s',strtotime($Actions->am_due_date)) }}" required name="due_date" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass  form-control" /> </div>
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
            </div>
        </div>
    </div>
</form>
</div>