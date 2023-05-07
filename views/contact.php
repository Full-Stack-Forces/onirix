<h1 class="text-4xl text-center">Contactez-nous</h1>
<div id='contact' class="container mx-auto">
    <form method="post" class="flex flex-col w-1/2 mx-auto">
        <label for="first_name">*Nom</label>
        <input class="input bg-white text-black" type="text" name="first_name" id="first_name" required>
        <label for="last_name">*Prénom</label>
        <input class="input bg-white text-black" type="text" name="last_name" id="last_name" required>
        <label for="phone">Téléphone</label>
        <input class="input bg-white text-black" type="text" name="phone" id="phone" required>
        <label for="email">*Email</label>
        <input class="input bg-white text-black" type="email" name="email" id="email" required>
        <label for="subject">*Objet</label>
        <input class="input bg-white text-black" type="text" name="subject" id="subject" required>
        <label for="content">*Message</label>
        <textarea style="resize: none; height: 15vh;" class="input bg-white text-black" name="content" id="content" required></textarea>
        <small>*: Champs obligatoires</small>
        <button class="self-center mt-5 btn bg-fuchsia-800 hover:bg-fuchsia-900 active:bg-fuchsia-950 w-fit text-white" type="submit">Envoyer</button>
    </form>
</div>
<?php
if (isset($error['message'])) {
    echo '<span>' . $error['message'] . '</span>';
}
