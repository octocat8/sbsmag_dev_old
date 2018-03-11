<?php

require_once("config/db.php");
require_once("classes/Registration.php");
if (isset($_GET['authorised'])) {
    $registration = new Registration();
    include("views/register.php");
} else {
    echo "not authorised";
}

