@extends('layouts.dashboard') @section('content')
<div class="mainmidsec">
  <div class="innerleftpanel">
    <div class="gc-observsntitle-wrap">
      <div class="row">
        <div class="col-md-12">
          <div class="gc-obsrvtbsec">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation"> <a class="nav-link active observationlist" id="gc-observsnopen-tab" data-value="1" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="open" aria-selected="true">{{__('Open')}} <sub>({{count($ObservationOpen)}})</sub></a> </li>
              <li class="nav-item" role="presentation"> <a class="nav-link observationlist" id="gc-observsnclose-tab" data-value="0" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="profile" aria-selected="false">{{__('Closed')}} <sub>({{count($ObservationClose)}})</sub></a> </li>
              <li class="nav-item" role="presentation"> <a class="nav-link observationlist" id="gc-observsnclose-tab" data-value="2" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="profile" aria-selected="false">{{__('Overdue')}} <sub>({{count($ObservationOverdue)}})</sub></a> </li>
              @if((($cuser->hasRole('Super Admin') ||  $cuser->can('Observations Delete'))))
              <li class="nav-item" role="presentation"> <a class="nav-link observationlist" id="gc-observsndelete-tab" data-value="3" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="profile" aria-selected="false">{{__('Deleted')}} <sub>({{count($ObservationDeleted)}})</sub></a> </li>
              @endif
            </ul>
          </div>
          <div class="gc-observsntitle-rightlbl clearfix">
            <ul>
              <li>
                <input type="radio" value="0" name="riskpotentiallevel" id="riskpotentiallevel0" checked="checked">
                <label for="riskpotentiallevel1" class="riskpotentiallevelinput1"><i class="fa fa-circle minor" data-value="1"  aria-hidden="true"></i>{{__('Minor')}}</label>
                <input type="radio" value="1" name="riskpotentiallevel" id="riskpotentiallevel1" class="observationlist">
              </li>
              <li>
                <label for="riskpotentiallevel2" class="riskpotentiallevelinput2"><i class="fa fa-circle serious" data-value="2"  aria-hidden="true"></i>{{__('Serious')}}</label>
                <input type="radio" value="2" name="riskpotentiallevel" id="riskpotentiallevel2" class="observationlist">
              </li>
              <li>
                <label for="riskpotentiallevel3" class="riskpotentiallevelinput3"><i class="fa fa-circle fatal" data-value="3"  aria-hidden="true"></i>{{__('Fatal')}}</label>
                <input type="radio" value="3" name="riskpotentiallevel" id="riskpotentiallevel3" class="observationlist">
              </li>
              <li><a href="#"><i class="fa fa-file-excel gc-excel" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-search gc-search gcobjsearch" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-content gc-tabs" id="myTabContent">
      <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">

          @csrf
          <div class="row">
            <div class="col-md-4">
              <div classs="gc-obserfilter gc-calendricon">
                <lable>{{__('Filter by date')}}</lable>
                <br>
                <input type="text" name="filterdate" autocomplete="off" value=""  class=" gcspdaterangepicker gc-picker observationlist" placeholder="{{date('d M, Y')}}">
                <input type="hidden" name="ifchaneddate">
                <i class="fa fa-calendar gc-calendricon" aria-hidden="true"></i> </div>
            </div>
            <div class="col-md-4">
              <div classs="gc-obserfilter">
                <div class="form-group gcsptreeviewwapepe">
                  <label >{{__('Category')}}</label>
                  <select  name="filtercat" class="oc_id observationlist"  >

                                  {!! GetCatDropDown(1,$filtercat) !!}

                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div classs="gc-obserfilter">
                <div class="form-group gcsptreeviewwapepe">
                  <label >{{__('Sites')}}</label>
                  <select name="filtersite" class="form-control site_id observationlist" id="exampleFormControlSelect1">
                      {!! GetSiteDropDown(null,$filtersite) !!}
                      <option  value="0">{{__('Unsure / do not know')}}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4 gcspfilterreset">
              <button type="reset" class="btn btn-primary">{{__('Reset')}}</button>
            </div>
          </div>

          <div class="searchaudittop" >
                <form id="auditsitewisesearch" action="{{route('observations')}}" method="get">
                    <input type="text" required="" name="searchbykeywords" placeholder="Buscar por palabras clave" class="form-control">
                    <button type="submit" class="btn btn-primary ml-2">Buscar</button><span class="searchaudittopclose">×</span>
                </form>
            </div>

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
  </div>
  <div class="innnerrightpanel">
    <div class="rightpanelinnerbox">
      @include('observations.create',compact('cuser'))
    </div>
  </div>
</div>
@endsection
