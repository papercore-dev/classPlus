<?php
chdir(dirname(__FILE__));
include '../../security.php';
chdir(dirname(__FILE__));?>
<div class="pb-32"></div>
<nav class="rounded-t-xl bottomNav shadow-lg max-w-md visible fixed bottom-0 w-full border bg-white flex overflow-x-auto">

<a href="javascript:Turbo.visit(`/chat.php`, { action: 'replace' })" class="pt-2 pb-2 flex flex-col flex-grow items-center justify-center
		overflow-hidden whitespace-no-wrap text-sm transition-colors duration-100
		ease-in-out hover:bg-gray-200 focus:text-orange-500">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
</svg>

<span class="text-sm capitalize">채팅</span>
</a>

<a href="javascript:Turbo.visit(`/calendar.php`, { action: 'replace' })" class="pt-2 pb-2 flex flex-col flex-grow items-center justify-center
		overflow-hidden whitespace-no-wrap text-sm transition-colors duration-100
		ease-in-out hover:bg-gray-200 focus:text-orange-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
</svg>

<span class="text-sm capitalize">캘린더</span>
</a>

<a href="javascript:Turbo.visit(`/app.php`, { action: 'replace' })" class="pt-2 pb-2 rounded-full bg-blue-500 hover:bg-blue-700 text-white flex flex-col flex-grow items-center justify-center
		overflow-hidden whitespace-no-wrap text-sm">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>


<span class="text-sm capitalize">홈</span>
</a>

<a href="javascript:Turbo.visit(`/explore.php`, { action: 'replace' })" class="pt-2 pb-2 flex flex-col flex-grow items-center justify-center
		overflow-hidden whitespace-no-wrap text-sm transition-colors duration-100
		ease-in-out hover:bg-gray-200 focus:text-orange-500">
    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px">    <path d="M 12 2 C 6.477 2 2 6.477 2 12 C 2 17.523 6.477 22 12 22 C 17.523 22 22 17.523 22 12 C 22 6.477 17.523 2 12 2 z M 12 4 C 16.418 4 20 7.582 20 12 C 20 16.418 16.418 20 12 20 C 7.582 20 4 16.418 4 12 C 4 7.582 7.582 4 12 4 z M 17 7 L 10.175781 10.175781 L 7 17 L 13.824219 13.824219 L 17 7 z M 12 10.900391 C 12.61 10.900391 13.099609 11.39 13.099609 12 C 13.099609 12.61 12.61 13.099609 12 13.099609 C 11.39 13.099609 10.900391 12.61 10.900391 12 C 10.900391 11.39 11.39 10.900391 12 10.900391 z"/></svg>


<span class="text-sm capitalize">탐색</span>
</a>

<a href="javascript:Turbo.visit(`/menu.php`, { action: 'replace' })" class="pt-2 pb-2 flex flex-col flex-grow items-center justify-center
		overflow-hidden whitespace-no-wrap text-sm transition-colors duration-100
		ease-in-out hover:bg-gray-200 focus:text-orange-500">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
</svg>

<span class="text-sm capitalize">전체</span>
</a>
</nav>

</div>
  </div>
  <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
  <script>
    var firebaseConfig = {
    apiKey: "AIzaSyDAl4MUKtOrC056SrxcAB_Ju42u30OPSYo",
    authDomain: "classplus-6299c.firebaseapp.com",
    projectId: "classplus-6299c",
    storageBucket: "classplus-6299c.appspot.com",
    messagingSenderId: "132817983245",
    appId: "1:132817983245:web:c731204b44b8b6ebb3c244",
    measurementId: "G-FZ1RXSYVQC"
  };
  firebase.initializeApp(firebaseConfig);

  // Retrieve Firebase Messaging object.
  const messaging = firebase.messaging();

  // IDs of divs that display registration token UI or request permission UI.
  const tokenDivId = 'token_div';
  const permissionDivId = 'permission_div';

  // Handle incoming messages. Called when:
  // - a message is received while the app has focus
  // - the user clicks on an app notification created by a service worker
  //   `messaging.onBackgroundMessage` handler.
  messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
    // Update the UI to include the received message.
    appendMessage(payload);
  });

  function resetUI() {
    clearMessages();
    showToken('loading...');
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken({vapidKey: 'BKiriy08Tk9FLnL1Y9DuKQwAcMrNafuGF59bdSqM0MGHUXqm4SjDc0lJSm4oSVa7TU_iSOcFX_s6OfxFzyNtoP4'}).then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken);
        updateUIForPushEnabled(currentToken);
      } else {
        // Show permission request.
        console.log('No registration token available. Request permission to generate one.');
        // Show permission UI.
        updateUIForPushPermissionRequired();
        setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
      showToken('Error retrieving registration token. ', err);
      setTokenSentToServer(false);
    });
  }


  function showToken(currentToken) {
    // Show token in console and UI.
    const tokenElement = document.querySelector('#token');
    tokenElement.textContent = currentToken;
  }

  // Send the registration token your application server, so that it can:
  // - send messages back to this app
  // - subscribe/unsubscribe the token from topics
  function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token to server...');
      // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }
  }

  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }

  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }

  function showHideDiv(divId, show) {
    const div = document.querySelector('#' + divId);
    if (show) {
      div.style = 'display: visible';
    } else {
      div.style = 'display: none';
    }
  }

  function requestPermission() {
    console.log('Requesting permission...');
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notification permission granted.');
        // TODO(developer): Retrieve a registration token for use with FCM.
        // In many cases once an app has been granted notification permission,
        // it should update its UI reflecting this.
        resetUI();
      } else {
        console.log('Unable to get permission to notify.');
      }
    });
  }

  function deleteToken() {
    // Delete registration token.
    messaging.getToken().then((currentToken) => {
      messaging.deleteToken(currentToken).then(() => {
        console.log('Token deleted.');
        setTokenSentToServer(false);
        // Once token is deleted update UI.
        resetUI();
      }).catch((err) => {
        console.log('Unable to delete token. ', err);
      });
    }).catch((err) => {
      console.log('Error retrieving registration token. ', err);
      showToken('Error retrieving registration token. ', err);
    });
  }

  // Add a message to the messages element.
  function appendMessage(payload) {
    const messagesElement = document.querySelector('#messages');
    const dataHeaderElement = document.createElement('h5');
    const dataElement = document.createElement('pre');
    dataElement.style = 'overflow-x:hidden;';
    dataHeaderElement.textContent = 'Received message:';
    dataElement.textContent = JSON.stringify(payload, null, 2);
    messagesElement.appendChild(dataHeaderElement);
    messagesElement.appendChild(dataElement);
  }

  // Clear the messages element of all children.
  function clearMessages() {
    const messagesElement = document.querySelector('#messages');
    while (messagesElement.hasChildNodes()) {
      messagesElement.removeChild(messagesElement.lastChild);
    }
  }

  function updateUIForPushEnabled(currentToken) {
    showHideDiv(tokenDivId, true);
    showHideDiv(permissionDivId, false);
    showToken(currentToken);
  }

  function updateUIForPushPermissionRequired() {
    showHideDiv(tokenDivId, false);
    showHideDiv(permissionDivId, true);
  }

  resetUI();

  </script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional

  

  //register service worker
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function(registration) {
        // Registration was successful
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
      }, function(err) {
        // registration failed :(
        console.log('ServiceWorker registration failed: ', err);
      });
    });
  }
</script>
</body>
</html>