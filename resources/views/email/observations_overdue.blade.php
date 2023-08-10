{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('Near Miss status has been changed in')}} {{ get_site_name() }}.</p>
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
                      </td>
                    </tr>

                  
                     
                  </table></td>
              </tr>
{{ view('email.footer') }}