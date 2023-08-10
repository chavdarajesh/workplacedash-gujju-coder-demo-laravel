{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('Near Miss updated in')}} {{ get_site_name() }}.</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Near Miss Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Near Miss ID')}}:</strong> {{ $observations['ob_srno'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Near Miss Type')}}:</strong> {{ $observations['observationtype'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Description')}}:</strong> {{ $observations['description'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Sites')}}:</strong> {{ $observations['sites'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Date / Time')}}:</strong> {{ $observations['datetime'] }} </p>
                        @if($observations['risklevel']!=0)  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Risk Potential Level')}}:</strong> {{ __($observations['risklevel']) }}</p>
                        @endif
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Make a suggestion/recommendation')}}:</strong> {{ $observations['comments'] }}</p> 
                        @if($observations['ob_information_required']!='')  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Please give details of information required')}}:</strong> {{ $observations['ob_information_required'] }}</p> 
                        @endif
                      </td>
                    </tr>

                   
                    @if($observations['actions'])
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:20px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Near Miss Actions')}}</h4></td>
                    </tr>
                    <tr>
                      <td style="padding-bottom:20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; border-right:none;">
                          <tr>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Details')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Control')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Responsibility')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Due Date')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Status')}}</th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Remarks')}}</th>
                          </tr>
                          @foreach($observations['actions'] as $action)
                            <tr>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $action['description'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $action['control'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $action['responsibility'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $action['due_date'] }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ __($action['status']) }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $action['remarks'] }}</td>
                            </tr>
                          @endforeach                          
                        </table>
                      </td>
                    </tr>

                    @endif

                     
                  </table></td>
              </tr>
{{ view('email.footer') }}