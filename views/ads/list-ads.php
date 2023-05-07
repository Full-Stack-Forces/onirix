<?php

$allAds = Webcup\AdsService::getAll();

foreach ($allAds as $ads) {
    echo '
        <article class="p-3 bg-white text-black rounded-md shadow-md">
            <section>' . $ads->title() . '</section>
            <section>' . $ads->illustration() . '</section>
            <a class="btn bg-orange-900 hover:bg-orange-800 active:bg-orange-950 text-white border-none" href="/ads/edit?id=' . $ads->id() . '">Modifier</a>
            <a class="btn bg-red-900 hover:bg-red-800 active:bg-red-950 text-white border-none" href="/ads/delete?id=' . $ads->id() . '">Supprimer</a>
        </article>
    ';
}
?>

<a href="/ads/new">Ajouter</a>