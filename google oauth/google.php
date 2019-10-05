<?php require ("vendor/autoload.php");
// 1. enter your google account credentials
$g_client = new Google_Client();
$g_client->setClientId("625389164645-btbi7rnr6sosqbsq7ms6g7b58r6j6arr.apps.googleusercontent.com");
$g_client->setClientSecret("E6iLIRpnOafSxI9-0xNQcp9v");
$g_client->setRedirectUri("http://localhost/google%20oauth/google.php");
$g_client->setScopes("email");

//2. create the url
$auth_url = $g_client->createAuthUrl();
echo "<a href='$auth_url'>Login Through Google</a>";
//3. get the authorization code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;

//4 get access token
if(isset($code)) {
    try {
        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);
    }catch (Exception $e){
        echo $e->getMessage();
    }

    try{
        $pay_load = $g_client->verifyIdToken();
         
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}else{
    
        $pay_load = null;
}
echo $pay_load["email"];
