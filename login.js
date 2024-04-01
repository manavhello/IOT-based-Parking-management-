document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    
    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Login successful
            alert(data.message);
            window.location.href = "home.html";
        } else {
            // Login failed
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});
