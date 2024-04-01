// Check if the user is authenticated
function checkAuthentication() {
    // Send an AJAX request to a PHP script that checks for session variables
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);
                if (response.authenticated === true) {
                    // User is authenticated, do nothing
                } else {
                    // User is not authenticated, redirect to login page
                    window.location.href = "index.html";
                }
            } else {
                // Error handling
                console.error("Error checking authentication status");
            }
        }
    };
    xhr.open("GET", "check_auth.php", true);
    xhr.send();
}

// Call the function when the page loads
window.onload = checkAuthentication;