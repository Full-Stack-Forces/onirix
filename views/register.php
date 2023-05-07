<div class="flex-1 flex flex-col items-center justify-center px-6 py-8 m-auto lg:py-0 w-full">
    <a href="#" class="flex items-center mb-6 text-2xl">
        <img class="h-14" src="/public/assets/img/logo-iir.svg" alt="logo">
    </a>
    <div class="w-full glass rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl text-white font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                <?php echo isset($_SESSION['register_values']) && is_array($_SESSION['register_values']) ? 'Finalisez votre inscription' : 'Inscrivrez-vous'; ?>
            </h1>
            <form method="POST" class="space-y-4 md:space-y-6">
                <?php if (isset($_SESSION['register_values']) && is_array($_SESSION['register_values'])) { ?>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Nom</label>
                        <input type="last_name" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Dupont" required>
                    </div>
                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Prénom</label>
                        <input type="first_name" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jean" required>
                    </div>
                    <div>
                        <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Date de naissance</label>
                        <input type="date" name="birthdate" id="birthdate" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jean">
                    </div>
                    <div class="flex flex-wrap">
                        <label class="w-full block mb-2 text-sm font-medium text-gray-300 dark:text-white">Sexe</label>
                        <div class="flex items-center mr-4">
                            <input id="inline-radio" type="radio" value="M" name="gender" class="w-4 h-4 text-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ml-2 text-sm font-medium text-white dark:text-white">Masculin</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="inline-2-radio" type="radio" value="F" name="gender" class="w-4 h-4 text-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-2-radio" class="ml-2 text-sm font-medium text-white dark:text-white">Féminin</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-cyan-950 hover:bg-cyan-900 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Créer mon compte</button>
                <?php } else { ?>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Adresse email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="groupe@webcup.fr" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Mot de passe</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-300 dark:text-white">Vérification mot de passe</label>
                        <input type="password" name="password_verify" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <button type="submit" class="w-full text-white bg-cyan-950 hover:bg-cyan-900 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Suivant</button>
                <?php } ?>
                <div class="flex justify-between">
                    <a href=" /login" class="font-medium text-gray-400 hover:underline">J'ai déjà un compte</a>
                    <?php
                    if (isset($_SESSION['register_values']) && is_array($_SESSION['register_values'])) {
                        echo '<a href="/register?clear" class="font-medium ml-2 text-gray-400 hover:underline">Retour</a>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>