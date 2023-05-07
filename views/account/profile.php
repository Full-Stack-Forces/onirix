<?php

use Webcup\User;

$user = new User($_GET['id']);
?>
<h1 class="text-4xl text-center">Mon profil</h1>
<div id="profile" class="container mx-auto mb-20 mt-10">
    <div class="w-1/2 flex flex-col mx-auto p-3 bg-white text-black rounded-md shadow-md text-lg">
        <span><span class="font-bold">Nom</span> <?php echo $user->lastName(); ?></span>
        <span><span class="font-bold">Prénom</span> <?php echo $user->firstName(); ?></span>
        <span><span class="font-bold">Email</span><?php echo $user->email(); ?></span>
        <span><span class="font-bold">Genre</span><?php echo $user->genderFr(); ?></span>
        <span><span class="font-bold">Date de naissance</span><?php echo $user->birthdate()->format('d M Y'); ?></span>
        <a class="self-end btn bg-cyan-950 hover:bg-cyan-700 w-fit m-5" href="/profile/edit">Modifier</a>
    </div>
</div>