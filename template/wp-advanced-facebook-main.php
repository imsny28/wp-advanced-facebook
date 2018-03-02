<!--div class="loader"><img src="<?php echo esc_url( plugins_url( 'assets/images/loader.gif', dirname(__FILE__)   )); ?>" id="loading-animation"></div>-->
<div class="container">

  <!-- Start Header-->
    <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-header') ?>
  <!-- End Header-->
  <div class="row">
    <div class="message-shown">

    </div>
  </div>
  <div class="row">
    <div class="col-lg-8">

      <!-- Start Menu Bar -->
        <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-menubar') ?>
      <!-- End Menu bar -->

      <div class="col-lg-12">
        <div id="myTabContent" class="tab-content">
          <!-- Start Tab content ( General Settings )  -->
            <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-general-settings', 'tab-content') ?>
          <!-- End Tab Content ( General Settings ) -->

          <!-- Start Tab content ( Adanced Settings )  -->
            <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-advanced-settings', 'tab-content') ?>
          <!-- End Tab Content ( Adanced Settings ) -->
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <!-- Start Tab content ( Admin Sidebar )  -->
        <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-sidebar') ?>

      <!-- End Tab Content ( Admin Sidebar ) -->
    </div>
  </div>
  <!-- Start Modal-->
    <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-modal') ?>
  <!-- End Modal-->
  <!-- Start Modal-->
    <?php AdvancedFacebook::wp_admin_template('wp-advanced-facebook-welcome') ?>
  <!-- End Modal-->
</div>
