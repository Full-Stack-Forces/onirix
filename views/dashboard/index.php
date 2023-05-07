<h1 class="text-4xl text-center">Tableau de bord</h1>
<div id="dashboard" class="container mx-auto mt-10 mb-20 flex flex-col justify-center">
    <div class="stat w-1/4 p-3 bg-white text-cyan-900 rounded-md shadow-md my-5 mx-auto">
        <div class="stat-figure text-secondary">
            <div class="avatar online">
                <div class="w-12 h-12 mask mask-squircle">
                    <img src="/public/assets/img/sleep.png" alt="Sweet Dreams" />
                </div>
            </div>
        </div>
        <div class="stat-value"><?php echo round((1 - $average) * 100, 2) ?>%</div>
        <div class="stat-title text-black"><i class="fa-solid fa-bed"></i> Beaux rêves</div>
    </div>
    <a class="btn bg-cyan-900 hover:bg-cyan-800 active:bg-cyan-950 shadow-md rounded-md p-3 border-none text-white w-fit ml-auto" href="/ads">Gérer les publicités</a>
</div>