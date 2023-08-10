@extends('layouts.dashboard') 
@section('content')
<div class="pt-3">  
<ul class="nav nav-tabs">
  <li class="nav-item ml-5">
    <a class="nav-link" href="{{route('audits')}}">{{__('Audit-wise')}}</a>
  </li>  
  <li class="nav-item">
    <a class="nav-link active" href="javascript:void(0);">{{__('Site-wise')}}</a>
  </li>  
</ul>
</div>

<div class="gcspfullpagewapper gcspauditsitewise">
    <div class="gcspcategorywapper mb-5">

        <div class="auditstabssite">
            <div class="row customer_sec_row">
                <div class="col-12 col-md-7"><span class="currentyearspan">{{__('Displaying data for')}} {{__('JAN')}} {{date('Y')}} – {{__('DES')}} {{date('Y')}}</span></div>
                <div class="col-md-5 col-12">
                    <div class="tabssection">
                        <div class="row">
                            <div class="col-12">
                                <div class="pull-right">
                                    <div class="filtersearch"><i class="fa fa-search"></i> {{__('Search by Keywords')}} </div>
                                    <div class="filternormal"><i class="fa fa-filter"></i> {{__('Filter by')}} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="searchaudittop">
                <form id="auditsitewisesearch" action="{{route('postsitewise')}}" method="post">
                <input type="text" required name="searchbykeywords" placeholder="{{__('Search by Keywords')}}" class="form-control">
                <button type="submit" class="btn btn-primary ml-2">{{__('Search')}}</button><span class="searchaudittopclose">×</span>
                </form>
            </div>

            <div class="audittopfilter">
                <form id="auditsitewisefilter" autocomplete="off" action="{{route('postsitewise')}}" method="post">
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
              
            <div class="gcspajaxresponcesitevise">
            {!! view('audits.auditsbysitescontent',compact('cuser','Audits','sites','AuditsCountScheduledArr','AuditsCountCompletedArr','year')) !!}
            </div>
        
    </div>
</div>
<div class="modal fade" id="AuditViewMonth" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>    
@endsection 