<?php
// 
// date_default_timezone_set("Asia/Calcutta");

// Use this namespace
use Steampixel\Route;
// Include router class
include_once __DIR__ . '/controllers/modules/Route.php';

function minify($buffer)
{

  $search = array(
    '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/',
    "/\/\*[\s\S]*?\*\/|([^:]|^)\/\/.*$/m",
    '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
    '/[^\S ]+\</s',     // strip whitespaces before tags, except space
    '/(\s)+/s',         // shorten multiple whitespace sequences
    '/<!--(.|\s)*?-->/' // Remove HTML comments
  );

  $replace = array(
    '',
    "$1",
    '>',
    '<',
    '\\1',
    ''
  );

  $buffer = preg_replace($search, $replace, $buffer);

  return $buffer;
}

ob_start("minify");

// include_once 'controllers/database.php';

// Define a global basepath
define('BASEPATH', '/ProfilePage/');

// Add base route (startpage)
Route::add('/', function () {
  include('views/welcome.php');
});
// Add base route (startpage)
Route::add('/security', function () {
  include('views/security.php');
});

// Add base route (startpage)
Route::add('/pages/customize/(P([0-9aA-zZ]*P))', function ($PAGE_ID) {
  include('views/pages-customize.php');
});
Route::add('/pages/settings/(P([0-9aA-zZ]*P))', function ($PAGE_ID) {
  include('views/page-settings.php');
});
Route::add('/pages/delete/(P([0-9aA-zZ]*P))', function ($PAGE_ID) {
  include('views/delete-pages.php');
}, ["get", "post"]);
Route::add('/pages', function () {
  include('views/pages.php');
});
// Add base route (startpage)
Route::add('/time', function () {
  include('views/time.php');
});
Route::add('/upload', function () {
  include('controllers/libs/upload-handler/test/index.html');
});
// Route::add('/inbox', function () {
//   include('views/test-inbox.php');
// });
// Add base route (startpage)
Route::add('/inbox', function () {
  include('views/inbox.php');
});
Route::add('/inbox/([0-9aA-zZ]*)', function ($get_inbox_of) {
  include('views/inbox-messages.php');
});
// TODO: Fix this for some web servers
Route::add('/signup', function () {
  include('views/signup.php');
}, ['get', 'post']);

Route::add('/login', function () {
  //
  include('views/login.php');
}, ['get', 'post']);


Route::add('/home', function () {
  include('views/home.php');
});
Route::add('/detect', function () {
  include('views/detect.php');
});

Route::add('/analytics', function () {
  include('views/analytics.php');
});

Route::add('/if', function () {
  include('views/if.php');
});

Route::add('/test', function () {
  include('views/test.php');
});

Route::add('/settings', function () {
  include('views/settings.php');
});
Route::add('/logout', function () {
  include('logout.php');
});
// Add route for publishing page
Route::add('/publish', function () {
  include('controllers/Handlers/page.publish.Handler.php');
}, 'post');

Route::add('/timezone', function () {
  require_once('controllers/Handlers/detect-timezone.php');
}, 'post');

// Add page for profilpage
// Route::add('/@([aA-zZ]*)', function ($pagename) {
//   include('views/profile.php');
// });

//Analytics
Route::add('/analytics/(P([0-9aA-zZ]*P))', function ($VIEW_ANALYTIC_ID) {

  include('views/view-analytics.php');
});
//Set session for refernce of page
Route::add('/@([0-9aA-zZ]*)/([0-9aA-zZ-]*)', function ($UserName, $PageName) {
  //Require controllers
  require_once __DIR__ . '/controllers/database.php';
  require_once __DIR__ . '/controllers/modules/Encryption.php';
  require_once __DIR__ . '/controllers/modules/core.php';
  require_once __DIR__ . '/controllers/functions.php';

  session_name("PP");
  session_start();

  $Page = new Page();
  $Page->Find("$PageName@$UserName");
  $PageDetails = $Page->Details();

  if ($PageDetails["PageRefId"] !== null && $PageDetails["OwnerRefId"] !== null) {

    $_SESSION["PageID"] = $PageDetails["PageRefId"];
    $_SESSION["OwnerID"] = $PageDetails["OwnerRefId"];

    include('views/links-re.php');
  } else {
    echo '<title>Not found</title>';
    echo 'Error 404 :-(<br>';
    echo 'The requested page "@' . $UserName . '/' . $PageName . '" was not found!';
  }
}, ['post', 'get']);

//Redirecting from short url to full url;
Route::add('/(P([0-9aA-zZ]*P))', function ($PAGEID) {
  //Set session for refernce of page
  session_name("PP");
  session_start();
  //Require controllers
  require_once __DIR__ . '/controllers/database.php';
  require_once __DIR__ . '/controllers/modules/Encryption.php';
  require_once __DIR__ . '/controllers/modules/core.php';
  require_once __DIR__ . '/controllers/functions.php';

  $Page = new Page();
  $Page->Find($PAGEID);
  $PageDetails = $Page->Details();

  if ($PageDetails["PageRefId"] !== null && $PageDetails["OwnerRefId"] !== null) {
    $OwnerDetails = (new CodeFlirt\Fetch)->data("links", "page_name", "page_id='" . $PageDetails["PageRefId"] . "' AND user_id='" . $PageDetails["OwnerRefId"] . "'");
    $page_name = explode('@', $OwnerDetails)[0];
    $user_name = explode('@', $OwnerDetails)[1];

    $_SESSION["PageID"] = $PageDetails["PageRefId"];
    $_SESSION["OwnerID"] = $PageDetails["OwnerRefId"];

    header("location:@$user_name/$page_name");
  } else {
    echo '<title>Not found</title>';
    echo 'Error 404 :-(<br>';
    echo 'The requested page ' . $pagename . ' was not found!';
  }
});

// Add a 404 not found route
Route::pathNotFound(function ($path) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  //header('HTTP/1.0 404 Not Found');
  //echo '<title>Not found</title>';
  //echo 'Error 404 :-(<br>';
  //echo 'The requested path "' . $path . '" was not found!';
  include('error.php');
  exit();
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function ($path, $method) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 405 Method Not Allowed');
  echo 'Error 405 :-(<br>';
  echo 'The requested path "' . $path . '" exists. But the request method "' . $method . '" is not allowed on this path!';
});

// Run the Router with the given Basepath
Route::run(BASEPATH);
?>
<link rel="stylesheet" href="<?php echo (new CodeFlirt\Handlers)->path('js/libs/nprogress/nprogress.css'); ?>" />
<script src="<?php echo (new CodeFlirt\Handlers)->path('js/libs/nprogress/nprogress.js'); ?>"></script>
<!--End libraries-->

<script>
  function initPlugins() {
    Links();
  }
  $(".navbar-vertical.navbar-expand-md .navbar-nav .nav-item > .nav-link").on("click", function() {
    $(".nav-item > .nav-link").removeClass("active");
    $(this).addClass("active");
  });
  $("[data-ajax]").on("click", function(e) {
    e.preventDefault();

    var dataUrl = $(this).attr("href");
    window.history.pushState("oldone", "old", dataUrl);
    window.history.replaceState("newone", "current", dataUrl);
    /**Load into container */
    $(".main-content").load(
      "" + dataUrl + " .main-content > *",
      function(resp) {
        if (resp) {
          $("#container").html(resp.responseText);
          /* console.log(resp);*/
        }
      }
    );
    // initPlugins();
  });
  $(document).ajaxStart(function() {
    NProgress.start();
  });
  $(document).ajaxComplete(function() {
    NProgress.done();
  });
  $(document).ajaxSuccess(function() {
    NProgress.remove();
  });
  NProgress.configure({
    minimum: 0.1,
    showSpinner: false
  });
</script>

<?php
ob_end_flush();
?>