{{ view('email.header') }}
<tr>
<td style="padding:15px 10px 15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<table border="0" cellpadding="0" cellspacing="0" style="padding:0 35px">
  <tbody>
    <tr>
        <td style="margin:0px; padding-bottom:20px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">{{__('Dear')}} {{ $username }},</h4></td>
    </tr>
    <tr>
        <td style="margin:0px; padding-bottom:10px;"><h4 style="font-size:17px; font-weight:normal; font-family: 'Roboto', sans-serif;">
          <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin: 0px 0px 20px 0px;">
        {{__('Welcome to the ASARCO Near Miss Reporting software.')}} {{__('Please note, this is only the BETA TEST version!')}}</p>
        <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin: 0px 0px 20px 0px;">{{__('You have been registered by')}} {{ $companyname }} (ASARCO) {{__('to use the system to report and submit any Near Misses. To access your account, please click on the link and log-in using the credentials provided below.')}}</p>
      </td>
    </tr>     
    <tr>
      <td>
        <h4 style="font-size:17px; padding-bottom:20px; font-family: 'Roboto', sans-serif;"><b><u>Account Details</u></b></h4>
        <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin: 0px 0px 5px 0px;"><strong>{{__('Site / Location')}}:</strong> {{ $companyname }}</p>
        <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin: 0px 0px 5px 0px;"><strong>{{__('Email')}}:</strong> {{ $useremail }}</p>
        <p style="font-size:16px; font-family: 'Roboto', sans-serif; margin: 0px 0px 5px 0px;"><strong>{{__('Password')}}:</strong> {{ $password }} </p>
        <p >
          <a href="{{route('login')}}" style="font-size:15px; font-family: 'Roboto', sans-serif; color: #fff; text-decoration: none; background-color: #2ba6e1; padding: 7px 20px; display: inline-block; font-weight: 600; margin: 15px 0px;">{{__('Click Here To Login')}}</a>
        </p>        
        <p style="font-size:16px; font-family: 'Roboto', sans-serif;">{{__('If you have any questions regarding the software or need guidance, please do feel free to email Michael Kovach at mkovach@asarco.com.')}}</p></td>
    </tr>    
    
  </tbody>
</table>
</td>
</tr>
{{ view('email.footer') }}