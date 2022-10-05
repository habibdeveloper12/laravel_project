<!doctype html>
<html lang="en">
<head>
    <title>Customer Support</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-sm-12 m-auto">
            <h3> Ticket number - #{{$email_data['ticket_num']}}  </h3>
            <p> Name: {{$email_data['name']}} </p>
            <p> Subject: {{$email_data['subject']}} </p>
            <p> Order Number: {{$email_data['order_num']}} </p>
            <p> Comment: {{$email_data['comment']}} </p>

            <br/>
            <p> Team, GG-Trade </p>
        </div>
    </div>
</div>

</body>
</html>
