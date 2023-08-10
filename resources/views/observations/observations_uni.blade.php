@extends('layouts.dashboard') @section('content')
<div class="mainmidsec">
  <div class="innerleftpanel w-100 pb-5">   
    <?php if($searchbykeywords){?>

    <div class="tab-content gc-tabs pb-5" id="myTabContent">
      <div class="tab-pane fade show active " id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">
        
          @csrf
          

        <!--   <div class="searchaudittop d-block m-0" >
                <form id="auditsitewisesearch" action="{{route('observations')}}" method="get">                    
                    <input type="text" value="{{$searchbykeywords}}" required="" name="searchbykeywords" placeholder="NM00000" class="form-control" autocomplete="off">
                    <button type="submit" class="btn btn-primary ml-2">Buscar</button>
                </form>
            </div>
         -->
        <div class="gc-observation-userdtl">
          <div class="row">
            <?php if($ObservationOpen){
                            foreach ($ObservationOpen as $key => $ObservationOpen_value) {
                        ?>
            <div class="col-md-6 mb-4 gcobseritem gcobseritem{{$ObservationOpen_value->ob_id}}">
              <div class="card riskpotentiallevel{{$ObservationOpen_value->riskpotentiallevel}}">
                <div class="gcspaction">
          
                  @if($ObservationOpen_value->deleted_at=='')
                  @if((($cuser->hasRole('Super Admin') || $cuser->can('Observations Edit')))) 
                  @if($ObservationOpen_value->status==1 || $ObservationOpen_value->status==2)
                  <a href="{{ route('observationedit',['id'=>$ObservationOpen_value->ob_id]) }}" class="ml-1 observationedit"><i class="fa fa-edit"></i></a> @endif @endif
                  @if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete')))) <a  href="{{ route('observationdelete',['id'=>$ObservationOpen_value->ob_id]) }}" class="ml-1 observationdelete"><i class="fa fa-trash"></i></a> @endif
                  @else
                  @if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete')))) <a title="{{__('Permanent delete')}}" href="{{ route('observationdelete',['id'=>$ObservationOpen_value->ob_id]) }}" class="ml-1 observationdelete"><i class="fa fa-trash"></i></a>
                  @endif
                  @if((($cuser->hasRole('Super Admin') || $cuser->can('Observations Delete')))) <a title="{{__('Restaurar')}}"  href="{{ route('observationrestore',['id'=>$ObservationOpen_value->ob_id]) }}" class="ml-1 observationrestore"><i class="fa fa-trash-restore-alt"></i></a> @endif
                  @endif
                  
        </div>

                <div class="card-body gcspobservationdetails{{$ObservationOpen_value->deleted_at}}" data-href="{{ route('observationdetails',['id'=>$ObservationOpen_value->ob_id]) }}"> <span class="d-flex gc-observsntitle">{{$ObservationOpen_value->category_name}} - {{$ObservationOpen_value->ob_srno}}</span> <span class="d-flex">{{date('d M, Y D h:ia',strtotime($ObservationOpen_value->obdatetime))}}</span> <span class="d-flex">{{($ObservationOpen_value->site_name)?$ObservationOpen_value->site_name:$ObservationOpen_value->ob_describethelocation}}</span>
                  <p class="card-text">{{substr($ObservationOpen_value->description,0,57)}}...</p>
                  <div class="gc-observsntitle-userdtl clearfix">
                    <div class="gc-observsntitle-nametag"> @if($ObservationOpen_value->listing_type!=1)<span class="d-flex">By:{{($ObservationOpen_value->ob_fullname)?$ObservationOpen_value->ob_fullname:$ObservationOpen_value->name}} (ID: {{($ObservationOpen_value->ob_empid)?$ObservationOpen_value->ob_empid:$ObservationOpen_value->empid}})</span>@endif <span class="d-flex">{{date('d M, Y D h:ia',strtotime($ObservationOpen_value->created_at))}}</span> </div>
                    <!-- <div class="gc-observsntitle-subtag">
                      <label for="tag">0 of 1 {{__('Closed')}}</label>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
      </div>      
    </div>
  <?php }else{?>
    <div class="pb-5">
    @include('observations.create',compact('cuser'))
    </div>
  <?php }?>
  </div>
<?php if($searchbykeywords){?>
  <div class="innnerrightpanel">    
    <div class="rightpanelinnerbox">
  
    </div>
  </div>
<?php } ?>  

</div>
@endsection 