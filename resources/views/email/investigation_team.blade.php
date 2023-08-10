{{ view('email.header') }}
<tr>
                <td style="padding:15px 10px 15px 10px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('An investigation team has been formed for a')}} {{ $incidents['rating_text'] }} {{ $incidents['incidentsype'] }} {{__('Incident')}} {{ $incidents['im_srno'] }} {{__('with a severity rating')}} {{ $incidents['severity'] }} & {{ $incidents['likelihood'] }} ( {{ $incidents['rating'] }} - {{ $incidents['severity'] }} ). {{__('View the details of the incident and investigation team below.')}}</p>
                        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;">{{__('Incidents Details')}}</h4>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incidents Type')}}:</strong> {{ $incidents['incidentsype'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Reported by')}}:</strong> {{ $incidents['reportedby'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incident Severity')}}:</strong> {{ $incidents['severity'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incident Likelihood')}}:</strong> {{ $incidents['likelihood'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incident Rating')}}:</strong> {{ $incidents['rating'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Incident Risk Level')}}:</strong> {{ $incidents['rating_text'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Area')}}:</strong> {{ $incidents['sites'] }}</p>
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif;"><strong>{{__('Date / Time')}}:</strong> {{ $incidents['datetime'] }} </p>  
                        <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin-bottom: 15px;"><strong>{{__('Description')}}:</strong> {{ $incidents['description'] }}</p>
                      </td>
                    </tr> 

                    
                    <tr>
                      <td style="padding-bottom:20px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc; border-right:none;">
                          <tr>                            
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Team Member Name')}}  </th>
                            <th style="padding:10px; background-color:#1f365c; color:#fff; border-right:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif; text-align:left; font-weight:700;">{{__('Role')}}</th>                            
                          </tr>
                          @foreach($TeamUsers as $TeamUsersItem)
                            <tr>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $TeamUsersItem->name }}</td>
                              <td style="padding:10px; border-right:1px solid #ccc; border-top:1px solid #ccc; font-size:16px; font-family: 'Roboto', sans-serif;vertical-align: top;">{{ $TeamUsersItem->r_name }}</td>                              
                            </tr>
                          @endforeach                          
                        </table>
                      </td>
                    </tr>



                  </table></td>
              </tr>
{{ view('email.footer') }}