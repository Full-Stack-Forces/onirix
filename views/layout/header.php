<header>
    header
</header>

<?php

if (isset($_SESSION['user'])) {
    echo '<span>' . $_SESSION['user']->email() . '</span>';
    echo '<a href="/my-dreams">Mes rêves</a>';
    echo '<a href="/profile">Mon profil</a>';
    echo '<a href="/logout">Se déconnecter</a>';
} else {
    echo '<a href="/login">Se connecter</a>';
    echo '<a href="/register">S\'enregistrer</a>';
}