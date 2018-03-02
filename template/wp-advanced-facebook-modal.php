<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Settings</h4>
            </div>
            <div class="modal-body">
                <ol>
                    <li>
                        <a href="https://developers.facebook.com/apps/" target="_blank">Create a facebook app!</a>
                    </li>
                    <li>Don't choose from the listed options, but click on
                        <b>advanced setup</b> in the bottom.
                    </li>
                    <li>Choose an
                        <b>app name</b>, and a
                        <b>category</b>, then click on
                        <b>Create App ID</b>.
                    </li>
                    <li>Pass the security check.</li>
                    <li>Go to the
                        <b>Settings</b> of the application.</li>
                    <li>Click on
                        <b>+ Add Platform</b>, and choose
                        <b>Website</b>.</li>
                    <li>Give your website's address at the
                        <b>Site URL</b> field with:
                        <b><?php echo get_site_url(); ?></b>
                    </li>
                    <li>Give a
                        <b>Contact Email</b> and click on
                        <b>Save Changes</b>.</li>
                    <li>Go to
                        <b>Status &amp; Review</b>, and change the availability for the general public to
                        <b>YES</b>.</li>

                    <li>Go back to the
                        <b>Settings</b>, and copy the
                        <b>App ID</b>, and
                        <b>APP Secret</b>, which you have to copy and paste below.</li>
                    <li>
                        <b>Save changes!</b>
                    </li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
