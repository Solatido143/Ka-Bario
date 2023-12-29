<!-- FirebaseDatabase -->
<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyCNS6Q2nnwI2YwKs-sU-wiaPlSGr7x3Ims",
        authDomain: "jem4a-4b805.firebaseapp.com",
        databaseURL: "https://jem4a-4b805-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "jem4a-4b805",
        storageBucket: "jem4a-4b805.appspot.com",
        messagingSenderId: "525493662684",
        appId: "1:525493662684:web:dc38d26440107dc1959519",
        measurementId: "G-YMPZE77YEQ"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
</script>