<table
    cellpadding="0"
    cellspacing="24"
    style="width: 420px; border: 0.5px solid whitesmoke; vertical-align: -webkit-baseline-middle; font-family: Helvetica, Arial, sans-serif; margin: 48px auto;"
>
    <tbody>
    <tr style="padding: 24px; vertical-align: middle;">
        <td>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <img style="height: 30px" src="https://gg-trade.com/frontend/img/logo.png"/>
            </div>
        </td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td>
            <div>
                <span style="font-size: 24px; line-height: 32px; color: #000000; font-weight: bolder;">Welcome to GG-Trade!</span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f6e079;" width="24">
            <table
                cellpadding="0"
                cellspacing="24"
                style="margin:auto auto;"
            >
                <tbody>

                <tr>
                    <td>
                        <p style="font-size: 14px; line-height: 20px;">Hello {{$email_data['name']}},</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p style="font-size: 14px; line-height: 20px;">Please click the below link to verify your email and activate your account.</p>
                    </td>
                </tr>
                <tr>
                    <td style="display: flex; justify-content: center;">
                        @if($email_data['route'] == 'http://127.0.0.1:8000')
                            <a style="background-color: #a7e138; color: white; border: 1px solid #a7e138;border-radius: 5px; padding: 5px 10px" href="http://127.0.0.1:8000/verify?code={{$email_data['verification_code']}}">Click Here!</a>

                        @else
                            <a style=" color: dodgerblue;" href="https://gg-trade.com/-email?code={{$email_data['verification_code']}}">
                                <a style="background-color: #a7e138; color: white; border: 1px solid #a7e138;border-radius: 5px; padding: 5px 10px" href="https://gg-trade.com/verify?code={{$email_data['verification_code']}}">Click Here!</a>
                            </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size: 14px; line-height: 20px;">Got a question? <a style="color: dodgerblue; word-break: break-all; text-decoration: none;" href="mailto:support@gg-trade.com">Reach out to our team</a>, we???ll reply promptly.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font-size: 14px; line-height: 20px; display: flex; flex-direction: column;">
                            <span>Warm Regards,</span>
                            <span>The GG-Trade Team</span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <span style="font-size: 14px; line-height: 20px; color: #818181; text-align: center; display: block;">If you need any help, please contact us <br/> <a style=" color: dodgerblue; text-decoration: none;" href="mailto:info@gg-trade.com">info@gg-trade.com</a></span>
        </td>
    </tr>

    </tbody>
</table>

<div style="background-color: #f6e079; padding: 1% 0; color: black; margin: 2% 10%; margin-bottom: 0; text-align: center; font-size: 23px; font-weight: bolder"> </div>
