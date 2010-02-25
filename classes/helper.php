Place this code immediately before the </body> tag in your pages:
<script type="text/javascript">
  var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
  document.write(unescape("%3Cscript src='" + rpxJsHost +
"rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
  RPXNOW.overlay = true;
  RPXNOW.language_preference = 'en';
</script>

Place the Sign In link on your pages:
<a class="rpxnow" onclick="return false;"
href="https://sohker.rpxnow.com/openid/v2/signin?token_url=http%3A%2F%2Flocalhost%2Fsohker%2Fresponse"> Sign In </a>

Place this code directly in your page where you'd like the widget to appear.
<iframe src="http://sohker.rpxnow.com/openid/embed?token_url=http%3A%2F%2Flocalhost%2Fsohker%2Fresponse" scrolling="no" frameBorder="no" allowtransparency="true" style="width:400px;height:240px"></iframe>