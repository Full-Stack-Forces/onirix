<aside class="md:fixed m-10 md:m-0 md:bottom-0 md:right-0 flex flex-wrap justify-center items-end">
    <?php
        $allAds = Webcup\AdsService::getAll(array('is_active' => 1));

        foreach ($allAds as $ads) {
            echo '
                <a href="' . $ads->link() . '" target="_blank" title="' . $ads->title() . '" class="m-2 bg-white h-32 w-32 rounded-lg animate-pulse hover:animate-none hover:w-56 hover:h-56" style="background-image: url(' . $ads->illustration() . '); background-size: cover; background-repeat: no-repeat; background-position: center;"></a>
            ';
        }
    ?>
</aside>