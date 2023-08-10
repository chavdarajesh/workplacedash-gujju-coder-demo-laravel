{{ view('email.header') }}
 <tr><td>
                <table cellpadding="0" cellspacing="0" style="width:100%">
                  <tr>
                    <td>
                      <h3><br/>{{__('Hello!')}}</h3>
                      <p>{{__('Please click the button below to verify your email address.')}}</p>
                      <p style="text-align: center;" ><a style="box-sizing: border-box; text-align: center; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;" href="{{$url}}">{{__('Verify Email Address')}}</a></p> 
                      <p>{{__('If you did not create an account, no further action is required.')}}</p>                      
                    </td>
                  </tr>
                </table>
                <table  cellpadding="0" cellspacing="0"  style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-top:1px solid #e8e5ef;margin-top:25px;padding-top:25px;width:100%">
                  
                    <tr>
                      <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                        <p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';line-height:1.5em;margin-top:0;text-align:left;font-size:14px"> {{__("If you’re having trouble clicking the 'Verify Email Address' button, copy and paste the URL below into your web browser")}}: <span style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';word-break:break-all"><a href="{{$url}}" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3869d4" target="_blank" >{{$url}}</a></span></p>
                      </td>
                    </tr>
                  
                </table>
            </td>
            </tr>

{{ view('email.footer') }}