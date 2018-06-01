<?php $formData = ($postData = Sapper\Route::getFlashPostData()) ? $postData : $settings; ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Settings</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Settings */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Settings</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/settings">
                        <div class="text-center">
                            <h2>General</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Email Notifications:</th>
                                            <td><input type="text" class="form-control" name="settings[email-notifications]" value="<?php echo $formData['email-notifications']; ?>" data-validation="not-empty" /></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Max Assignments Per Day:
                                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="The max # of list requests that can be assigned to the same user per day"></i>
                                            </th>
                                            <td><input type="number" class="form-control" name="settings[max-requests-per-day]" value="<?php echo $formData['max-requests-per-day']; ?>" data-validation="not-empty" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h2>API Keys</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>List Certified API Key:</th>
                                            <td><input type="text" class="form-control" name="settings[list-certified-api-key]" value="<?php echo $formData['list-certified-api-key']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th>Slack API Key:</th>
                                            <td><input type="text" class="form-control" name="settings[slack-api-key]" value="<?php echo $formData['slack-api-key']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th>SendGrid API Key:</th>
                                            <td><input type="text" class="form-control" name="settings[sendgrid-api-key]" value="<?php echo $formData['sendgrid-api-key']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th>Google Maps API Key:</th>
                                            <td><input type="text" class="form-control" name="settings[google-maps-api-key]" value="<?php echo $formData['google-maps-api-key']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th>MapQuest API Key:</th>
                                            <td><input type="text" class="form-control" name="settings[mapquest-api-key]" value="<?php echo $formData['mapquest-api-key']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th>Geo-Encoding</th>
                                            <td align="left">
                                                <?php if (1 == $formData['geo-encoding']): ?>
                                                    <i class="fa fa-toggle-on geoencode-toggle"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-toggle-off geoencode-toggle"></i>
                                                <?php endif; ?>
                                                <input type="hidden" class="form-control" name="settings[geo-encoding]" value="<?php echo $formData['geo-encoding']; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Disconnect Notifications</th>
                                            <td align="left">
                                                <?php if (1 == $formData['disconnect-notifications']): ?>
                                                    <i class="fa fa-toggle-on disconnect-notifications-toggle"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-toggle-off disconnect-notifications-toggle"></i>
                                                <?php endif; ?>
                                                <input type="hidden" class="form-control" name="settings[disconnect-notifications]" value="<?php echo $formData['disconnect-notifications']; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Exception Notifications</th>
                                            <td align="left">
                                                <?php if (1 == $formData['exception-notifications']): ?>
                                                    <i class="fa fa-toggle-on exception-notifications-toggle"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-toggle-off exception-notifications-toggle"></i>
                                                <?php endif; ?>
                                                <input type="hidden" class="form-control" name="settings[exception-notifications]" value="<?php echo $formData['exception-notifications']; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-spin fa-spinner hidden"></i>
                                                    Save
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->