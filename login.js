document.getElementById('login-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('login.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            setMessage('success', 'Login successful.');
            // Redirect to home page or perform other actions after successful login
            window.location.href = 'home.html';
        } else {
            setMessage('error', 'Login failed. Please check your credentials.');
        }
    } catch (error) {
        console.error('Error:', error);
        setMessage('error', 'An unexpected error occurred. Please try again later.');
    }
});

function setMessage(type, message) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = message;
    messageDiv.className = type;
}
