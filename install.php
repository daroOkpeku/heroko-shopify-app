<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "2fc22670e98abe4f39bc94fbac789463";
 $scopes = "read_orders,write_products";
$redirect_uri = "https://48f141a334f2.ngrok.io/dashboard/project/shopity-plug-php-master/token.php";
// Build install/approval URL to redirect to
 $install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
// // Redirect
header("Location: " . $install_url);
die();
