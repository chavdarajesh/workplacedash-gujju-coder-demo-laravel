{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('New incidents created in')}} {{ get_site_name() }}.</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Incidents Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incidents Type')}}:</strong> {{ $incidents['incidentsype'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Reported by')}}:</strong> {{ $incidents['reportedby'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Sites')}}:</strong> {{ $incidents['sites'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Shift')}}:</strong> {{ $incidents['shift'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Date / Time')}}:</strong> {{ $incidents['datetime'] }} </p>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Description')}}:</strong> {{ $incidents['description'] }}</p>
                      </td>
                    </tr>                     
                  </table></td>
              </tr>
{{ view('email.footer') }}