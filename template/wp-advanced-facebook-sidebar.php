<h3><?php _e( 'Shortcode', 'demo-fb' ); ?></h3>
<hr>
<p>
  <code><?php _e( '[facebok_login]', 'demo-fb' ); ?></code>
  <br/>
  <?php echo htmlspecialchars('<a href="#" class="login-facebook ">Login with facebook</a>'); ?>
</p>
  <hr>
<p>
  <code><?php _e( '[facebok_login text="Facebook login"]', 'demo-fb' ); ?></code>
  <br/>
  <?php echo htmlspecialchars('<a href="#" class="login-facebook ">Facebook login</a>'); ?>
</p>
<hr>
<p>
  <code><?php _e( '[facebok_login url="Facebook_Logo.png"  width="20px" height="20px" class="my-facebook-css"] ', 'demo-fb' ); ?></code>
  <br/>
  <?php echo htmlspecialchars('<a href="#" class="login-facebook my-facebook-css"><img src="Facebook_Logo.png" width="30px" height="40px"></a>'); ?>
</p>
<hr>
