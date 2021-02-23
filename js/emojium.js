"user strict";

let emoticons_face_emojis =
    '😀 😃 😄 😁 😆 😅 😂 🤣 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🤩 🥳 😏 😒 😞 😔 😟 😕 🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨 😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😬 🙄 😯 😦 😧 😮 😲 🥱 😴 🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕 🤑 🤠 😈 👿 👹 👺 🤡 💩 👻 💀 ☠️ 👽 👾 🤖 🎃 😺 😸 😹 😻 😼 😽 🙀 😿 😾';
let emoticons_hand_gestures =
    '👋 🤚 🖐 ✋ 🖖 👌 🤏 ✌️ 🤞 🤟 🤘 🤙 👈 👉 👆 🖕 👇 ☝️ 👍 👎 ✊ 👊 🤛 🤜 👏 🙌 👐 🤲 🤝 🙏 ✍️ 💅 🤳 💪 🦾 🦵 🦿 🦶 👣 👂 🦻 👃 🧠 🦷 🦴 👀 👁 👅 👄 💋 🩸';
let emoticons_animal_nature =
    '🐶 🐱 🐭 🐹 🐰 🦊 🐻 🐼 🐻‍❄️ 🐨 🐯 🦁 🐮 🐷 🐽 🐸 🐵 🙈 🙉 🙊 🐒 🐔 🐧 🐦 🐤 🐣 🐥 🦆 🦅 🦉 🦇 🐺 🐗 🐴 🦄 🐝 🐛 🦋 🐌 🐞 🐜 🦟 🦗 🕷 🕸 🦂 🐢 🐍 🦎 🦖 🦕 🐙 🦑 🦐 🦞 🦀 🐡 🐠 🐟 🐬 🐳 🐋 🦈 🐊 🐅 🐆 🦓 🦍 🦧 🐘 🦛 🦏 🐪 🐫 🦒 🦘 🐃 🐂 🐄 🐎 🐖 🐏 🐑 🦙 🐐 🦌 🐕 🐩 🦮 🐕‍🦺 🐈 🐈‍⬛ 🐓 🦃 🦚 🦜 🦢 🦩 🕊 🐇 🦝 🦨 🦡 🦦 🦥 🐁 🐀 🐿 🦔 🐾 🐉 🐲 🌵 🎄 🌲 🌳 🌴 🌱 🌿 ☘️ 🍀 🎍 🪴 🎋 🍃 🍂 🍁 🍄 🐚 🪨 🌾 💐 🌷 🌹 🥀 🌺 🌸 🌼 🌻 🌞 🌝 🌛 🌜 🌚 🌕 🌖 🌗 🌘 🌑 🌒 🌓 🌔 🌙 🌎 🌍 🌏 🪐 💫 ⭐️ 🌟 ✨ ⚡️ ☄️ 💥 🔥 🌪 🌈 ☀️ 🌤 ⛅️ 🌥 ☁️ 🌦 🌧 ⛈ 🌩 🌨 ❄️ ☃️ ⛄️ 🌬 💨 💧 💦 ☔️ ☂️ 🌊 🌫';
let emoticons_food_drink =
    '🍏 🍎 🍐 🍊 🍋 🍌 🍉 🍇 🍓  🍈 🍒 🍑 🥭 🍍 🥥 🥝 🍅 🍆 🥑 🥦 🥬 🥒 🌽 🥕 🧄 🧅 🥔 🍠 🥐 🥯 🍞 🥖 🥨 🧀 🥚 🍳 🧈 🥞 🧇 🥓 🥩 🍗 🍖 🦴 🌭 🍔 🍟 🍕 🥪 🥙 🧆 🌮 🌯 🥗 🥘 🥫 🍝 🍜 🍲 🍛 🍣 🍱 🥟 🦪 🍤 🍙 🍚 🍘 🍥 🥠 🥮 🍢 🍡 🍧 🍨 🍦 🥧 🧁 🍰 🎂 🍮 🍭 🍬 🍫 🍿 🍩 🍪 🌰 🥜 🍯 🥛 🍼 🫖 ☕️ 🍵 🧃 🥤 🧋 🍶 🍺 🍻 🥂 🍷 🥃 🍸 🍹 🧉 🍾 🧊 🥄 🍴 🍽 🥣 🥡 🥢 🧂';
let emoticons_travel_places =
    '⚽️ 🏀 🏈 ⚾️ 🥎 🎾 🏐 🏉 🥏 🎱 🪀 🏓 🏸 🏒 🏑 🥍 🏏 🪃 🥅 ⛳️ 🪁 🏹 🎣 🤿 🥊 🥋 🎽 🛹 🛷 ⛸ 🥌 🎿 ⛷ 🏂 🪂 🏋️‍♀️ 🏋️ 🏋️‍♂️ 🤼‍♀️ 🤼 🤼‍♂️ 🤸‍♀️ 🤸 🤸‍♂️ ⛹️‍♀️ ⛹️ ⛹️‍♂️ 🤺 🤾‍♀️ 🤾 🤾‍♂️ 🏌️‍♀️ 🏌️ 🏌️‍♂️ 🏇 🧘‍♀️ 🧘 🧘‍♂️ 🏄‍♀️ 🏄 🏄‍♂️ 🏊‍♀️ 🏊 🏊‍♂️ 🤽‍♀️ 🤽 🤽‍♂️ 🚣‍♀️ 🚣 🚣‍♂️ 🧗‍♀️ 🧗 🧗‍♂️ 🚵‍♀️ 🚵 🚵‍♂️ 🚴‍♀️ 🚴 🚴‍♂️ 🏆 🥇 🥈 🥉 🏅 🎖 🏵 🎗 🎫 🎟 🎪 🤹 🤹‍♂️ 🤹‍♀️ 🎭 🩰 🎨 🎬 🎤 🎧 🎼 🎹 🥁 🪘 🎷 🎺 🪗 🎸 🪕 🎻 🎲 ♟ 🎯 🎳 🎮 🎰 🧩';
let emoticons_objects_fig =
    ' 📮 📯 📜 📃 📄 📑 🧾 📊 📈 📉 🗒 🗓 📆 📅 🗑 📇 🗃 🗳 🗄 📋 📁 📂 🗂 🗞 📰 📓 📔 📒 📕 📗 📘 📙 📚 📖 🔖 🧷 🔗 📎 🖇 📐 📏 🧮 📌 📍 ✂️ 🖊 🖋 ✒️ 🖌 🖍 📝 ✏️ 🔍 🔎 🔏 🔐 🔒 🔓';
let emoticons_symbols_misc =
    '❤️ 🧡 💛 💚 💙 💜 🖤 🤍 🤎 💔 ❣️ 💕 💞 💓 💗 💖 💘 💝 💟 ☮️ ✝️ ☪️ 🕉 ☸️ ✡️ 🔯 🕎 ☯️ ☦️ 🛐 ⛎ ♈️ ♉️ ♊️ ♋️ ♌️ ♍️ ♎️ ♏️ ♐️ ♑️ ♒️ ♓️ 🆔 ⚛️ 🉑 ☢️ ☣️ 📴 📳 🈶 🈚️ 🈸 🈺 🈷️ ✴️ 🆚 💮 🉐 ㊙️ ㊗️ 🈴 🈵 🈹 🈲 🅰️ 🅱️ 🆎 🆑 🅾️ 🆘 ❌ ⭕️ 🛑 ⛔️ 📛 🚫 💯 💢 ♨️ 🚷 🚯 🚳 🚱 🔞 📵 🚭 ❗️ ❕ ❓ ❔ ‼️ ⁉️ 🔅 🔆 〽️ ⚠️ 🚸 🔱 ⚜️ 🔰 ♻️ ✅ 🈯️ 💹 ❇️ ✳️ ❎ 🌐 💠 Ⓜ️ 🌀 💤 🏧 🚾 ♿️ 🅿️ 🛗 🈳 🈂️ 🛂 🛃 🛄 🛅 🚹 🚺 🚼 ⚧ 🚻 🚮 🎦 📶 🈁 🔣 ℹ️ 🔤 🔡 🔠 🆖 🆗 🆙 🆒 🆕 🆓 0️⃣ 1️⃣ 2️⃣ 3️⃣ 4️⃣ 5️⃣ 6️⃣ 7️⃣ 8️⃣ 9️⃣ 🔟 🔢 #️⃣ *️⃣ ⏏️ ▶️ ⏸ ⏯ ⏹ ⏺ ⏭ ⏮ ⏩ ⏪ ⏫ ⏬ ◀️ 🔼 🔽 ➡️ ⬅️ ⬆️ ⬇️ ↗️ ↘️ ↙️ ↖️ ↕️ ↔️ ↪️ ↩️ ⤴️ ⤵️ 🔀 🔁 🔂 🔄 🔃 🎵 🎶 ➕ ➖ ➗ ✖️ ♾ 💲 💱 ™️ ©️ ®️ 〰️ ➰ ➿ 🔚 🔙 🔛 🔝 🔜 ✔️ ☑️ 🔘 🔴 🟠 🟡 🟢 🔵 🟣 ⚫️ ⚪️ 🟤 🔺 🔻 🔸 🔹 🔶 🔷 🔳 🔲 ▪️ ▫️ ◾️ ◽️ ◼️ ◻️ 🟥 🟧 🟨 🟩 🟦 🟪 ⬛️ ⬜️ 🟫 🔈 🔇 🔉 🔊 🔔 🔕 📣 📢 👁‍🗨 💬 💭 🗯 ♠️ ♣️ ♥️ ♦️ 🃏 🎴 🀄️ 🕐 🕑 🕒 🕓 🕔 🕕 🕖 🕗 🕘 🕙 🕚 🕛 🕜 🕝 🕞 🕟 🕠 🕡 🕢 🕣 🕤 🕥 🕦 🕧';

let emoticons_face = emoticons_face_emojis.split(' ');
let emoticons_gestures = emoticons_hand_gestures.split(' ');
let emoticons_nature = emoticons_animal_nature.split(' ');
let emoticons_foods = emoticons_food_drink.split(' ');
let emoticons_places = emoticons_travel_places.split(' ');
let emoticons_objects = emoticons_objects_fig.split(' ');
let emoticons_symbols = emoticons_symbols_misc.split(' ');

let emoji_template = function (embed_emoji) {
    return '<div class="emoticon"><button type="button" class="btn bg-transparent p-0 m-0">' + embed_emoji.trim() + '</button></div>';
}

let emoji_container = function () {
    return `
    <div class="list-group-item emojis-container bg-white-soft shadow p-0 w-100 rounded">
    <ul class="nav nav-tabs px-3 nav-overflow mx-2" role="tablist">
        <li class="nav-item">
            <a class="nav-link py-2 active" data-toggle="tab" href="#faces">
                😀
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#gestures">
                👍
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#natures">
                🐼
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#foods">
                ☕️
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#places">
                ⚽️
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#objects">
                📆
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" data-toggle="tab" href="#symbols">
                ❤️
            </a>
        </li>
    </ul>
    <div class="emojis">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="faces">
                <div class="face_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="gestures">
                <div class="gesture_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="natures">
                <div class="nature_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="foods">
                <div class="food_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="places">
                <div class="place_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="objects">
                <div class="object_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
            <div class="tab-pane fade" id="symbols">
                <div class="symbol_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                </div>
            </div>
        </div>
    </div>
</div>
    `;
}

function injectEmojis() {
    emoticons_face.forEach(function (emoji_faces) {
        $(".face_emojis").append(emoji_template(emoji_faces));
    });
    emoticons_gestures.forEach(function (emoji_gestures) {
        $(".gesture_emojis").append(emoji_template(emoji_gestures));
    });
    emoticons_nature.forEach(function (emoji_nature) {
        $(".nature_emojis").append(emoji_template(emoji_nature));
    });
    emoticons_foods.forEach(function (emoji_food) {
        $(".food_emojis").append(emoji_template(emoji_food));
    });
    emoticons_places.forEach(function (emoji_place) {
        $(".place_emojis").append(emoji_template(emoji_place));
    });
    emoticons_objects.forEach(function (emoji_object) {
        $(".object_emojis").append(emoji_template(emoji_object));
    });
    emoticons_symbols.forEach(function (emoji_symbol) {
        $(".symbol_emojis").append(emoji_template(emoji_symbol));
    });

}

function emojium(onElement, injectEmojisOn) {
    let Elements = document.querySelectorAll(onElement);
    Elements.forEach(function (allOnElement) {
        allOnElement.addEventListener('click', function (ex) {
            if (document.querySelectorAll(".emojium").length > 0) {
                $(".emojium").remove();
                return;
            };

            let emojisContainer = document.createElement('div');
            emojisContainer.setAttribute("id", "emojium");
            emojisContainer.classList.add("emojium");
            emojisContainer.setAttribute("style", "width: inherit !important");
            emojisContainer.style["height"] = "250px";
            emojisContainer.style["position"] = "absolute";
            emojisContainer.style["left"] = "-20rem";
            emojisContainer.style["bottom"] = "2rem";
            emojisContainer.innerHTML = emoji_container();
            allOnElement.before(emojisContainer);
            injectEmojis();
        });
        $(injectEmojisOn).on('click', function () {
            $(".emojium").remove();
        });
    })
    $("body").on('click', '.emoticon', function () {
        $(injectEmojisOn).val(injectEmojisOn.val() + $(this).text()),
            $(injectEmojisOn).focus();
    });
}