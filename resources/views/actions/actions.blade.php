@extends('layouts.dashboard')
@section('content')
<div class="mainmidsec">
  <div class="innerleftpanel">
<div class="gc-observsntitle-wrap ">
  <div class="row">
    <div class="col-md-12">
      <div class="gc-obsrvtbsec">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item actionslist1" role="presentation">
            <a class="nav-link active actionslist" data-value="1" id="gc-observsnopen-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="open" aria-selected="true">
            {{__('Open')}} </a>
          </li>
          <li class="nav-item actionslist2"  role="presentation">
            <a class="nav-link actionslist" data-value="2" id="gc-overdue-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="overdue" aria-selected="false">
            {{__('Overdue')}} </a>
          </li>
          <li class="nav-item actionslist3" role="presentation">
            <a class="nav-link actionslist" data-value="3" id="gc-progress-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="progress" aria-selected="false">
             {{__('In Progress')}}
           </a>
         </li>

         <li class="nav-item actionslist4" role="presentation">
          <a class="nav-link actionslist" data-value="4" id="gc-completed-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="completed" aria-selected="false">{{__('Completed')}}
           
         </a>
       </li>
       <li class="nav-item actionslist5" role="presentation">
        <a class="nav-link actionslist" data-value="5" id="gc-observsnclose-tab" data-toggle="tab" href="#gc-observsnopen" role="tab" aria-controls="profile" aria-selected="false">{{__('Closed')}}
        </a>
      </li>

    </ul>
  </div>

  <div class="gc-observsntitle-rightlbl clearfix">
   <ul>                
    <li><a href="#"><i class="fa fa-file-excel gc-excel" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-search gc-search" aria-hidden="true"></i></a></li>
  </ul>
</div>
</div>

</div>   
</div>

<div class="tab-content gc-tabs" id="myTabContent">
  <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel" aria-labelledby="gc-observsnopen-tab">    
    <div class="row">
      <div class="col-md-4">
        <div classs="gc-obserfilter">
          <div class="form-group gcsptreeviewwapepe">                              
            <label >{{__('Type')}}</label>
            <select name="filtercat" class="actionslist oc_id" >
              <option class="c1" value="">{{__('All')}}</option>
              <option class="c1" <?php echo ($filtercat==1)?"selected":""; ?> value="1">{{__('Near Miss')}}</option>
              <option class="c1" <?php echo ($filtercat==2)?"selected":""; ?> value="2">{{__('Incidents')}}</option>  
              <option class="c1" <?php echo ($filtercat==4)?"selected":""; ?> value="4">{{__('Audits')}}</option>  
              </select>                              
            </div>
          </div>    
        </div>
      <div class="col-md-4">
        <div classs="gc-obserfilter gc-calendricon">
          <lable>{{__('Filter by date')}}</lable> <br>
          <input type="text" name="filterdate" autocomplete="off" value="{{$filterdate}}"  class=" gcspdaterangepicker gc-picker actionslist" placeholder="{{date('d M, Y')}}">
          <i class="fa fa-calendar gc-calendricon" aria-hidden="true"></i>
          <input type="hidden" name="ifchaneddate">
        </div>    
      </div>
      
        <div class="col-md-4">
          <div classs="gc-obserfilter">
            <div class="form-group gcsptreeviewwapepe">
                <label >{{__('Site')}}</label>
                <select name="filtersite" class="form-control site_id actionslist" >
                  {!! GetSiteDropDown(null,$filtersite) !!}                  
                </select>
            </div>
            </div>    
          </div>
          <div class="col-md-4 gcspfilterreset">
              <button type="reset" class="btn btn-primary">{{__('Reset')}}</button>
            </div>
        </div> 
      
        <div class="gc-observation-userdtl">
          {{view('actions.actionsajax', compact('ActionsOpen','cuser'))}}
        </div> 
      </div>      
      </div>

</div>
  <div class="innnerrightpanel">    
    <div class="rightpanelinnerbox">
      
    </div>
  </div>
</div>
      @endsection
