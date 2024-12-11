    <!DOCTYPE html

        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:mso="urn:schemas-microsoft-com:office:office"

    xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">



    <head>

        <title></title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        

    </head>



    <body>
        <div style=" text-align: left; max-width: 700px;">
    <table align="center" width="700" style="font-family: Roboto, sans-serif;font-size: 14px;line-height: 22px;color: #444445;">
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left" valign="middle" style="font-family: Arial, Helvetica, sans-serif;font-size: 11px;line-height: 16px;color: #555555;padding-top: 10px;padding-right: 0;padding-bottom: 10px;padding-left: 0;">
                    <span style="font-size: 16px; font-weight: 700; color: #256fbd">Welcome to Compliance Reward℠</span>
                </td>
                <td align="right" valign="middle" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px; color: #555555; padding-top: 10px; padding-right: 20px; padding-bottom: 0; padding-left: 20px">
                    <a>
                        <img src="{{asset('images/logo-login.png')}}" style="width: 160px; max-width: 170px" class="CToWUd">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table align="center" width="600" style="border: 8px solid #b3d5e8;padding: 0 20px;font-family: Roboto, sans-serif;font-size: 15px;line-height: 22px;color: #444445;padding: 0 20px 10px 20px;">
            <tbody>
                <tr>
                    <td>
                        <p style="font-size: 15px; text-align: left; color: #666666; font-weight: 600; padding: 0px; margin-top: 15px; background-color: #fff">{{ $user['name'] }},</p>
                        <p style="font-size: 15px;color: #3e7bc4;font-weight: normal;text-align: left;padding: 0px;margin-top: 0px;margin-bottom: 15px;background-color: #fff;">Thank you for your enrollment into the Compliance Reward℠ program! 
                            <b style="font-weight: 600; color: #000">Your&nbsp;practice&nbsp;has been&nbsp;registered&nbsp;successfully.</b>
                        </p>
                        <p style="font-size: 15px;text-align: left;margin-bottom: 5px;color: #cecece;">To activate your practice account:</p>
                        <p></p>
                        <ol style="color: #3e7bc4;text-align: left;">
                            <li>Website:&nbsp;&nbsp;
                                <strong>
                                    <a href="{{url('/')}}" style="color: #2c6fb7;">www.compliancereward.com/{{strtoupper($user['type'])}}</a>
                                </strong>
                            </li>
                            <li>Initial Password:&nbsp;&nbsp;
                                <strong>{{ $user['password'] }}</strong>
                            </li>
                        </ol>
                        <p style="line-height: 15px; font-size: 1px">&nbsp;</p>
                        <p style="line-height: 1.2em;text-align: center;max-width: 480px;color: #3e7bc4;">As a {{strtoupper($user['type'])}} Enrollee; your credentials will permit you exclusively access to compliance status of patients that {{ $user['type'] =='Pharmacy' ? ' your '.strtoupper($user['type']):' you ' }} enroll into the COMPLIANCE REWARD program</p>
                        <p style="line-height: 15px; font-size: 1px">&nbsp;</p>
                        <p style="line-height: 15px;font-size: 14px;color: #3e7bc4;">
                            <a href="{{url('our-terms')}}" style="color: #3e7bc4;font-size: 12px;">Terms of Use</a>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #fff;font-family: Roboto, sans-serif;color: #cecece;">
            <tbody>
                <tr>
                    <td style="padding: 0px;">
                        <p style="margin: 0px;">&nbsp;</p>
                        <p style="font-size: 13px;text-align: left;color: #cecece;margin: 0px;">Please add 
                            <a href="mailto:noreply@compliancereward.com" target="_blank" style="color: #cecece;">noreply@compliancereward.com</a> to your address book or safe sender list so our e-mails get to your inbox. We are committed to protecting your privacy. Your information is kept private and confidential, For information about our privacy policy, visit 
                            <a href="" target="_blank"  style="color: #cecece;">www.compliancereward.com/
                                <wbr>privacy
                                </a>. If you\'d like to contact us, please send us an email to; 
                                <a href="mailto:info@compliancereward.com" target="_blank" style="color: #cecece;">info@compliancereward.com</a> or call 1-855-COMPLIANCEREWARD.
                            </p>
                            <p style="font-size: 13px;text-align: left;color: #cecece;">If you no longer wish to receive these communications, you can 
                                <a style="color: #2e9fff">unsubscribe</a>.
                            </p>
                            <div style="line-height: 15px; font-size: 1px">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="yj6qo"></div>
            <div class="adL"></div>
        </div>
                </body>

                </html>