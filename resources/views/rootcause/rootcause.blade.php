@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
<div class="mb-5 gcsprootcausewapper">
  @if($cuser->can('Root Cause Add'))
  <a class="btn btn-primary mb-3" href="{{route('rootcausecreate')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('New')}}</a>
  @endif

<div class="gc-observsntitle-wrap ">
    <div class="row">
        <div class="col-md-12">
            <div class="gc-obsrvtbsec">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="gc-observsnopen-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="open" aria-selected="true">{{__('Active')}} <sub>({{count($RootCause)}})</sub></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnclose" role="tab" aria-controls="profile" aria-selected="false">{{__('Inactive')}} <sub>({{count($RootCauseDeactive)}})</sub></a>
                  </li>
                </ul>
            </div>
          </div>
       </div>
    </div>   

<div class="tab-content gc-tabs" id="myTabContent">
  <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">
    <div class="tableboxshadow">
      <div class="tablepaddacc123">
        <table width="100%" cellpadding="10" class="gcspctitletable table table-hover">
          <tr>
            <th width="60%">{{__('Name')}}</th>
            <th width="20%">{{__('Modified On')}}</th>
            <th width="20%"></th>
          </tr>
          @if(count($RootCause))
          @foreach($RootCause as $RootCauseItem)
          <tr>
            <td width="60%">{{$RootCauseItem->rc_name}}</td>
            <td width="20%">{{date('d M, Y',strtotime($RootCauseItem->updated_at))}}</td>
            <td width="20%">
              @if($cuser->can('Root Cause Edit'))
              <a href="{{ route('rootcauseedit',['id'=>$RootCauseItem->rc_id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
              @endif
              <a href="{{ route('rootcauselist',['rc_id'=>$RootCauseItem->rc_id]) }}" class="ml-3"><i class="fa fa-cog"></i></a>
              @if($cuser->can('Root Cause Delete'))
              <a href="{{ route('rootcausedelete',['id'=>$RootCauseItem->rc_id]) }}" class="ml-3" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash"></i></a>
              @endif
            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="3" align="center">No Record Found.</td>          
          </tr>
          @endif
        </table>
      </div>
    </div>  
  </div>

  <div class="tab-pane" id="gc-observsnclose" role="tabpanel" aria-labelledby="gc-observsnopen-tab">
    <div class="tableboxshadow">
      <div class="tablepaddacc123">
        <table width="100%" cellpadding="10" class="gcspctitletable table table-hover">
          <tr>
            <th width="60%">Name</th>
            <th width="20%">Modified On</th>
            <th width="20%"></th>
          </tr>
          @if(count($RootCauseDeactive))
          @foreach($RootCauseDeactive as $RootCauseItem)
          <tr>
            <td width="60%">{{$RootCauseItem->rc_name}}</td>
            <td width="20%">{{date('d M, Y',strtotime($RootCauseItem->updated_at))}}</td>
            <td width="20%">
              <a href="{{ route('rootcauseedit',['id'=>$RootCauseItem->rc_id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
              <a href="{{ route('rootcauselist',['rc_id'=>$RootCauseItem->rc_id]) }}" class="ml-3"><i class="fa fa-cog"></i></a>
              <a href="{{ route('rootcausedelete',['id'=>$RootCauseItem->rc_id]) }}" class="ml-3 gcspcategorydelete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="3" align="center">No Record Found.</td>          
          </tr>
          @endif
        </table>
      </div>
    </div>  
  </div>
</div>


</div>  
</div>
    @endsection