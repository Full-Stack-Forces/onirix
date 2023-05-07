<?php

use Webcup\User;

$user = new User($_GET['id']);

?>
<h1 class="text-4xl text-center">Édition - Mon profil</h1>
<div id="edit-profile" class="container mx-auto mb-20 mt-10">
    <div class="w-1/2 mx-auto p-3 glass rounded-md shadow-md">
        <form action="/profile/edit?id=<?php echo $_GET['id']; ?>" method="POST" class="flex flex-col justify-center">
            <span>
                <label>Masculin <input type="radio" name="gender" value="M" <?php echo $user->gender() == 'M' ? 'checked' : ''; ?> /></label>
                <label>Féminin <input type="radio" name="gender" value="F" <?php echo $user->gender() == 'F' ? 'checked' : ''; ?> /></label>
            </span>
            <input class="input bg-white text-black p-3 my-1" type="text" name="last_name" placeholder="nom" value="<?php echo $user->lastName(); ?>" />
            <input class="input bg-white text-black p-3 my-1" type="text" name="first_name" placeholder="prénom" value="<?php echo $user->firstName(); ?>" />
            <input class="input bg-white text-black p-3 my-1" type="email" name="email" placeholder="adresse email" value="<?php echo $user->email(); ?>" />
            <input class="input bg-white text-black p-3 my-1" type="date" name="birthdate" placeholder="date de naissance" value="<?php echo reverseFieldFormatDate($user->birthdate(), false); ?>" />
            <input class="input bg-white text-black p-3 my-1" type="password" name="password" placeholder="nouveau mot de passe" />
            <input class="input bg-white text-black p-3 my-1" type="password" name="password_verify" placeholder="vérification mot de passe" />
            <input class="btn bg-orange-400 text-white hover:bg-orange-300 active:bg-orange-500 border-none w-fit self-center my-5" type="submit" value="Enregistrer" />
            <a class="text-white hover:text-red-500 w-fit p-2" href="/profile?id=<?php echo $_GET['id']; ?>">Annuler</a>
        </form>
    </div>
</div>