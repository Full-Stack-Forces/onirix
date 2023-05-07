<h1>Chat</h1>
<div id="chat">
    <div id='fake_form'>
        <div id="meta_keys">
        </div>
        <div id="meta_values">
            <textarea type="text" name="content" id="content" placeholder="Message" onkeyup="(e) => {
                if (e.keyCode === 13) {
                    dreamMeta();
                }

                return;
            }"></textarea>
            <button id="add_meta" onclick="dreamMeta()">+</button>
        </div>
    </div>
    <form method="POST">
        <button id="submit" type="submit">Envoyer</button>
        <input type="hidden" name="action" value="save_dream" />
    </form>
</div>
<script>
    var count = 1;

    document.addEventListener('DOMContentLoaded', () => {
        var submit = document.getElementById('submit');
        submit.disabled = true;

        getMetaKeys(count);
    });

    function getMetaKeys(id) {
        $.ajax({
        type: "POST",             //Méthode à employer POST ou GET 
        url: "/api",
        data: {
            action: 'get_meta_keys',
            id: id
        },
        dataType: "json",         //Type de données à recevoir, ici, du HTML.
        success: function (data) {
            if (!data) { return; }
            
            let metaKeys = document.getElementById('meta_keys');
            let p = document.createElement('p');
            p.innerText = data;
            p.classList.add('ia');
            metaKeys.append(p);
        },
        error: function (data) {
            console.log(data);
        }
    });
    }

    function addMetaValues(content) {
        $.ajax({
        type: "POST",             //Méthode à employer POST ou GET 
        url: "/api",
        data: {
            action: 'add_meta_values',
            value: content,
            id: count
        },
        dataType: "json",         
        success: function (data) {
            if (!data) {
                return;
            }

            let metaKeys = document.getElementById('meta_keys');
            let p = document.createElement('p');
            p.innerText = data;
            p.classList.add('me');
            metaKeys.append(p);
            count++;
            getMetaKeys(count);
            submit.disabled = false;
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