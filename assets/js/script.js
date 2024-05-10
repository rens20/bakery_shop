  const login = document.getElementById("login").addEventListener("click", () =>{
            window.location.href = "login.php";
          });

          const signup = document.getElementById("signup").addEventListener("click", () =>{
            window.location.href = "signup.php";
          });

// for eye
 function togglePasswordVisibility() {
      const passwordField = document.getElementById("password");
      const icon = document.querySelector(".bi-eye");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
      } else {
        passwordField.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
      }
    }

	//another eye
	   function togglePasswordVisibility() {
      const passwordField = document.getElementById("password");
      const  icon = document.querySelector(".bi-eye");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
      } else {
        passwordField.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
      }
    }

    function togglePassword() {
      const passwordField = document.getElementById("con_password");
      const  icon = document.querySelector(".bi-log");

      if (passwordField.type === "con_password") {
        passwordField.type = "text";
        icon.classList.remove("bi-log");
        icon.classList.add("bi-eye-slash");
      } else {
        passwordField.type = "con_password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-log");
      }
    }

	//sigin render
	Document.getElementById("signin").addEventListener("click", function () {
		window.location.href="signup.php";
	});