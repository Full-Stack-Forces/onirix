<h1 class="text-4xl text-center">Mes rêves</h1>
<div id='my-dreams' class="container mx-auto mb-20">
    <div class="grid gap-4 grid-cols-3 grid-rows-3">
        <?php
        $index = 0;
        foreach ($_SESSION['user']->dreams() as $dream) {
            $result = $dream->result();

            if (!$result) {
                continue;
            }

        ?>
            <section id="result_<?php echo $index ?>" class="m-2 grid grid-2 grid-cols-2 p-3 rounded-md bg-white text-black shadow-md min-h-full hover:cursor-pointer" onclick="document.location.href = <?php echo "'/result?id=" . $result->id() . "'" ?>;" style="max-height: 20vh;">
                <aside>
                <img src="<?php echo $result->illustration() ?>" />
                </aside>
                <article style="overflow-y: auto;">
                <p id="prediction_<?php echo $index ?>"><span class="font-bold">Rêve:</span> <?php echo $dream->content() ?></p>
                <p id="prediction_<?php echo $index ?>"><span class="font-bold">Prédiction:</span> <?php echo $result->prediction() ?></p>
                <p id="accuracy_<?php echo $index ?>"><span class="font-bold">Probabilité:</span> <?php echo $result->accuracy() ?>%</p>
                </article>
            </section>
        <?php
            $index++;
        }
        ?>
    </div>
</div>