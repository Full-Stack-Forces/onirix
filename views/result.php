<h1 class="text-4xl text-center">Mon résultat</h1>
<div id="result" class="container mx-auto mt-10 mb-20">
    <?php
    if (isset($guest) && $guest) {
    ?>
        <div class="card w-1/2 bg-white text-black shadow-xl p-3 mx-auto">
            <span id="content"><span class="font-bold">Mon rêve:</span> <?php echo $guest['dream']['content'] ?></span>
            <span id="prediction"><span class="font-bold">Ma prédiction:</span> <?php echo $guest['result']['prediction'] ?></span>
            <span id="prediction"><span class="font-bold">Mon illustration:</span> <img class="mx-auto" src="<?php echo $guest['result']['illustration'] ?>" /></span>
        </div>
    <?php
    } else {
    ?>
        <div class="card w-1/2 bg-white text-black shadow-xl p-3 mx-auto">
            <span id="content"><span class="font-bold">Mon rêve:</span> <?php echo $result->dream()->content() ?></span>
            <span id="prediction"><span class="font-bold">Ma prédiction:</span> <?php echo $result->prediction() ?></span>
            <span id="prediction"><span class="font-bold">Mon illustration:</span> <img class="mx-auto" src="<?php echo $result->illustration() ?>" /></span>
            <span id="prediction"><span class="font-bold">Probabilité:</span> <?php echo $result->accuracy() ?>%</span>
        </div>
    <?php
    }
    ?>
</div>