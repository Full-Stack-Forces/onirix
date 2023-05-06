<form method="POST">
    <?php if (isset($_SESSION['register_values']) && is_array($_SESSION['register_values'])) { ?>
        <input type="text" name="last_name" placeholder="nom" />
        <input type="text" name="first_name" placeholder="prénom" />
        <input type="date" name="birthdate" placeholder="date de naissance" />
        <span>
            <label>Masculin <input type="radio" name="gender" value="M" /></label>
            <label>Féminin <input type="radio" name="gender" value="F" /></label>
        </span>
        <input type="submit" value="Créer mon compte" />
        <a href="/register?clear">Retour</a>
    <?php } else { ?>
        <input type="email" name="email" placeholder="adresse email" />
        <input type="password" name="password" placeholder="mot de passe" />
        <input type="password" name="password_verify" placeholder="vérification mot de passe" />
        <input type="submit" value="Suivant" />
    <?php } ?>
</form>