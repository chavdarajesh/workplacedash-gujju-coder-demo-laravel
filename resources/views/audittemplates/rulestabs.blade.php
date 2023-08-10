<div class="ruleswpr mt-2">
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link" >{{__('If answer is')}}:</a>
  </li>
  @foreach($aco_name as $key=> $aco_name_item)
  <li class="nav-item">
    <a class="nav-link {{($key==0)?'active':''}}" data-toggle="tab" href="#rules{{$divid.$key}}">{{$aco_name_item}}</a>
  </li>
  @endforeach  
</ul>

<div class="tab-content">
  @foreach($aco_name as $key=> $aco_name_item)
    <div id="rules{{$divid.$key}}" class="{{$acqo_id[$key]}} container tab-pane {{($key==0)?'active':''}}">
    <?php $subdivid=$divid.$key; $option_id=$acqo_id[$key]; ?>
    <?php if(isset($AuditSubQuestions[$option_id])){
      ?>
      {{ view('audittemplates.editsubquestion',compact('subdivid','divid','option_id','atp_id','atp_atm_id','atpq_id','AuditSubQuestions','CheckBoxOption','GridViewOption','CheckBoxQuestionOption')) }}
    <?php } ?>
      <a class="addnewsubquetions mb-2 mt-2 d-block addnewsubquetions{{$divid.$key}}" data-atp_id="{{$atp_id}}" data-atp_atm_id="{{$atp_atm_id}}" data-atpq_id="{{$atpq_id}}"  data-divid="{{$divid.$key}}" data-option_id="{{$option_id}}" href="{{route('addnewsubquetions')}}"><i class="fa fa-plus"></i>{{__('Add Question')}}</a>   
    </div>
  @endforeach  
</div>
</div>