<!DOCTYPE html>

<head>
    <title>{{$class->title}} | {{get_phrase('Live Class')}}</title>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />
    <script src="{{ asset('assets/global/jquery/jquery-3.7.1.min.js') }}"></script>
    <style type="text/css">
        .ax-outline-blue-important:first-child {
            display: none !important;
        }
    </style>
</head>

<body>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-3.1.6.min.js"></script>

    @php
        $meeting_info = json_decode($class->joining_data, true);
    @endphp

    <script>
        var mn = "{{ $meeting_info['id'] }}";
        var user_name = "{{ $user->name }}";
        var pwd = "{{ $meeting_info['password'] }}";
        var role = {{ isset($is_host) ? 1 : 0 }};
        var email = "{{ $user->email }}";
        var lang = "en-US";
        var china = 0;
        var sdkKey = "{{ get_settings('zoom_sdk_client_id') }}";
        var sdkSecret = "{{ get_settings('zoom_sdk_client_secret') }}";
        var leaveUrl = "{{$_SERVER['HTTP_REFERER']}}";

        console.log(mn,user_name,pwd,role,email,lang,china,sdkKey,sdkSecret,leaveUrl)


        //Generate signature here
        ZoomMtg.generateSDKSignature({
            meetingNumber: mn,
            sdkKey: sdkKey,
            sdkSecret: sdkSecret,
            role: role,
            success: function(signature) {
                console.log(ZoomMtg.checkSystemRequirements())
                console.log(signature)

                //After generating the signature, initializing the meeting
                ZoomMtg.preLoadWasm();
                ZoomMtg.prepareWebSDK();
                ZoomMtg.i18n.load(lang);
                ZoomMtg.init({
                    leaveUrl: leaveUrl,
                    disableCORP: !window.crossOriginIsolated, // default true
                    success: function() {

                        //Join to the meeting
                        ZoomMtg.join({
                            meetingNumber: mn,
                            userName: user_name,
                            signature: signature,
                            sdkKey: sdkKey,
                            userEmail: email,
                            passWord: pwd,
                            success: function(res) {
                                console.log("join meeting success");
                                console.log("get attendeelist");
                                ZoomMtg.getAttendeeslist({});
                                ZoomMtg.getCurrentUser({
                                    success: function(res) {
                                        console.log("success getCurrentUser", res.result.currentUser);
                                    },
                                });
                            },
                            error: function(res) {
                                console.log(res);
                            },
                        });
                    },
                    error: function(res) {
                        console.log(res);
                    },
                });

                ZoomMtg.inMeetingServiceListener("onUserJoin", function(data) {
                    console.log("inMeetingServiceListener onUserJoin", data);
                });

                ZoomMtg.inMeetingServiceListener("onUserLeave", function(data) {
                    console.log("inMeetingServiceListener onUserLeave", data);
                });

                ZoomMtg.inMeetingServiceListener("onUserIsInWaitingRoom", function(data) {
                    console.log("inMeetingServiceListener onUserIsInWaitingRoom", data);
                });

                ZoomMtg.inMeetingServiceListener("onMeetingStatus", function(data) {
                    console.log("inMeetingServiceListener onMeetingStatus", data);
                });
            },
        });
    </script>
</body>

</html>
