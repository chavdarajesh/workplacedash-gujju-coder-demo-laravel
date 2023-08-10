@extends('layouts.dashboard') 
@section('content')
<div class="pt-3">
  
<ul class="nav nav-tabs">
  <li class="nav-item ml-5">
    <a class="nav-link active" href="javascript:void(0);">{{__('Audit-wise')}}</a>
  </li>  
  <li class="nav-item">
    <a class="nav-link" href="{{route('sitewise')}}">{{__('Site-wise')}}</a>
  </li>  
</ul>
</div>
<div class="gcspfullpagewapper">

    <div class="gc-observsntitle-wrap ">
        <div class="row">
            <div class="col-md-12">
                <div class="gc-obsrvtbsec">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item 1" role="presentation"> <a class="nav-link active getauditbystatus" data-value="1"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="open" aria-selected="true"> {{__('Scheduled')}}(<span>{{$AuditsScheduled}}</span>) </a> </li>
                        <li class="nav-item 2" role="presentation"> <a class="nav-link getauditbystatus" data-value="2"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="overdue" aria-selected="false">{{__('In Progress')}}(<span>{{$AuditsInprogress}}</span>) </a> </li>
                        <li class="nav-item 3" role="presentation"> <a class="nav-link getauditbystatus" data-value="3"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="progress" aria-selected="false">{{__('Overdue')}}(<span>{{$AuditsOverdue}}</span>)</a> </li>
                        <li class="nav-item 4" role="presentation"> <a class="nav-link getauditbystatus" data-value="4"  data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="completed" aria-selected="false">{{__('Completed')}}(<span>{{$AuditsCompleted}}</span>)</a> </li>
                        <li class="nav-item 5" role="presentation"> <a class="nav-link getauditbystatus" data-value="5" data-toggle="tab" href="#gc-audtis" role="tab" aria-controls="profile" aria-selected="false">{{__('Approved')}}(<span>{{$AuditsApproved}}</span>)</a> </li>
                    </ul>
                </div>
                <div class="gc-observsntitle-rightlbl clearfix">
                    <ul>
                        <li><a href="javascript:void(0);" class="filtersearch"><i class="fa fa-search gc-search " aria-hidden="true"></i>{{__('Search by Keywords')}}</a></li>
                        <li><a href="javascript:void(0);" class="filternormal"><i class="fa fa-filter gc-excel " aria-hidden="true"></i>{{__('Filter by')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="searchaudittop">
                <form id="auditsitewisesearch" action="{{route('postauditwise')}}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="1">    
                    <input type="text" required name="searchbykeywords" placeholder="{{__('Search by Keywords')}}" class="form-control">
                    <button type="submit" class="btn btn-primary ml-2">{{__('Search')}}</button><span class="searchaudittopclose">×</span>
                </form>
            </div>

            <div class="audittopfilter">
                <form id="auditsitewisefilter" autocomplete="off" action="{{route('postauditwise')}}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="1">    
                <div class="audittopfilterinner">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label >{{__('Frequency')}}</label>
                                <select  class="form-control" name="adm_af_id">
                                    {!! GetAuditFrequencyDropDown() !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group gcsptreeviewwapepe">
                                <label for="exampleInputEmail1">{{__('Select Site(s)')}}</label>
                                <select class="site_id3" data-formtype="add" name="adm_site_id">
                                    {!! GetSiteDropDown() !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label >{{__('Audit Type')}}</label>
                                <select name="adm_ac_id" class="form-control" >
                                    {!! GetCatDropDown(4) !!}                                                                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label >{{__('Date Range')}}</label>
                                <input autocomplete="off" type="text" value="" class="gcspdaterangepicker form-control" name="filterdate" placeholder="{{__('Select date & time')}}">
                            </div>
                        </div>
                    </div>    
                </div> 
                <div class="d-inline-block audittopfilterinner2">                       
                    <button type="submit" class="btn btn-primary ml-2">{{__('Filtrar')}}</button><span class="searchaudittopclose">×</span>
                </div>
                </form>
            </div>  
    <div class="tab-content gc-tabs" id="myTabContent">
        <div class="tab-pane fade active show" id="gc-audtis" role="tabpanel" aria-labelledby="gc-observsnopen-tab"> 
            <div class="gcspauditlistresponce gcspajaxresponcesitevise">
                {!! view('audits.audits_list',compact('Audits')) !!}
            </div>
        </div>
    </div>        

</div>
@include('audits.create')
<div class="modal fade" id="AuditEditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>    
@endsection 