@extends('layouts.dashboard')

@section('content')
<div class="mainmidsec">
  <div class="innerleftpanel">
  <div class="tableboxshadow">
      <div class="tablepaddacc123">
        <table width="100%" cellpadding="10" class="gcspctitletable table table-hover">
          <tbody><tr>
            <th width="52%">{{__('Audit Name')}} / {{__('Description')}}</th>
            <th width="18%" class="text-right">{{__('Modified On')}}</th>
            <th width="30%"></th>
          </tr>
          @if(count($AuditTemplates))
          @foreach($AuditTemplates as $AuditTemplatesItem)
          <tr class="gcspaudittemplate{{$AuditTemplatesItem->atm_id}}">
            <td>
                <div class="row atm_list">
                    <div class="col-sm-2 atm_icon">
                      @if($AuditTemplatesItem->atm_icon!='')
                        <img  src="{{url('storage/'.$AuditTemplatesItem->atm_icon)}}">
                      @else
                        <img src="{{ asset('images/auditicon.png') }}">
                      @endif
                    </div>
                    <div class="col-sm-10">
                      <h5>{{$AuditTemplatesItem->atm_audit_name}}</h5>
                      <p>{{$AuditTemplatesItem->atm_description}}</p>
                    </div>
                </div>
                
            </td>
            <td align="right">{{date('d M, Y',strtotime($AuditTemplatesItem->updated_at))}}</td>
            <td align="center" class="gcspactiontd{{$AuditTemplatesItem->atm_id}} atm_list">
                <a href="{{route('getsetions',['atm_id'=>$AuditTemplatesItem->atm_id])}}" class="ml-3" title="Form builder"><i class="fa fa-cog"></i></a>
                <a href="javascript:void(0);" class="ml-3" title="Schedule"><i class="fa fa-calendar"></i></a>
                <a href="javascript:void(0);" class="ml-3" title="Clone"><i class="fa fa-clone" ></i></a>
                <a href="{{route('audittemplatesedit',['id'=>$AuditTemplatesItem->atm_id])}}" class="ml-3 audittemplatesedit" title="Edit"><i class="fa fa-edit"></i></a>                
                <a href="{{route('audittemplatesdelete',['id'=>$AuditTemplatesItem->atm_id])}}" class="ml-3 audittemplatesdelete" title="Delete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
          @else
          <tr><td colspan="3"><center>{{__('No se encontraron plantillas de auditoría')}}</center></td></tr>
          @endif                  
          </tbody></table>
      </div>
    </div>
  </div>
 <div class="innnerrightpanel">    
    <div class="rightpanelinnerbox">
      @include('audittemplates.create')
    </div>
  </div>
</div>
@endsection 