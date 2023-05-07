<h1>Contactez-nous</h1>
<form method="post">
    <label for="first_name">*Nom</label>
    <input type="text" name="first_name" id="first_name" required>
    <label for="last_name">*Prénom</label>
    <input type="text" name="last_name" id="last_name" required>
    <label for="phone">Téléphone</label>
    <input type="text" name="phone" id="phone" required>
    <label for="email">*Email</label>
    <input type="email" name="email" id="email" required>
    <label for="subject">*Objet</label>
    <input type="text" name="subject" id="subject" required>
    <label for="content">*Message</label>
    <textarea name="content" id="content" required></textarea>
    <small>*: Champs obligatoires</small>
    <button type="submit">Envoyer</button>
</form>
<?php
if (isset($error['message'])) {
    echo '<span>' . $error['message'] . '</span>';
}