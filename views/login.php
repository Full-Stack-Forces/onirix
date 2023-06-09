<div class="flex-1 flex flex-col items-center justify-center px-6 py-8 m-auto lg:py-0">
    <a href="#" class="flex items-center mb-6 text-2xl">
        <img class="h-14" src="/public/assets/img/logo-iir.svg" alt="logo">
    </a>
    <div class="w-full glass rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl text-white font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Connectez-vous
            </h1>
            <form action="check-login" method="POST" class="space-y-4 md:space-y-6">
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-300">Identifiant</label>
                    <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="groupe@webcup.fr" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-300">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                        </div>
                        <div class="ml-3 mr-5 text-sm">
                            <label for="remember" class="text-gray-300">Se souvenir de moi</label>
                        </div>
                    </div>
                    <a href="#" class="text-sm font-medium text-primary-600 hover:underline">Mot de passe oublié</a>
                </div>
                <button type="submit" class="w-full text-white bg-cyan-950 hover:bg-cyan-900 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Se connecter</button>
                <p class="text-sm font-light text-gray-500">
                    <a href="/register" class="font-medium text-gray-400 hover:underline">Je n'ai pas encore de compte</a>
                </p>
            </form>
        </div>
    </div>
</div>
