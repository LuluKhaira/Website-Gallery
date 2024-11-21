<?php
session_start();
session_destroy();
echo "<script>
alert('Logging out');
location.href ='../index.php';
</script>";
exit();
