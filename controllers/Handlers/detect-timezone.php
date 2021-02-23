<?php
//tz--> Timezone
setcookie("tz", $_POST['timezone'], time() + 24 * 60 * 60, '/');
