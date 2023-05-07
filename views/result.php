<?php

if (isset($guest) && $guest) {
?>
<div>
    <h1>Result</h1>
    <div id="result">
        <span id="content"><?php echo $guest['dream']['content'] ?></span>
        <span id="prediction"><?php echo $guest['result']['prediction'] ?></span>
    </div>
</div>
<?php
} else {
?>
<div>
    <h1>Result</h1>
    <div id="result">
        <span id="prediction">Prédiction: <?php echo $result->prediction() ?></span>
        <span id="illustration">Illustration: <img src="<?php echo $result->illustration() ?>" /></span>
        <span id="accuracy">Probabilité: <?php echo $result->accuracy() ?>%</span>
    </div>
</div>
<?php
}
?>