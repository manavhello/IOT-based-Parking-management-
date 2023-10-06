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

// Vehicle number validation
const vehicleNumberInput = document.getElementById("vehicle-number");
const vehicleNumberError = document.getElementById("vehicle-number-error");
const emptyVehicleNumberError = document.getElementById("empty-vehicle-number");
const vehicleNumberRegex = /^[A-Z]{2}[ -]?[0-9]{2}[ -]?[A-Z]{0,3}[ -]?[0-9]{1,4}$/; // validation pattern

vehicleNumberInput.addEventListener("input", () => {
  const vehicleNumber = vehicleNumberInput.value.trim().toUpperCase();
  if (vehicleNumberRegex.test(vehicleNumber)) {
    vehicleNumberError.classList.add("hide");
    emptyVehicleNumberError.classList.add("hide");
  } else {
    vehicleNumberError.classList.remove("hide");
  }
});

// Vehicle type validation
const vehicleTypeSelect = document.querySelector('select[name="vehicle-type"]');

vehicleTypeSelect.addEventListener("change", () => {
  const selectedValue = vehicleTypeSelect.value;
  if (selectedValue === "") {
    vehicleTypeSelect.classList.add("error");
  } else {
    vehicleTypeSelect.classList.remove("error");
  }
});

// Submit button click event
const submitButton = document.getElementById("submit-button");

submitButton.addEventListener("click", () => {
  const isUsernameValid = usernameRegex.test(usernameInput.value.trim());
  const isMobileValid = mobileRegex.test(mobileInput.value.trim());
  const isVehicleNumberValid = vehicleNumberRegex.test(vehicleNumberInput.value.trim().toUpperCase());
  const isVehicleTypeValid = vehicleTypeSelect.value !== "";

  if (isUsernameValid && isMobileValid && isVehicleNumberValid && isVehicleTypeValid) {
    alert("Success");
  } else {
    alert("Error");
  }
});
