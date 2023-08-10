{{ view('email.header') }}
<tr>

                <td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('The following action has been assigned and notified to the Process Owner / Area-In-Charge in')}} {{$sitesname}}.</p>                        
                      </td>
                    </tr>

                   
                    @if($action)
                    <tr>
                      <td style="padding-bottom:20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; border-right:none;">
                          <tr style="vertical-align: top;">                                                        
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Control')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Description')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Assigned to')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Due Date')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Status')}}</th>                            
                          </tr>                          
                            <tr style="vertical-align: top;">                              
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;">{{ $action['control']  }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;">{{ $action['description'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;">{{ $action['responsibility'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;">{{ $action['due_date'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;">{{ __($action['status']) }}</td>
                            </tr>                           
                        </table>
                      </td>
                    </tr>
                    @endif
                  </table></td>
</tr>    
{{ view('email.footer') }}