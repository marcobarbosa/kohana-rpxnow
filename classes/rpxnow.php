<?php defined('SYSPATH') OR die('No direct access allowed.');

// SOURCE: http://gist.github.com/291396

// Below is a very simple PHP 5 script that implements the RPX token URL processing.
// The code below assumes you have the CURL HTTP fetching library.

class Rpxnow {

    protected $config = array();

    function __construct()
    {
        $this->config = Kohana::config('rpxnow');
    }

    static function rpxnow_script_tag()
    {
        $script = "";
        $script .= "<script type=\"text/javascript\">";
        $script .= "var rpxJsHost = ((\"https:\" == document.location.protocol) ? \"https://\" : \"http://static.\");";
        $script .= "document.write(unescape(\"%3Cscript src='\" + rpxJsHost +";
        $script .= "\"rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E\"));";
        $script .= "RPXNOW.language_preference = ".Kohana::config('rpxnow')->language;
        $script .= "RPXNOW.overlay = ".Kohana::config('rpxnow')->overlay;
        $script .= "</script>";
        return $script;
    }

    static function rpxnow_anchor_tag()
    {
        $anchor = "";
        $anchor .= "<a class=\"rpxnow\" onclick=\"return false;\" href=\"https://".Kohana::config('rpxnow')->domain."/openid/v2/signin?token_url=".rawurlencode(Kohana::config('rpxnow')->token_url).">".Kohana::config('rpxnow')->anchor_text."</a>";
        return $anchor;
    }

    static function rpxnow_iframe_tag()
    {
        $iframe = "";
        $iframe .= "<iframe src=\"http://".Kohana::config('rpxnow')->domain."/openid/embed?token_url=".rawurlencode(Kohana::config('rpxnow')->token_url)." scrolling=\"no\" frameBorder=\"no\" allowtransparency=\"true\" style=\"width:400px;height:240px\"></iframe>";
        return $iframe;
    }

    function openid_auth()
    {
        $return = '';
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
            $return = $auth_info;

        } else {
          // gracefully handle the error.  Hook this into your native error handling system.
          //echo 'An error occured: ' . $auth_info['err']['msg'];
          $return = FALSE;
      }
        return $return;
    } //end of openid_auth function

} // end of class
