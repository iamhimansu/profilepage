<script>
    localStorage.removeItem("DOMELEMENTS");
</script>
<?php
session_name("PP");
session_start();
session_destroy();

header('location:login');
