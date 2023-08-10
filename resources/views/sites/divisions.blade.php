@extends('layouts.dashboard')
@section('content')
<div class="gcspfullpagewapper">
<div class="gc-form-title">
 <h5>{{$Sites->site_name}}</h5>
</div>
<div class="card mb-5" >
<div class="card-body">
    <div class="row">
      <div class="col-sm-4">
        <i class="fa fa-user mr-2"></i>{{__('Head of Safety')}}
        <?php $headofsafetyname=GetHeadofSafety($Sites->id,'name'); ?>
        <span class="d-block"><?php  echo implode(', ',$headofsafetyname);?></span>
        
      </div>
      <div class="col-sm-4">
        <i class="fa fa-user mr-2"></i>{{__('Head of Site')}}
        <span class="d-block">-</span>        
      </div>
      <div class="col-sm-4">
        <i class="fa fa-phone-square mr-2"></i>{{__('Emergency Contacts')}}
        <span class="d-block"><a href="mailto:"{{$Sites->sos_email}}">{{$Sites->sos_email}}</a></span>
        <span class="d-block"><a href="tel:"{{$Sites->sos_mobile}}">{{$Sites->sos_mobile}}</a></span>
      </div> 
</div>
</div>                  
</div>


@if($cuser->can('Sites Add'))
<a class="btn btn-primary mb-3" href="{{route('adddivisions',['site_id'=>$Sites->id])}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('New Divisions')}}</a>
@endif
<div class="tableboxshadow gcspsitedevisionwapper ">
  <div class="tablepaddacc">
    <table width="100%" cellpadding="10" class="gcspctitletable">
      <tbody>        
        @if(count($SiteDivistion)==0)    
        <tr>
          <th width="40%" colspan="4"><center>{{__('No Divistions Found')}}</center></th>          
        </tr>        
        @else
        <tr>
          <th width="40%">{{__('Divisions')}}</th>
          <th width="20%">{{__('Head')}}</th>
          <th width="20%">{{__('Supervisor')}}</th>
          <th width="20%">{{__('Status')}}</th>
        </tr>
        @endif
      </tbody>

    </table>
  </div>
  @if(count($SiteDivistion))    
  <div class="accordion" id="accordionExample">
    <div class="card">
      <?php foreach ($SiteDivistion as $dkey => $SiteDivistionvalue) {?>          

        <div class="card-header collapsed" id="heading{{$dkey}}" data-toggle="collapse" data-target="#collapse{{$dkey}}" aria-expanded="false" aria-controls="collapse{{$dkey}}">
          <table width="100%" cellpadding="10">
            <tbody>
              <tr class="gcspsiteareatable">
                <th width="40%" class="listarrowicon">
                  {{$SiteDivistionvalue->site_name}}
                  @if($cuser->can('Sites Edit'))
                    <a href="{{ route('sitesedit',['id'=>$SiteDivistionvalue->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
                    @endif
                    @if($cuser->can('Sites Delete'))
                    <a onclick="return confirm('Are you sure you want to delete this Divistion.');" href="{{ route('deletearea',['id'=>$SiteDivistionvalue->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a>
                    @endif
                </th>
                <th width="20%" class="gcspchangecolor">
                    <?php $headofsafetyname=GetHeadofSafety($SiteDivistionvalue->id,'name');
                        echo implode(', ',$headofsafetyname);
                    ?>
                </th>
                <th width="20%" class="gcspchangecolor">{{$SiteDivistionvalue->superviser}}</th>
                <th width="20%" class="gcspchangecolor">{{($SiteDivistionvalue->status==1)?__('Active'):__('Inactive')}}</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="collapse{{$dkey}}" class="collapse" aria-labelledby="heading{{$dkey}}" data-parent="#accordionExample" style="">
          <div class="card-body1">
            <ul class="gcspcategortulsite">
              <li>
                {{__('Departments')}} <span ><a class="ml-5" href="{{route('adddepartment',['site_id'=>$Sites->id,'divi_id'=>$SiteDivistionvalue->id])}}">{{__('Add new')}}</a></span>
              </li>
              

                <?php 
                if(array_key_exists($SiteDivistionvalue->id, $SiteDipartment)){?>
                <li class="gcspinnerlipadding">  
                <div class="accordion" id="accordionExample{{$SiteDivistionvalue->id}}">  
                <?php foreach ($SiteDipartment[$SiteDivistionvalue->id] as $key => $SiteDepartmentvalue) { $ddkey=$SiteDepartmentvalue->id;?>          
                  <div class="card-header card-header-inner collapsed" id="heading{{$ddkey}}" data-toggle="collapse" data-target="#collapse{{$ddkey}}" aria-expanded="false" aria-controls="collapse{{$ddkey}}">
                    <table width="100%" cellpadding="10">
                      <tbody>
                        <tr class="gcspsiteareatable">
                          <th width="40%" class="listarrowicon">
                            {{$SiteDepartmentvalue->site_name}}
                              @if($cuser->can('Sites Edit'))
                              <a href="{{ route('sitesedit',['id'=>$SiteDepartmentvalue->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
                              @endif
                              @if($cuser->can('Sites Delete'))
                              <a onclick="return confirm('Are you sure you want to delete this Department.');" href="{{ route('deletearea',['id'=>$SiteDepartmentvalue->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a>
                              @endif
                          </th>
                          <th width="20%" class="gcspchangecolor">
                            <?php $headofsafetyname=GetHeadofSafety($SiteDepartmentvalue->id,'name');
                                          echo implode(', ',$headofsafetyname);
                            ?></th>
                          <th width="20%" class="gcspchangecolor">{{$SiteDepartmentvalue->superviser}}</th>
                          <th width="20%" class="gcspchangecolor">{{($SiteDepartmentvalue->status==1)?__('Active'):__('Inactive')}}</th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="collapse{{$ddkey}}" class="collapse" aria-labelledby="heading{{$ddkey}}" data-parent="#accordionExample{{$SiteDivistionvalue->id}}" style="">
                    <div class="card-body1">
                      <ul class="gcspcategortulsite">
                        <li class="pl-5">
                          {{__('Units')}} <span ><a class="ml-5" href="{{route('addaddunit',['site_id'=>$Sites->id,'dep_id'=>$SiteDepartmentvalue->id])}}">{{__('Add new')}}</a></span>
                        </li>
                          <?php  if(array_key_exists($SiteDepartmentvalue->id, $SiteUnit)){
                            foreach ($SiteUnit[$SiteDepartmentvalue->id] as $key => $SiteUnitvalue) {
                          ?>
                            <li class="gcspinnerlipadding">
                                <table width="100%" cellpadding="10">
                                  <tbody>
                                    <tr class="gcspsiteareatable">
                                      <th width="40%" class="listarrowicon pl-5">
                                        {{$SiteUnitvalue->site_name}}
                                        @if($cuser->can('Sites Edit'))
                                        <a href="{{ route('sitesedit',['id'=>$SiteUnitvalue->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if($cuser->can('Sites Delete'))
                                        <a  onclick="return confirm('Are you sure you want to delete this Unit.');" href="{{ route('deletearea',['id'=>$SiteUnitvalue->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a>
                                        @endif
                                      </th>
                                      <th width="20%" class="gcspchangecolor">
                                        <?php $headofsafetyname=GetHeadofSafety($SiteUnitvalue->id,'name');
                                          echo implode(', ',$headofsafetyname);
                                        ?>
                                      </th>
                                      <th width="20%" class="gcspchangecolor">{{$SiteUnitvalue->superviser}}</th>
                                      <th width="20%" class="gcspchangecolor">{{($SiteUnitvalue->status==1)?__('Active'):__('Inactive')}}</th>
                                    </tr>
                                  </tbody>
                                </table>
                            </li>
                          <?php } } ?>  
                      </ul>
                    </div>
                  </div>
                <?php }  ?>  
                </div>
                </li>
                <?php }  ?>

              
            </ul>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  @endif
</div>
</div>
@endsection
