<h1 class="mt-10 text-4xl text-center">Commençons l'expérience</h1>
<p class="text-center mt-2">
    J'espère que tu vas bien, qu'as-tu rêvé récemment ?</p>
<div id="chat" class="mt-5 container mx-auto">
    <div id='fake_form' class="w-3/5 flex flex-col items-center mx-auto">
        <div id="meta_keys" class="w-full p-3" style="min-height: 45vh; max-height: 45vh; overflow-y: auto;">
        </div>
        <span class="animate-pulse self-end text-xl" title="Il te suffit répondre aux questions en décrivant le plus explicitement possible tout en faisant une phrase complète. Si tu penses avoir donné assez d’information tu peux directement appuyer sur « Recevoir ma prédiction » et nous feront tout pour prédire et interpréter ton rêve, mais aussi de générer une image en lien avec ce que tu as rêvé afin de revivre ce moment joyeux."><i class="fa-solid fa-info-circle"></i></span>
        <div id="meta_values" class="w-full flex p-3">
            <textarea style="resize: none; height: 15vh;" type="text" name="content" id="content" placeholder="Message" class="input w-full p-3 bg-white text-black" onkeyup="(e) => {
                if (e.keyCode === 'Enter') {
                    dreamMeta();
                }

                return;
            }"></textarea>
            <button class="my-auto btn btn-info text-black ml-4" id="add_meta" onclick="dreamMeta()">+ Ajouter</button>
        </div>
        <form method="POST" id='form-dream'>
            <input type="hidden" name="action" value="save_dream" />
        </form>
    </div>
</div>
<script>
    var count = 1;

    document.addEventListener('DOMContentLoaded', () => {
        getMetaKeys(count);
    });

    function getMetaKeys(id) {
        $.ajax({
            type: "POST", //Méthode à employer POST ou GET 
            url: "/api",
            data: {
                action: 'get_meta_keys',
                id: id
            },
            dataType: "json", //Type de données à recevoir, ici, du HTML.
            success: function(data) {
                if (!data) {
                    return;
                }

                let metaKeys = document.getElementById('meta_keys');
                let p = document.createElement('div');
                let div = document.createElement('div');

                p.innerText = data;
                p.classList.add('chat-bubble', 'bg-sky-700', 'text-white', 'shadow-md', 'hover:animate-bounce');
                div.classList.add('chat', 'chat-start');
                div.append(p);
                metaKeys.append(div);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function addMetaValues(content) {
        $.ajax({
            type: "POST", //Méthode à employer POST ou GET 
            url: "/api",
            data: {
                action: 'add_meta_values',
                value: content,
                id: count
            },
            dataType: "json",
            success: function(data) {
                if (!data) {
                    return;
                }

                let metaKeys = document.getElementById('meta_keys');
                let p = document.createElement('div');
                let div = document.createElement('div');

                p.innerText = data;
                p.classList.add('chat-bubble', 'bg-sky-950', 'text-white', 'shadow-md', 'hover:animate-bounce');
                div.classList.add('chat', 'chat-end');

                div.append(p);
                metaKeys.append(div);

            count++;
            getMetaKeys(count);
            
            if (!document.getElementById('submit')) {
                let submit = document.createElement('button');
                submit.innerText = 'Recevoir ma prédiction';
                submit.classList.add('btn', 'rounded-full', 'bg-green-500', 'hover:bg-green-200', 'text-black');
                submit.id = 'submit';
                submit.setAttribute('type', 'submit');
                
                document.getElementById('form-dream').append(submit);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
    }

    function dreamMeta() {
        let content = document.getElementById('content');

        if (!content.value) {
            return;
        }

        addMetaValues(content.value);

        document.getElementById('content').value = '';

        return;
    }
</script>