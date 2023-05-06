<?php

use Webcup\User;

$user = new User($_GET['id']);
?>

<a href="/profile/edit">Modifier</a>
<section>
    <article>
        <section>Nom</section>
        <section><?php echo $user->lastName(); ?></section>
    </article>
    <article>
        <section>Prénom</section>
        <section><?php echo $user->firstName(); ?></section>
    </article>
    <article>
        <section>Email</section>
        <section><?php echo $user->email(); ?></section>
    </article>
    <article>
        <section>Genre</section>
        <section><?php echo $user->genderFr(); ?></section>
    </article>
    <article>
        <section>Date de naissance</section>
        <section><?php echo $user->birthdate()->format('d M Y'); ?></section>
    </article>
</section>