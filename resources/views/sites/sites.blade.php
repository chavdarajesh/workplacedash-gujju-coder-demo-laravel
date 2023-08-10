@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
@if($cuser->can('Sites Add'))
<a class="btn btn-primary mb-3" href="{{route('sitescreate')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('New')}}</a>
@endif
<div class="gc-observsntitle-wrap ">
    <div class="row">
        <div class="col-md-12">
            <div class="gc-obsrvtbsec">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="gc-observsnopen-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="open" aria-selected="true">{{__('Active Sites')}} <sub>({{count($sitesActive)}})</sub></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnclose" role="tab" aria-controls="profile" aria-selected="false">{{__('Inactive Sites')}} <sub>({{count($sitesInactive)}})</sub></a>
                  </li>
                </ul>
            </div>
       </div>
    </div>   
</div>
<div class="tab-content gc-tabs" id="myTabContent">
        <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">
          <table class="table gcspmaintable">
            <thead>
              <tr>      
                <th scope="col">{{__('Site Name')}}</th>
                <th scope="col">{{__('Division')}}</th>
                <th scope="col">{{__('Department')}}</th>
                <th scope="col">{{__('Unit')}}</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($sitesActive)){ ?>
                <?php foreach ($sitesActive as $key => $value) {?>
                  
                <tr>      
                  <td><a href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{$value->site_name}} </a>
                    @if($cuser->can('Sites Edit'))
                    <a href="{{ route('sitesedit',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
                    @endif
                    @if($cuser->can('Sites Delete'))
                    <a onclick="return confirm('Are you sure you want to delete this site.');" href="{{ route('sitesdelete',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a>
                    @endif
                  </td>                  
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,2)}}</a></td>
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,3)}}</a></td>
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,4)}}</a></td>
                </tr>

              <?php } ?>
            <?php }else{ ?>
              <tr>      
                <td colspan="4" align="center"><b>{{__('No sites found')}}.</b></td>      
              </tr> 
            <?php } ?>     
            </tbody>
          </table>
        </div>

        <div class="tab-pane fade" id="gc-observsnclose" role="tabpanel" aria-labelledby="gc-observsnclose-tab">
             <table class="table gcspmaintable">
            <thead>
              <tr>      
                <th scope="col">{{__('Site Name')}}</th>
                <th scope="col">{{__('Division')}}</th>
                <th scope="col">{{__('Department')}}</th>
                <th scope="col">{{__('Unit')}}</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($sitesInactive)){ ?>
                <?php foreach ($sitesInactive as $key => $value) {?>
                  
                <tr>      
                  <td><a href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{$value->site_name}} </a> <a href="{{ route('sitesedit',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a><a href="{{ route('sitesdelete',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a></td>
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,2)}}</a></td>
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,3)}}</a></td>
                  <td><a class="d-block" href="{{ route('getdivisions',['id'=>$value->id]) }}" >{{GetSiteArea($value->id,4)}}</a></td>
                </tr>

              <?php } ?>
            <?php }else{ ?>
              <tr>      
                <td colspan="4" align="center"><b>{{__('No sites found')}}.</b></td>      
              </tr> 
            <?php } ?>     
            </tbody>
          </table>
        </div>  
      </div>
</div>
@endsection
