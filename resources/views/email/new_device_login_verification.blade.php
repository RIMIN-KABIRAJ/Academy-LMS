<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{get_settings('system_title')}}</title>
</head>
<body>
    <p>{{get_phrase('You need to confirm that you want to login from this device')}}.</p><p>{{get_phrase('Please note that if you login from this device, your previously logged in device will be logged out.')}}.</p>
    <a href="{{$verification_link}}">{{get_phrase('Got it, login now')}}</a>
</body>
</html>