<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Hotel Reservation - Login/Signup</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/index.css" />
  <style>
    /* Minimal styling */
body {
  font-family: 'Inter', sans-serif;
  margin: 0;
  padding: 0;
  position: relative;
  min-height: 100vh;
  background-image: url("image/bg11.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  display: flex;
  justify-content: center;
  align-items: center;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Adjust opacity here */
  z-index: 1;
}

.content {
  position: relative;
  z-index: 2;
  color: white; /* Ensure visibility on dark overlay */
  text-align: center;
}


    .container {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 320px;
    }
    .tabs button {
      padding: 10px 20px;
      border: none;
      background: #eee;
      cursor: pointer;
      margin-right: 5px;
      border-radius: 5px 5px 0 0;
    }
    .tabs button.active {
      background: #4285f4;
      color: white;
      font-weight: bold;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    form input, form select, form button {
      margin-top: 10px;
      padding: 8px;
      font-size: 14px;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="tabs">
      <button id="loginTab" class="active" onclick="toggleForm('login')">Login</button>
      <button id="signupTab" onclick="toggleForm('signup')">Signup</button>
    </div>

    <!-- Login Form -->
    <div id="loginBox">
      <form onsubmit="login(); return false;">
        <h2>Login</h2>
        <input type="email" id="loginEmail" placeholder="Email" required />
        <input type="password" id="loginPassword" placeholder="Password" required />
        <select id="loginRole" required>
          <option value="">Select role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <button type="submit">Login</button>
      </form>
    </div>

    <!-- Signup Form -->
    <div id="signupBox" class="hidden">
      <form onsubmit="signup(); return false;">
        <h2>Create Account</h2>
        <input type="text" id="signupFullname" placeholder="Full Name" required />
        <input type="email" id="signupEmail" placeholder="Email" required />
        <input type="password" id="signupPassword" placeholder="Password" required />
        <button type="submit">Signup</button>
      </form>
    </div>
  </div>

  <!-- Use CDN for jQuery (recommended) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="jquery/sign-log.js"></script>
</body>
</html>
