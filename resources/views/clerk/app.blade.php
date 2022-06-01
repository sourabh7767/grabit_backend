@include('clerk.layout.header')


@include('clerk.layout.menu')

@yield('content')


@include('clerk.layout.footer')



<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js"></script>

<script>
    var firebaseConfig = {
        apiKey: 'AIzaSyAe951vzeJVfMx9w7_uhyxh6a5HmN2-O00',
        authDomain: 'grabit-b6677.firebaseapp.com',
        databaseURL: 'https://grabit-b6677.firebaseio.com',
        projectId: 'grabit-b6677',
        storageBucket: 'grabit-b6677.appspot.com',
        messagingSenderId: '983966434325',
        appId: '1:983966434325:web:39e446a37fc0cc29483a1c',
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: 'https://apps-valley.net/public/clerk/save-token',
                        type: 'POST',
                        data: {
                            user_id: {!! json_encode($user_id ?? '') !!},
                            fcm_token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (err) {
                            console.log(" Can't do because: " + err);
                        },
                    });
                })
                .catch(function (err) {
                    console.log("Unable to get permission to notify.", err);
                });

    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
@yield('customr_is')