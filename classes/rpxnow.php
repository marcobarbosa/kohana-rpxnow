<?php defined('SYSPATH') OR die('No direct access allowed.');

// URL: http://gist.github.com/291396

// Below is a very simple PHP 5 script that implements the RPX token URL processing.
// The code below assumes you have the CURL HTTP fetching library.

class Rpxnow {

    protected $config = array();

    function __construct()
    {
        $this->config = Kohana::config('rpxnow');
    }

    function rpxnow_script_tag()
    {
        $script = "";
        $script .= "<script type=\"text/javascript\">";
        $script .= "var rpxJsHost = ((\"https:\" == document.location.protocol) ? \"https://\" : \"http://static.\");";
        $script .= "document.write(unescape(\"%3Cscript src='\" + rpxJsHost +";
        $script .= "\"rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E\"));";
        $script .= "RPXNOW.language_preference = ".$this->config->language.";";
        $script .= "RPXNOW.overlay = ".$this->config->overlay.";";
        $script .= "</script>";
        return $script;
    }

    function openid_auth()
    {
        if(isset($_POST['token'])) {

            /* STEP 1: Extract token POST parameter */
            $token = $_POST['token'];

            /* STEP 2: Use the token to make the auth_info API call */
            $post_data = array('token' => $_POST['token'],
            'apiKey' => $this->config->api_key,
            'format' => 'json');

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $raw_json = curl_exec($curl);
            curl_close($curl);

            /* STEP 3: Parse the JSON auth_info response */
            $auth_info = json_decode($raw_json, true);

            if ($auth_info['stat'] == 'ok') {

                /* STEP 3 Continued: Extract the 'identifier' from the response */
                $profile = $auth_info['profile'];
                $identifier = $profile['identifier'];

                if (isset($profile['photo']))  {
                $photo_url = $profile['photo'];
                }

                if (isset($profile['displayName']))  {
                $name = $profile['displayName'];
                }

                if (isset($profile['email']))  {
                $email = $profile['email'];
                }

                /* STEP 4: Use the identifier as the unique key to sign the user into your system.
                This will depend on your website implementation, and you should add your own
                code here.
                */
            } //end of auth_info == ok
            /* an error occurred */
        } else {
            // gracefully handle the error.  Hook this into your native error handling system.
            echo 'An error occured: ' . $auth_info['err']['msg'];
        }
    } //end of openid_auth function

} // end of class
