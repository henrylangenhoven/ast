<?php
$receiving_email_address = "henry.langenhoven.dev@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Fout: Alle velde is verpligtend.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Fout: Ongeldige e-posadres.";
        exit;
    }

    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";

    // ✅ Voeg 'n duidelike aanduiding in dat dit 'n boodskap van die webvorm is
    $email_content = "📩 *Hierdie boodskap is gestuur vanaf die \"Kontak Ons\" webvorm op AgroSkyTech.co.za.*\n\n";
    $email_content .= "Naam: $name\n";
    $email_content .= "E-pos: $email\n";
    $email_content .= "Onderwerp: $subject\n\n";
    $email_content .= "Boodskap:\n$message\n";

    if (mail($receiving_email_address, "📩 Nuwe Kontakvorm Boodskap: " . $subject, $email_content, $headers)) {
        echo "Jou boodskap is suksesvol gestuur!";
    } else {
        echo "Fout: Kon nie jou boodskap stuur nie. Probeer asseblief later weer.";
    }
} else {
    echo "Fout: Ongeldige versoek.";
}
?>
