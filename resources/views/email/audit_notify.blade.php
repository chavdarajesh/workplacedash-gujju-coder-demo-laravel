{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{$cuser->name}} {{__('wishes to notify you on this observation during the')}} {{ $Audits->af_name }} {{ $Audits->atm_audit_name }} {{__('performed on')}} {{date('d M, Y',strtotime($Audits->adm_start_from))}}. {{__('The details are given below.')}}</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Audit Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Name')}}:</strong> {{ $Audits->atm_audit_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Sites')}}:</strong> {{ $Audits->site_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Auditor')}}:</strong> {{ $Audits->auditor }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Frequency')}}:</strong> {{ $Audits->af_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Type')}}:</strong> {{ $Audits->category_name }} </p>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Start From')}}:</strong> {{date('d M, Y',strtotime($Audits->adm_start_from))}}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Name of the Auditee')}}:</strong> {{$cuser->name}}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Checklist Question')}}:</strong> {{$getauditQuestion->atpq_question}} d</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Checklist Response')}}:</strong> 
                          {!! view('email.audit_answes',compact('getauditQuestion','getauditQuestionAns','CheckBoxQuestionOption','GridViewOption')) !!}
                        </p>
                        
                      </td>
                    </tr>                     
                  </table></td>
              </tr>
{{ view('email.footer') }}