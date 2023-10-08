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

submitButton.addEventListener("click", async (e) => {
  const username = usernameInput.value.trim();
  const mobileNumber = mobileInput.value.trim();
  const vehicleNumber = vehicleNumberInput.value.trim().toUpperCase();
  const vehicleType = vehicleTypeSelect.value;

  // Simple validation checks
  if (!username || !mobileNumber || !vehicleNumber || !vehicleType) {
    alert("Error: Please fill in all required fields correctly.");
    e.preventDefault(); // Prevent form submission
    return;
  }

  // Validate mobile number
  const mobileRegex = /^\d{10}$/;
  if (!mobileRegex.test(mobileNumber)) {
    alert("Error: Mobile number should have 10 digits.");
    e.preventDefault(); // Prevent form submission
    return;
  }

  // Validate vehicle number
  const vehicleNumberRegex = /^[A-Z]{2}[ -]?[0-9]{2}[ -]?[A-Z]{0,3}[ -]?[0-9]{1,4}$/;
  if (!vehicleNumberRegex.test(vehicleNumber)) {
    alert("Error: Invalid vehicle number format.");
    e.preventDefault(); // Prevent form submission
    return;
  }

  // If all validation checks pass, submit the form data to connect.php
  const formData = new FormData();
  formData.append("name", username);
  formData.append("mobile", mobileNumber);
  formData.append("num", vehicleNumber);
  formData.append("vehicle-type", vehicleType);

  try {
    const response = await fetch("connect.php", {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      // Data was inserted successfully

      // Parse the response JSON to get the booking ID
      const data = await response.json();
      const bookingId = data.bookingId;

      // Redirect to receipt.php with the booking ID as a query parameter
      window.location.href = `receipt.php?ID=${bookingId}`;
    } else {
      // Error occurred while inserting data
      alert("Error: Unable to submit the form.");
    }
  } catch (error) {
    console.error(error);
    alert("Booking Successful");
  }
});




