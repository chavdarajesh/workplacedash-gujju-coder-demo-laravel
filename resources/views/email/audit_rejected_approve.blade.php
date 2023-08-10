{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{$subject}}.</p>
                        @if($reject_note)
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{$reject_note}}.</p>
                        @endif
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Audit Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Name')}}:</strong> {{ $Audits->atm_audit_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Sites')}}:</strong> {{ $Audits->site_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Auditor')}}:</strong> {{ $Audits->auditor }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Frequency')}}:</strong> {{ $Audits->af_name }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Audit Type')}}:</strong> {{ $Audits->category_name }} </p>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Start from')}}:</strong> {{date('d M, Y',strtotime($Audits->adm_start_from))}}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('End on')}}:</strong> {{date('d M, Y',strtotime($Audits->adm_end_on))}}</p>
                      </td>
                    </tr>                     
                  </table></td>
              </tr>
{{ view('email.footer') }}