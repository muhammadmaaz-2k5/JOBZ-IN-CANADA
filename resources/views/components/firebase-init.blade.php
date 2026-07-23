<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/12.16.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.16.0/firebase-analytics.js";
  import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.16.0/firebase-auth.js";

  const firebaseConfig = {
    apiKey: "AIzaSyCKZr9aBz67L31rCEpIyw_fVO4J2vYnJoU",
    authDomain: "jobsincanada-25ad2.firebaseapp.com",
    projectId: "jobsincanada-25ad2",
    storageBucket: "jobsincanada-25ad2.firebasestorage.app",
    messagingSenderId: "567422463412",
    appId: "1:567422463412:web:930e3e239084f6a70716e1",
    measurementId: "G-WCT5J5F6EP"
  };

  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const auth = getAuth(app);
  const googleProvider = new GoogleAuthProvider();

  window.firebaseAuth = { auth, signInWithPopup, googleProvider };
</script>
