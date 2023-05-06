<?php

use Webcup\User;

$user = new User($_GET['id']);

?>

<form action="/profile/edit?id=<?php echo $_GET['id']; ?>" method="POST">
    <input type="text" name="last_name" placeholder="nom" value="<?php echo $user->lastName(); ?>" />
    <input type="text" name="first_name" placeholder="prénom" value="<?php echo $user->firstName(); ?>" />
    <input type="email" name="email" placeholder="adresse email" value="<?php echo $user->email(); ?>" />
    <input type="date" name="birthdate" placeholder="date de naissance" value="<?php echo reverseFieldFormatDate($user->birthdate(), false); ?>" />
    <span>
        <label>Masculin <input type="radio" name="gender" value="M" <?php echo $user->gender() == 'M' ? 'checked' : ''; ?> /></label>
        <label>Féminin <input type="radio" name="gender" value="F" <?php echo $user->gender() == 'F' ? 'checked' : ''; ?> /></label>
    </span>
    <input type="password" name="password" placeholder="nouveau mot de passe" />
    <input type="password" name="password_verify" placeholder="vérification mot de passe" />
    <input type="submit" value="Enregistrer" />
    <a href="/profile?id=<?php echo $_GET['id']; ?>">Annuler</a>
</form>