<?php
require_once 'controllers/database.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/modules/Encryption.php';
include 'controllers/functions.php';

$handle = new CodeFlirt\Handlers;

?>
<html>

<head>
    <title>controllers/modules/qrcode.php qr code test</title>
    <link rel="stylesheet" href="http://localhost/ProfilePage/css/app.min.css" />

    <style>
        body {
            font-family: Helvetica, sans-serif;
            padding: 1em;
        }
    </style>
</head>

<body>
    <style>
        .selected {
            /* padding: 5px; */
            background-color: white;
            border: 5px dashed #bababa;
            box-shadow: 0px 0px 6px 6px #7c7c7c;
            z-index: 999 !important;
        }

        .backdrop {
            background-color: #e5e5e5;
        }
    </style>
    <?php echo md5("iamhimanshu7102@gmail.com"); ?>
    <p class="box"><img src="controllers/modules/qrcode.php?s=qrh&d=8675309"></p>
    <p class="box"><img src="controllers/plugins/qrcode/index.php?q=H&data=8675309"></p>
    <p class="box"><img src="controllers/modules/Captcha.php"></p>

    <p class="box">

        <?php
        echo $handle->generate_token('alphanumeric', 60) . '<br><br>';

        ?>
    </p>
    <div id="users">

        <!-- class="search" automagically makes an input a search field. -->
        <input class="search" placeholder="Search" />
        <!-- class="sort" automagically makes an element a sort buttons. The date-sort value decides what to sort by. -->
        <button class="sort" data-sort="name">
            Sort
        </button>

        <!-- Child elements of container with class="list" becomes list items -->
        <ul class="list">
            <li>
                <!-- The innerHTML of children with class="name" becomes this items "name" value -->
                <h3 class="name">Jonny Stromberg</h3>
                <p class="born">1986</p>
            </li>
            <li>
                <h3 class="name">Jonas Arnklint</h3>
                <p class="born">1985</p>
            </li>
            <li>
                <h3 class="name">Martina Elm</h3>
                <p class="born">1986</p>
            </li>

            <li>
                <!-- <h3 class="name">Gustaf Lindqvist</h3> -->
                <input class="block_link" value="Github issue: How to get current datetime in flatpickr" />
                <!-- <p class="born">1983</p> -->
            </li>

            <li>
                <!-- <h3 class="name">Gustaf Lindqvist</h3> -->
                <input class="block_link" value="Stackoverflow" />
                <!-- <p class="born">1983</p> -->
            </li>

        </ul>

    </div>
    <div class="progress" id="PreLoaderBar">
        <div class="indeterminate"></div>
    </div>

    <script src="<?php echo $handle->path('js/gsap/gsap.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/gsap/Draggable.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>
    <script>
        Draggable.create(".box", {
            type: "x,y",
            edgeResistance: 0.65,
            // bounds: "body",
            // lockAxis: true,
            inertia: true,
            liveSnap: true

        });
    </script>

    <script>
        let AllHtmlElements = [];

        AllHtmlElements.forEach(element => {
            let tags = document.querySelectorAll(element);
            tags.forEach(tag => {
                tag.addEventListener('mouseover', (e) => {
                    document.body.classList.add('backdrop');
                    tag.classList.add('selected');
                    e.target.addEventListener('mouseout', () => {
                        tag.classList.remove('selected');
                        document.body.classList.remove('backdrop');
                    });
                });
            })
        });
        var options = {
            valueNames: ['name', 'born', {

                attr: 'value',
                name: 'block_link'
            }]
        };

        var userList = new List('users', options);
    </script>
</body>

</html>

<pre>
<?php

session_name("PP");
session_start();

$Messages = new Messages;
$Messages->Get();

print_r($Messages->ChatLogs());

?>
<br>
<br>
<br>
<br>
<br>
<br>

<?php
// $Messages->Get("personal");


// var_dump($Messages->CountUsers());