<h1>Accueil</h1>

<?php

if (isset($_SESSION['user'])) {
    echo '<a href="/logout">Se déconnecter</a>';
} else {
    echo '<a href="/login">Se connecter</a>';
}