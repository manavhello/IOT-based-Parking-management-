// Function to validate and provide instant feedback on user input
function validateInput() {
  // Username validation
  const usernameInput = document.getElementById("username-input");
  const usernameError = document.getElementById("username-error");
  const emptyUsernameError = document.getElementById("empty-username");
  const usernameRegex = /^[a-zA-Z\s]+$/; // Allow only letters and spaces

  usernameInput.addEventListener("input", () => {
    const username = usernameInput.value.trim();
    if (usernameRegex.test(username)) {
      usernameError.classList.add("hide");
      emptyUsernameError.classList.add("hide");
    } else {
      usernameError.classList.remove("hide");
    }
  });

  // Mobile number validation
  const mobileInput = document.getElementById("mobile");
  const mobileError = document.getElementById("mobile-error");
  const emptyMobileError = document.getElementById("empty-mobile");
  const mobileRegex = /^\d{10}$/; // 10-digit number

  mobileInput.addEventListener("input", () => {
    const mobileNumber = mobileInput.value.trim();
    if (mobileRegex.test(mobileNumber)) {
      mobileError.classList.add("hide");
      emptyMobileError.classList.add("hide");
    } else {
      mobileError.classList.remove("hide");
    }
  });

  // Email validation
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("email-error");
  const emptyEmailError = document.getElementById("empty-email");
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email regex

  emailInput.addEventListener("input", () => {
    const email = emailInput.value.trim();
    if (emailRegex.test(email)) {
      emailError.classList.add("hide");
      emptyEmailError.classList.add("hide");
    } else {
      emailError.classList.remove("hide");
    }
  });

  // Password validation
  const passwordInput = document.getElementById("password");
  const passwordError = document.getElementById("password-error");
  const emptyPasswordError = document.getElementById("empty-password");

  passwordInput.addEventListener("input", () => {
    const password = passwordInput.value.trim();
    if (password.length >= 6) {
      passwordError.classList.add("hide");
      emptyPasswordError.classList.add("hide");
    } else {
      passwordError.classList.remove("hide");
    }
  });
  }

// Call the function to validate input on page load
window.addEventListener('load', validateInput);
