<div class="rightpanelinnerbox">
    <div class="gc-form-title rightpentitleborder">
        <h5>{{__('Summary of an')}} {{__($Actions->ct_name)}} {{__('Action')}}</h5>
        <div class="obstitleright"><span class="backto-home"><a class="actioncloseclick" href="javascript:void(0);"> × </a></span></div>
    </div>
    <form id="detailsupdate" action="{{route('detailsupdate')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="am_id" value="{{$Actions->am_id}}">
    <div class="rightforms">
        <div class="form-group">
            <label>{{__('Action details')}}</label>
            <div>{{$Actions->am_description}}</div>
        </div>
        <div class="form-group">
            <label>{{__('Control')}}</label>
            <div> {{$Actions->cm_name}} </div>
        </div>
        <div class="form-group">
            <label>{{__('Responsibility')}}</label>
            <div> {!! GetActionResponsibility($Actions->am_id) !!} </div>
        </div>
        <div class="form-group">
            <label>{{__('Due Date')}}</label>
            <div> {{ date('Y-m-d H:i:s',strtotime($Actions->am_due_date)) }} </div>
        </div>
        <div class="form-group">
             <label for="exampleInputEmail1">{{__('Status')}}<span class="required">*</span></label>
             <select name="status" required class="form-control" >
                 <option value="">{{__('Select')}}</option>
                 <option <?php if($Actions->am_status==1){echo 'selected';} ?> value="1">{{__('Open')}}</option>
                 <option <?php if($Actions->am_status==2){echo 'selected';} ?> value="2">{{__('Overdue')}}</option>
                 <option <?php if($Actions->am_status==3){echo 'selected';} ?> value="3">{{__('In Progress')}}</option>
                 <option <?php if($Actions->am_status==4){echo 'selected';} ?> value="4">{{__('Completed')}}</option>
                 <option <?php if($Actions->am_status==5){echo 'selected';} ?> value="5">{{__('Closed')}}</option>
             </select>                
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Remarks')}}:</label>
            <textarea class="form-control"  name="remark"  >{{$Actions->am_remark}}</textarea>                
        </div>

    <div class="form-group gc-uploadbtn">
        <?php 
        if($actions_attachement_rel){            
            foreach ($actions_attachement_rel as $key => $value) {                    
                $attachamentsrc=url('storage/'.$value->attachament);
                $path_info = pathinfo($attachamentsrc);                    
                if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                ?>
                <span class="pip "><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br></span>
        <?php }        
        }
        ?>
    </div> 
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
    </div>
    </div>
</div>