<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
<head>
    <meta charset=&quot;utf-8&quot;>
</head>
<body>
<h2>MICE Event Request</h2>
<div>
    MICE event has been requested.<br>
    <h3>Details </h3>
    <div>
        Name : {{ $mice_name }}<br>
        Participant Number : {{ $num }} <br>
        Start : {{ $from }}<br>
        End : {{ $to }}<br>

    </div>

    please follow this <a href=" {{ $link }}">Link</a> to activate.

</div>
<h3>Requested By:</h3>
<div> {{ $name }}</div>
<div> {{ $email }}</div>
</body>
</html>
