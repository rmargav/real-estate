<?php
// 1. Get and clean the form data
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// 2. Email Settings
// Update this to the client's actual receiving email
$to = "info@jhallakinfra.com"; 
$subject = "New Site Visit Inquiry from " . $name;

// IMPORTANT: Keep the "From" address as an email from the actual website domain (e.g., noreply@jhallakinfra.com)
$headers = "From: noreply@jhallakinfra.com\r\n"; 
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// 3. Build the email body message
$body = "You have a new site visit inquiry from the Jhallak Infra website:\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Phone: $phone\n";
$body .= "Message:\n$message\n";

// 4. Send the email!
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
    $send = mail($to, $subject, $body, $headers);
    
    if ($send) {
        // Success message and auto-redirect back to the contact section
        echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
        echo "<h2 style='color: #c2a773;'>Success!</h2>";
        echo "<p>Your inquiry was sent successfully. Our team will contact you shortly.</p>";
        echo "<p><small>Redirecting you back...</small></p>";
        echo "</div>";
        echo "<meta http-equiv='refresh' content='3;url=../../../../index.html#contact'>"; 
    } else {
        // Server failed to send
        echo "<h2 style='color: red; text-align: center; margin-top: 50px;'>Error!</h2>";
        echo "<p style='text-align: center;'>The server failed to send the message. Please check your server mail configurations.</p>";
    }
    
} else {
    // User put in a bad email
    echo "<h2 style='color: red; text-align: center; margin-top: 50px;'>Invalid Email</h2>";
    echo "<p style='text-align: center;'>Please go back and enter a valid email address.</p>";
}
?>