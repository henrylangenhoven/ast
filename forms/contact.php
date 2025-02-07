<?php
// Configure recipient email address
$receiving_email_address = "henry.langenhoven.dev@gmail.com";

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and validate form inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Check required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Fout: Alle velde is verpligtend.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Fout: Ongeldige e-posadres.";
        exit;
    }

    // Set up email headers
    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";

    // Construct the email content
    $email_content = "Naam: $name\n";
    $email_content .= "E-pos: $email\n";
    $email_content .= "Onderwerp: $subject\n\n";
    $email_content .= "Boodskap:\n$message\n";

    // Send the email
    if (mail($receiving_email_address, $subject, $email_content, $headers)) {
        echo "Jou boodskap is suksesvol gestuur!";
    } else {
        echo "Fout: Kon nie jou boodskap stuur nie. Probeer asseblief later weer.";
    }

} else {
    echo "Fout: Ongeldige versoek.";
}
?>
