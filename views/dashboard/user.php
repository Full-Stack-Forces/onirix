<h1>Gestion utilisateurs</h1>
<?php
if (isset($users)) {
?>
    <div id='users'>
        <?php
        $index = 0;
        foreach ($users as $user) {
        ?>
            <div id='user_<?php echo $index ?>'>
                <h2><?php echo ($user->isAdmin() ? '[ADMIN] :: ' : '') ?><?php echo mb_strtoupper($user->lastName()) . ' ' . $user->firstName() ?> - <?php echo ($user->isActive() ? '[ACTIF]' : '[INACTIF]') ?></h2>
                <span id='email_<?php echo $index ?>'><?php echo $user->email() ?></span>
                <span id='birthdate_<?php echo $index ?>'><?php echo $user->birthdate()->format('d/m/Y') ?></span>
                <input type="hidden" id="id_<?php echo $index ?>" value="<?php echo $user->id() ?>" />
                <?php
                if ($user->isActive()) {
                ?>
                    <a href="/dashboard/user?id=<?php echo $user->id() ?>&enabled=false" id='deactivate_<?php echo $index ?>'>Désactiver</a>
                <?php
                } else {
                ?>
                    <a href="/dashboard/user?id=<?php echo $user->id() ?>&enabled=true" id='activate_<?php echo $index ?>'>Activer</a>
                <?php
                }
                ?>
                <a href="/dashboard/user?id=<?php echo $user->id() ?>" id='profile_<?php echo $index ?>'>Voir le profil</a>
                <a href="/profile/edit?id=<?php echo $user->id() ?>" id='update_<?php echo $index ?>'>Modifier</a>
                <a href="/dashboard/user?id=<?php echo $user->id() ?>&delete=true" id='delete_<?php echo $index ?>'>Supprimer</a>
            </div>
            <br />
        <?php
            $index++;
        }
        ?>
    </div>
<?php
} else {
?>
    <div id='user'>
        <h2><?php echo ($user->isAdmin() ? '[ADMIN] :: ' : '') ?><?php echo strtoupper($user->lastName()) . ' ' . $user->firstName() ?> - <?php echo ($user->isActive() ? '[ACTIF]' : '[INACTIF]') ?></h2>
        <span id='email'><?php echo $user->email() ?></span>
        <span id='birthdate'><?php echo $user->birthdate()->format('d/m/Y') ?></span>
        <input type="hidden" id="id" value="<?php echo $user->id() ?>" />
        <?php
        if ($user->isActive()) {
        ?>
            <a href="/dashboard/user?id=<?php echo $user->id() ?>&enabled=false" id='deactivate'>Désactiver</a>
        <?php
        } else {
        ?>
            <a href="/dashboard/user?id=<?php echo $user->id() ?>&enabled=true" id='activate'>Activer</a>
        <?php
        }
        ?>
        <a href="/profile/edit?id=<?php echo $user->id() ?>&update=true" id='update'>Modifier</a>
        <a href="/dashboard/user?id=<?php echo $user->id() ?>&delete=true" id='delete'>Supprimer</a>
        <a href="/dashboard/user" id='back'>Retour</a>
    </div>
<?php
}
