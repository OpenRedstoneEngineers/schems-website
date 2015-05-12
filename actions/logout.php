<?php

$_SESSION['loggedin'] = false;
setcookie("username", "");
setcookie("uuid", "");
setcookie("accesstoken", "");
setcookie("clienttoken", "");
redirect("login");
