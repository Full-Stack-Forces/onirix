<?php

$allAds = Webcup\AdsService::getAll();

foreach ($allAds as $ads) {
    echo '
        <article>
            <section>' . $ads->title() . '</section>
            <section>' . $ads->illustration() . '</section>
            <a href="/ads/edit?id=' . $ads->id() . '">Modifier</a>
            <a href="/ads/delete?id=' . $ads->id() . '">Supprimer</a>
        </article>
    ';
}
?>

<a href="/ads/new">Ajouter</a>