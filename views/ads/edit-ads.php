<?php

use Webcup\Ads;

$ads = new Ads($_GET['id']);

?>

<form action="/ads/edit?id=<?php echo $_GET['id']; ?>" method="POST">
    <label>
        <input type="checkbox" name="is_active" value="1" <?php echo $ads->isActive() ? 'checked' : ''; ?> />
        Est activé
    </label>
    <input type="text" name="title" placeholder="Titre" value="<?php echo $ads->title(); ?>" />
    <input type="text" name="link" placeholder="Lien" value="<?php echo $ads->link(); ?>" />
    <input type="number" name="priority" placeholder="Priorité" value="<?php echo $ads->priority(); ?>" />
    <input type="submit" value="Mettre à jour" />
</form>