<?php

$SERVER = "fdb1034.awardspace.net";
$USERNAME = "4471370_wishlist";
$PSSWRD = "WebTech2024!";
$DATABASE = "4471370_wishlist";

$conn = new mysqli($SERVER, $USERNAME, $PSSWRD, $DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "";