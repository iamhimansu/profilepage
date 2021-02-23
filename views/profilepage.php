<?php
// echo $pagename;
//Require controllers
require_once 'controllers/database.php';
require 'controllers/modules/Encryption.php';
require_once 'controllers/modules/base_url.php';

$page_exists = false;

$get_pages = $dbh->prepare("SELECT `page_name`, `link_configs` FROM `links` WHERE `page_name` = '$pagename' LIMIT 1");
$get_pages->execute();
$page = $get_pages->fetch();

if ($page['page_name']) {
    $page_exists = true;
} else {
    $page_exists = false;
    echo "Page not exist";
    return;
}

if ($page_exists !== false) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page['page_name']; ?> - ProfilePage</title>
        <link rel="stylesheet" href="<?php echo with_base_url('css/bootstrap.min.css') ?>" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo with_base_url('css/page.themes.css'); ?>" />

    </head>

    <body class="gradient-blue">
        <div class="container-sm px-5">
            <div class="user-links mt-3">
                <ul class="nav flex-column">
                    <?php
                    $get_links = $page['link_configs'];

                    $decode_links = json_decode($get_links, true);
                    if ($decode_links != 0) {

                        foreach ($decode_links as $links => $link) {
                            if (is_array($link) && !$link['link_title'] == "" && !$link['link_address'] == "") {
                    ?>
                                <li class="nav-item <?php echo ($link['status'] == '404' ? 'border-danger' :  'border-success') ?>">
                                    <a class="nav-link" target="_blank" href="<?php echo urldecode($link['link_address']); ?>">
                                        <!-- <i class="material-icons">face</i> -->
                                        <?php echo $link['link_title']; ?>
                                    </a>
                                </li>
                    <?php
                                // echo $key . ': ' . $value . '<br/>';
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </body>

    </html>
<?php
}
?>