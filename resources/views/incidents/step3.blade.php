@extends('layouts.dashboard')
@section('content')
<div class="gcspfullpagewapper">
@include('incidents.datails')

<div class="gc-form-title mt-5 mb-4">
 <h5>{{__('Paso')}} 3 : {{__('Root Cause Analysis')}}</h5>
 <p>{{__('Select reason for the existence of immediate cause')}}</p>
</div>
<form action="{{route('step3')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
    <input type="hidden" name="step" value="{{$step}}">    
    

<div id="accordion" role="tablist" class="card-body-sp-rc">
  @foreach($RootCause as $key => $RootCauseValue)
  <?php $parentid=0; ?>
  <h5 class="{{($key!=0)?'mt-4':''}}">{{$RootCauseValue->rc_name}}</h5>
  <hr class="border-info" >
  <div class="card1">
  <?php $count=count($RootCauseItem[$RootCauseValue->rc_id]); ?>  
  @foreach($RootCauseItem[$RootCauseValue->rc_id] as $subkey=> $RootCauseItemValue)

    <?php if($parentid!=$RootCauseItemValue['rci_parent_id'] && $parentid!=0){ ?>
        </div></div></div>
    <?php } ?>  

    <?php if($RootCauseItemValue['rci_id']==$RootCauseItemValue['rci_parent_id']){ ?>
    <div class="card-header">
      <input type="checkbox" <?php echo (in_array($RootCauseItemValue['rci_id'], $AddedRootCauseItem))?'checked':''; ?> class="gcspparentrc gcspparentrc{{$RootCauseItemValue['rci_parent_id']}}" data-paparentid="{{$RootCauseItemValue['rci_parent_id']}}" id="parentid{{$RootCauseItemValue['rci_parent_id']}}" name="irc_rcid[]" value="{{$RootCauseItemValue['rci_id']}}">
      <h5 class="mb-0 d-inline"  role="tab" id="heading{{$RootCauseItemValue['rci_parent_id']}}" data-toggle="collapse" href="#collapse{{$RootCauseItemValue['rci_parent_id']}}" aria-expanded="true" aria-controls="collapse{{$RootCauseItemValue['rci_parent_id']}}">        
        <label for="1parentid{{$RootCauseItemValue['rci_parent_id']}}">{{$RootCauseItemValue['rci_name']}}<span> (0)</span></label>
      </h5>
    </div>
    <div id="collapse{{$RootCauseItemValue['rci_parent_id']}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$RootCauseItemValue['rci_parent_id']}}" >
      <div class="card-body-sp">
       <div class="row"> 
    <?php }else{ ?>
    
        <div class="col-sm-6">
            <div class="gcsprcitem">
           <input type="checkbox" <?php echo (in_array($RootCauseItemValue['rci_id'], $AddedRootCauseItem))?'checked':''; ?> class="gcspchildrc gcspchildrc{{$RootCauseItemValue['rci_parent_id']}}" data-paparentid="{{$RootCauseItemValue['rci_parent_id']}}" id="parentid{{$RootCauseItemValue['rci_id']}}" name="irc_rcid[]" value="{{$RootCauseItemValue['rci_id']}}"><label for="parentid{{$RootCauseItemValue['rci_id']}}">{{$RootCauseItemValue['rci_name']}}</label> 
       </div>
        </div>
       <?php } ?>
      <?php if($count==($subkey+1)){ echo '</div></div></div>';?>
      <input type="hidden" name="rc[]" value="{{$RootCauseItemValue['rci_rc_id']}}">
      <textarea placeholder="Describe about the selected root causes" name="description{{$RootCauseItemValue['rci_rc_id']}}" class="form-control mb-1 mt-3">{{ $AddedRootCauseDesciption[$RootCauseItemValue['rci_rc_id']] }}</textarea>
      <?php } ?> 
  
  <?php $parentid=$RootCauseItemValue['rci_parent_id'];?>  
  @endforeach
  </div>   
  @endforeach
</div>    
<?php if($cuser->hasRole('Super Admin') || $cuser->id==$Incident->im_created_by){?>
<button type="submit" class="btn btn-primary mb-5 mt-5">{{__('Submit')}}</button> 
<?php } ?>
</form>
</div>
@endsection