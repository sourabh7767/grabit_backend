// Add Firebase products that you want to use
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

// Firebase SDK
firebase.initializeApp({
     apiKey: 'AIzaSyAe951vzeJVfMx9w7_uhyxh6a5HmN2-O00',
    authDomain: 'grabit-b6677.firebaseapp.com',
    databaseURL: 'https://grabit-b6677.firebaseio.com',
    projectId: 'grabit-b6677',
    storageBucket: 'grabit-b6677.appspot.com',
    messagingSenderId: '983966434325',
    appId: '1:983966434325:web:39e446a37fc0cc29483a1c',
});

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message has received : ", payload);
    const title = "First, solve the problem.";
    const options = {
        body: "Push notificaiton!",
        icon: "/icon.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});