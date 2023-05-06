<aside>
    <?php
        $allAds = Webcup\AdsService::getAll(array('is_active' => 1));

        foreach ($allAds as $ads) {
            echo '
                <a href="' . $ads->link() . '">
                    <section>' . $ads->title() . '</section>
                    <section>' . $ads->illustration() . '</section>
                </a>
            ';
        }
    ?>
</aside>