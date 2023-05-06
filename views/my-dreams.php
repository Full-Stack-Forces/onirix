<div>
    <h1>Mes rêves</h1>
    <?php
    $index = 0;
    foreach ($_SESSION['user']->dreams() as $dream) {
        $result = $dream->result();

        if (!$result) { continue; }

    ?>
        <div id="result_<?php echo $index ?>">
            <h2><?php echo $dream->title() ?></h2>
            <span id="prediction_<?php echo $index ?>">Rêve: <?php echo $dream->content() ?></span>
            <span id="prediction_<?php echo $index ?>">Prédiction: <?php echo $result->prediction() ?></span>
            <span id="illustration_<?php echo $index ?>">Illustration: <?php echo $result->illustration() ?></span>
            <span id="accuracy_<?php echo $index ?>">Probabilité: <?php echo $result->accuracy() ?>%</span>
        </div>
    <?php
        $index++;
    }
    ?>
</div>