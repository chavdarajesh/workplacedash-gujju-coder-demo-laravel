{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('Incidents updated in')}} {{ get_site_name() }}.</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Incidents Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incidents Type')}}:</strong> {{ $incidents['incidentsype'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Reported by')}}:</strong> {{ $incidents['reportedby'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Sites')}}:</strong> {{ $incidents['sites'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Shift')}}:</strong> {{ $incidents['shift'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Date / Time')}}:</strong> {{ $incidents['datetime'] }} </p>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Description')}}:</strong> {{ $incidents['description'] }}</p>
                      </td>
                    </tr> 
                    @if($incidents['victims'])
                     <tr>
                      <td style="padding-bottom:20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; border-right:none; margin-top: 20px; margin-bottom: 20px;">
                          <tr>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Name of victim')}}  </th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Age range')}}</th>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Gender')}}</th>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Details of injury')}}</th>                            
                          </tr>
                          @foreach($incidents['victims'] as $VictimItem)
                            <tr>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $VictimItem->iv_name }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $VictimItem->iv_age_range }}</td>                              
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ GetGender($VictimItem->iv_gender) }}</td>                              
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $VictimItem->iv_details_injury }}</td>                              
                            </tr>
                          @endforeach                          
                        </table>
                      </td>
                    </tr>  
                    @endif

                  </table></td>
              </tr>
{{ view('email.footer') }}