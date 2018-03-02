<?php $savevalues = get_option('Facebook_app');?>
<div class="tab-pane fade active in" id="dfb_general_settings">
  <form class="form-horizontal">
    <input id ="secure-checker" type="hidden" value="<?php echo wp_create_nonce( "my-special-string" ); ?>">
<fieldset>

  <div class="form-group">
    <label for="inputFacebookappid" class="col-lg-4 control-label">Facebook App ID:</label>
    <div class="col-lg-8">
      <input type="text" class="form-control" id="inputFacebookappid" placeholder="1508029919315482" value="<?php if ( ! empty ( $savevalues['facebook_app_id'] ) ) echo esc_attr( $savevalues['facebook_app_id'] ); ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputFacebookappscret" class="col-lg-4 control-label">Facebook App Secret:</label>
    <div class="col-lg-8">
      <input type="text" class="form-control" id="inputFacebookappscret" placeholder="8540bc028b634e31b0df4afe1b4de6382" value="<?php if ( ! empty ( $savevalues['facebook_app_scret'] ) ) echo esc_attr( $savevalues['facebook_app_scret'] ); ?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-4">
      <button type="submit" class="btn btn-primary" id="app-api-save">Submit</button>
    </div>
  </div>
</fieldset>
</form>

</div>
