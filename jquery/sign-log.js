function toggleForm(type) {
  if (type === 'login') {
    $('#loginBox').removeClass('hidden');
    $('#signupBox').addClass('hidden');
    $('#loginTab').addClass('active');
    $('#signupTab').removeClass('active');
  } else {
    $('#signupBox').removeClass('hidden');
    $('#loginBox').addClass('hidden');
    $('#signupTab').addClass('active');
    $('#loginTab').removeClass('active');
  }
}

function login() {
  const email = $('#loginEmail').val().trim();
  const password = $('#loginPassword').val().trim();
  const role = $('#loginRole').val();

  if (!email || !password || !role) {
    alert("Please fill all login fields.");
    return;
  }

  $.ajax({
    url: 'php/login.php',
    method: 'POST',
    data: {
      email: email,
      password: password,
      role: role
    },
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        window.location.href = response.redirect;
      } else {
        alert("Login failed: " + response.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("AJAX error during login: " + textStatus + " - " + errorThrown);
      console.error(jqXHR.responseText);
    }
  });
}

function signup() {
  const fullName = $('#signupFullname').val().trim();
  const email = $('#signupEmail').val().trim();
  const password = $('#signupPassword').val().trim();

  if (!fullName || !email || !password) {
    alert("Please fill all signup fields.");
    return;
  }

  $.ajax({
    url: 'php/signup.php',
    method: 'POST',
    data: {
      full_name: fullName,
      email: email,
      password: password
    },
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        alert("Signup successful! You can now log in.");
        toggleForm('login');
      } else {
        alert("Signup failed: " + response.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("AJAX error during signup: " + textStatus + " - " + errorThrown);
      console.error(jqXHR.responseText);
    }
  });
}
