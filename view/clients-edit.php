<?php
    use Sapper\Route,
        Sapper\Util;
?>
<?php $clientFormData  = ($clientPostData  = Route::getFlashPostData('client'))  ? $clientPostData  : $client; ?>
<?php $clientHSFormData  = ($clientHSPostData  = Route::getFlashPostData('healthScores'))  ? $clientHSPostData  : $healthScores; ?>
<?php $clientMonthMeetings  = ($clientHSPostData  = Route::getFlashPostData('monthMeetings'))  ? $clientHSPostData  : $monthMeetings; ?>
<?php $profileFormData = ($profilePostData = Route::getFlashPostData('profile')) ? $profilePostData : ['name' => '']; ?>
<?php $healthScore = Util::calculateHealthScore($clientHSFormData); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Client Directory</li>
            <li class="active">Edit Client</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div class="row">

        <?php /** Left Col */ ?>
        <div class="col-sm-12 col-sm-offset-0 col-md-4">

            <?php /** Basic Information */ ?>
            <div class="panel panel-default">
                <div class="panel-heading">Basic Information</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/clients/edit/<?php echo $client['id']; ?>">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td><input type="text" class="form-control" name="name" value="<?php echo $clientFormData['name']; ?>" data-validation="not-empty" /></td>
                                    </tr>
                                    <tr>
                                        <th>Sign On Date</th>
                                        <td><input type="text" class="form-control datepicker-here" name="sign_on_date" value="<?php echo !empty($clientFormData['sign_on_date']) ? Util::convertDate($clientFormData['sign_on_date'], 'Y-m-d', 'm/d/Y') : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Launch Date</th>
                                        <td><input type="text" class="form-control datepicker-here" name="launch_date" value="<?php echo !empty($clientFormData['launch_date']) ? Util::convertDate($clientFormData['launch_date'], 'Y-m-d', 'm/d/Y') : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Expiration Date</th>
                                        <td><input type="text" class="form-control datepicker-here" name="expiration_date" value="<?php echo !empty($clientFormData['expiration_date']) ? Util::convertDate($clientFormData['expiration_date'], 'Y-m-d', 'm/d/Y') : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Contract Goal</th>
                                        <td><input type="text" class="form-control" name="contract_goal" value="<?php echo $clientFormData['contract_goal']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Monthly Goal</th>
                                        <td><input type="text" class="form-control" name="monthly_goal" value="<?php echo $clientFormData['monthly_goal']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>CSM</th>
                                        <td>
                                            <select name="user_id" class="form-control" data-validation="not-empty">
                                                <option value=""></option>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['value'];?>" <?php echo $clientFormData['user_id'] == $user['value'] ? 'selected' : ''; ?>>
                                                        <?php echo $user['text']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ProsperWorks</th>
                                        <td>
                                            <select name="prosperworks_id" class="form-control" data-validation="not-empty" id="company-select">
                                                <option value=""></option>
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?php echo $company['id']; ?>" <?php echo $clientFormData['prosperworks_id'] == $company['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $company['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
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
            </div><!-- /.panel -->

            <?php /** Search Profiles */ ?>
            <div class="panel panel-default">
                <div class="panel-heading">Search Profiles</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center" width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($profiles as $profile): ?>
                                        <tr>
                                            <td><?php echo $profile['name']; ?></td>
                                            <td width="100">
                                                <a href="/clients/profile-edit/<?php echo $profile['id']; ?>" class="fa fa-pencil" title="Edit"></a>
                                                <a href="/clients/profile-delete/<?php echo $profile['id']; ?>" class="fa fa-times sweet-confirm-href" title="Delete"></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.panel-body -->

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-2">
                            <form method="post" action="/clients/profile-create/<?php echo $client['id']; ?>">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control input-md" placeholder="Name" value="<?php echo $profilePostData['name']; ?>" data-validation="not-empty" />
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-spin fa-spinner hidden"></i>
                                        Create
                                    </button>
                                </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.panel-footer -->

            </div><!-- /.panel -->

        </div><!-- /.col-->

        <?php /** Right Side */ ?>
        <div class="col-sm-12 col-sm-offset-0 col-md-8">

            <?php /** Outreach Accounts */ ?>
            <div class="panel panel-default">
                <div class="panel-heading">Outreach Accounts</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="outreach-accounts-table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><strong>Email</strong></th>
                                        <th class="text-center"><strong>Status</strong></th>
                                        <th class="text-center"><strong># Prospects</strong></th>
                                        <th class="text-center"><strong>Last Pulled</strong></th>
                                        <th class="text-center"><strong>Actions</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($outreachAccounts as $outreachAccount): ?>
                                        <tr>
                                            <td><?php echo $outreachAccount['email']; ?></td>
                                            <td>
                                                <?php printf(
                                                    '<span class="status-%s">%s</span>',
                                                    $outreachAccount['status'],
                                                    ucfirst($outreachAccount['status'])
                                                ); ?>

                                                <?php if ('disconnected' == $outreachAccount['status'] && !empty($outreachAccount['disconnect_reason'])): ?>
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $outreachAccount['disconnect_reason']; ?>"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo number_format($outreachAccount['num_prospects'], 0); ?></td>
                                            <td><?php echo !is_null($outreachAccount['last_pulled_at']) ? date('M j, Y H:i',strtotime($outreachAccount['last_pulled_at'])) : ''; ?></td>
                                            <td>
                                                <?php if ('disconnected' == $outreachAccount['status']): ?>
                                                    <a href="<?php echo $outreachAccount['authUrl']; ?>" class="fa fa-plug sweet-confirm-href" title="Connect" data-sweet-title="Ready?" data-sweet-text="Ensure you're not logged into another Outreach account"></a>
                                                <?php endif; ?>

                                                <?php if ('connected' == $outreachAccount['status']): ?>
                                                    <a href="/outreach/sync/<?php echo $outreachAccount['id']; ?>" class="fa fa-refresh sweet-confirm-href" title="Sync"></a>
                                                <?php endif; ?>

                                                <?php if ('syncing' !== $outreachAccount['status']): ?>
                                                    <a href="/outreach/delete/<?php echo $outreachAccount['id']; ?>" class="fa fa-times sweet-confirm-href" title="Delete"></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-md-offset-4 text-right" style="line-height: 34px;"><strong>Link Account:</strong></div>
                        <div class="col-sm-12 col-md-4">
                            <form method="post" action="/outreach/link-account/<?php echo $client['id']; ?>">
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control input-md" placeholder="Login Email" data-validation="email" />
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-spin fa-spinner hidden"></i>
                                        Link
                                    </button>
                                </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->

            <?php /** Gmail Accounts */ ?>
            <div class="panel panel-default">
                <div class="panel-heading">Gmail Accounts</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="gmail-accounts-table">
                                <thead>
                                <tr>
                                    <th class="text-center"><strong>Email</strong></th>
                                    <th class="text-center"><strong>Status</strong></th>
                                    <th class="text-center"><strong>Last Scanned</strong></th>
                                    <th class="text-center"><strong>Actions</strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($gmailAccounts as $gmailAccount): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <span class="pull-left"><strong>Inbox:</strong></span>
                                                <span class="pull-right"><?php echo $gmailAccount['email']; ?></span>
                                            </div>
                                            <div>
                                                <span class="pull-left"><strong>Survey Invites:</strong></span>
                                                <span class="pull-right">
                                                    <?php if ('' != $gmailAccount['survey_email']): ?>
                                                        <a class="edit-survey-email" data-account-id="<?php echo $gmailAccount['id']; ?>"><?php echo $gmailAccount['survey_email']; ?></a>
                                                    <?php else: ?>
                                                        <a class="set-survey-email" data-account-id="<?php echo $gmailAccount['id']; ?>">add</a>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="pull-left"><strong>Survey Results:</strong></span>
                                                <span class="pull-right">
                                                    <?php if ('' != $gmailAccount['survey_results_email']): ?>
                                                        <a class="edit-survey-results-email" data-account-id="<?php echo $gmailAccount['id']; ?>"><?php echo $gmailAccount['survey_results_email']; ?></a>
                                                    <?php else: ?>
                                                        <a class="set-survey-results-email" data-account-id="<?php echo $gmailAccount['id']; ?>">add</a>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php printf(
                                                '<span class="status-%s">%s</span>',
                                                $gmailAccount['status'],
                                                ucfirst($gmailAccount['status'])
                                            ); ?>

                                            <?php if ('disconnected' == $gmailAccount['status'] && !empty($gmailAccount['disconnect_reason'])): ?>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $gmailAccount['disconnect_reason']; ?>"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo !is_null($gmailAccount['last_scanned_at']) ? date('M j, Y H:i',strtotime($gmailAccount['last_scanned_at'])) : ''; ?></td>
                                        <td>
                                            <?php if ('disconnected' == $gmailAccount['status']): ?>
                                                <a href="/gmail/re-auth/<?php echo $gmailAccount['id']; ?>" class="fa fa-plug sweet-confirm-href" title="Connect"></a>
                                            <?php endif; ?>

                                            <?php if ('connected' == $gmailAccount['status']): ?>
                                                <a href="/gmail/disconnect/<?php echo $gmailAccount['id']; ?>" class="fa fa-chain-broken sweet-confirm-href" title="Disconnect"></a>
                                                <a href="/gmail/scan/<?php echo $gmailAccount['id']; ?>" class="fa fa-refresh sweet-confirm-href" title="Scan"></a>
                                            <?php endif; ?>

                                            <?php if ('syncing' !== $gmailAccount['status']): ?>
                                                <a href="/gmail/delete/<?php echo $gmailAccount['id']; ?>" class="fa fa-times sweet-confirm-href" title="Delete"></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="/gmail/pre-oauth/<?php echo $client['id']; ?>">
                                <button class="btn btn-primary">
                                    <i class="fa fa-spin fa-spinner hidden"></i>
                                    Link
                                </button>
                            </a>
                        </div>
                    </div>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->
        </div><!-- /.col-->

    </div><!-- /.row -->

</div><!--/.main-->


<div id="modal-send-survey" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title">
                    <i class="fa fa-envelope-o"></i>
                    Send Survey
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 text-right" style="line-height: 34px;"><strong>Select Meeting:</strong></div>
                    <div class="col-sm-6">
                        <select name="meeting" class="form-control" data-validation="not-empty"></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-send">
                    <i class="fa fa-spin fa-spinner hidden"></i>
                    Send
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>
