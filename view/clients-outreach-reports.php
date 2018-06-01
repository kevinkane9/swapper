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
            <div class="panel panel-default hide">
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
                                        <td><input type="text" class="form-control datepicker-here" name="launch_date" value="<?php echo !empty($clientFormData['sign_on_date']) ? Util::convertDate($clientFormData['launch_date'], 'Y-m-d', 'm/d/Y') : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Expiration Date</th>
                                        <td><input type="text" class="form-control datepicker-here" name="expiration_date" value="<?php echo !empty($clientFormData['sign_on_date']) ? Util::convertDate($clientFormData['expiration_date'], 'Y-m-d', 'm/d/Y') : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Contract Goal</th>
                                        <td><input type="text" class="form-control" name="contract_goal" value="<?php echo $clientFormData['contract_goal']; ?>" /></td>
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
            
            <?php /** Inbox Breakdown */ ?>
            <div class="panel panel-default hide">
                <div class="panel-heading">Inbox Breakdown</div>
                <div class="panel-body">
                   <div id="container" style="width:100%; height:400px;"></div>
                </div>
            </div><!-- /.panel -->

            <?php /** Search Profiles */ ?>
            <div class="panel panel-default hide">
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
        <div class="col-sm-12 col-sm-offset-0 col-md-12">
            <?php
                switch ($clientHSFormData['impression_score']) {
                    case '20':
                        $iScore = '1 (0% - 20%)';
                        break;
                    case '40':
                        $iScore = '2 (21% - 40%)';
                        break;
                    case '60':
                        $iScore = '3 (41% - 60%)';
                        break;
                    case '80':
                        $iScore = '4 (61% - 80%)';
                        break;
                    case '100':
                        $iScore = '5 (81% - 100%)';
                        break;
                    default:
                        $iScore = '';
                        break;
                }
                
                $meetingsThisMonth = 0;
                $meetingsThisMonth += !empty($clientHSFormData['total_meetings']) ? $clientHSFormData['total_meetings'] : 0;
                $meetingsThisMonth += !empty($clientHSFormData['total_meetings_av']) ? $clientHSFormData['total_meetings_av'] : 0;
                
                $mcr = 0.42;
            ?>

            <?php /** Client Stats */ ?>
            <div class="panel panel-default hide">
                <div class="panel-heading">Client Stats</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="outreach-accounts-table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><strong># of Meetings this month</strong></th>
                                        <th class="text-center"><strong>MCR %</strong></th>
                                        <th class="text-center"><strong>Health Score %</strong></th>
                                        <th class="text-center"><strong>Impression Score</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><?php echo $meetingsThisMonth; ?></td>
                                            <td><span class="val-mcr"><?php echo ''; ?></span></td>
                                            <td><?php echo $healthScore; ?>%</td>
                                            <td><?php echo $iScore; ?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">

                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->
            
            <?php /** Outreach Stats */ ?>
            <div class="panel panel-default">
                <div class="panel-heading">Outreach Stats</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered hide" id="outreach-accounts-table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><strong>Avg. Open Rate</strong></th>
                                        <th class="text-center"><strong>Avg. Reply Rate</strong></th>
                                        <th class="text-center"><strong># of Prospects bounced</strong></th>
                                        <th class="text-center"><strong># of Prospects in sequence</strong></th>
                                        <th class="text-center"><strong># of Prospects Cold + Pending</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><span class="val-avg-open-rate"><?php echo "23%"; ?></span></td>
                                            <td><span class="val-avg-replyrate"><?php echo "1.2%"; ?></span></td>
                                            <td><span class="val-no-prospects-bounced"><?php echo "149"; ?></span></td>
                                            <td><span class="val-no-prospects-in-sequence"><?php echo "1,489"; ?></span></td>
                                            <td><span class="val-no-prospects-cold-pending"><?php echo "89"; ?></span></td>
                                        </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="6"><strong>Prospect Overview</strong></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th class="text-center"><strong>Created</strong></th>
                                        <th class="text-center"><strong>Mailed</strong></th>
                                        <th class="text-center"><strong>Opened</strong></th>
                                        <th class="text-center"><strong>Replied</strong></th>
                                        <th class="text-center"><strong>Bounced</strong></th>
                                        <th class="text-center"><strong>Unsubscribed</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><span class=""><?php echo $p_created; ?></span></td>
                                            <td><span class=""><?php echo "$p_mailed"; ?></span></td>
                                            <td><span class=""><?php echo "$p_opened"; ?></span></td>
                                            <td><span class=""><?php echo "$p_replied"; ?></span></td>
                                            <td><span class=""><?php echo "$p_bounced"; ?></span></td>
                                            <td><span class=""><?php echo "$p_unsubscribed"; ?></span></td>
                                        </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="7"><strong>Delivery Overview</strong></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th class="text-center"><strong>Deliveries</strong></th>
                                        <th class="text-center"><strong>One-offs</strong></th>
                                        <th class="text-center"><strong>Sequences</strong></th>
                                        <th class="text-center"><strong>Opens</strong></th>
                                        <th class="text-center"><strong>Replies</strong></th>
                                        <th class="text-center"><strong>Bounces</strong></th>
                                        <th class="text-center"><strong>Unsubscribes</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><span class=""><?php echo $m_deliveries; ?></span></td>
                                            <td><span class=""><?php echo $m_oneoffs; ?></span></td>
                                            <td><span class=""><?php echo "$m_sequences"; ?></span></td>
                                            <td><span class=""><?php echo "$m_opens"; ?></span></td>
                                            <td><span class=""><?php echo "$m_replies"; ?></span></td>
                                            <td><span class=""><?php echo "$m_bounces"; ?></span></td>
                                            <td><span class=""><?php echo "$m_unsubscribes"; ?></span></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-section hide">
                    <div class="text-center">
                        <div class="table-responsive">
                            <form method="post" action="/clients/comment1-add/<?php echo $client['id']; ?>">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width:50%"><strong>Targeting Information</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Submitted by:</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Date/Time</strong></th>
                                        <th class="text-center" style="width:10%"><strong></strong></th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                        <?php if (!empty($comments1)) { ?>
                                            <?php foreach ($comments1 as $comment) { ?> 
                                                <tr>
                                                    <td class="text-left"><?php echo $comment['comment_text']; ?></td>
                                                    <td><?php echo $comment['name']; ?></td>
                                                    <td><?php $date = new DateTime($comment['date_created']); $la_time = new DateTimeZone('CST6CDT'); $date->setTimezone($la_time); echo $date->format('m/d/Y h:i:s A'); ?></td>
                                                    <td class="actions text-center"><a href="/clients/comment-delete/<?php echo $comment['id']; ?>" class="sweet-confirm-href delete fa fa-times" title="Delete Comment"></a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                </tbody>
                                <tfoot>
                                    <td class="text-left"><input type="text" class="form-control" name="comment_text1" required></td>
                                    <td>
                                        <label><?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?></label>
                                        <input type="hidden" class="form-control" name="name1" required value="<?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?>">
                                    </td>
                                    <td>

                                    </td>
                                    <td><input type="submit" class="form-control btn btn-default" name="submit1" value="Add Comment"></td>
                                </tfoot>                                 
                            </table>
                            </form>
                        </div>
                    </div>
                </div><!-- /.panel-section -->
                <div class="panel-section hide">
                    <div class="text-center">
                        <div class="table-responsive">
                            <form method="post" action="/clients/comment2-add/<?php echo $client['id']; ?>">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width:50%"><strong>Contingencies</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Submitted by:</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Date/Time</strong></th>
                                        <th class="text-center" style="width:10%"><strong></strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if (!empty($comments2)) { ?>
                                            <?php foreach ($comments2 as $comment) { ?> 
                                                <tr>
                                                    <td class="text-left"><?php echo $comment['comment_text']; ?></td>
                                                    <td><?php echo $comment['name']; ?></td>
                                                    <td><?php $date = new DateTime($comment['date_created']); $la_time = new DateTimeZone('CST6CDT'); $date->setTimezone($la_time); echo $date->format('m/d/Y h:i:s A'); ?></td>
                                                    <td class="actions text-center"><a href="/clients/comment-delete/<?php echo $comment['id']; ?>" class="sweet-confirm-href delete fa fa-times" title="Delete Comment"></a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                </tbody>
                                <tfoot>
                                    <td class="text-left"><input type="text" class="form-control" name="comment_text2" required></td>

                                    <td>
                                        <label><?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?></label>
                                        <input type="hidden" class="form-control" name="name2" required value="<?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?>">
                                    </td>
                                    <td>

                                    </td>
                                    <td><input type="submit" class="form-control btn btn-default" name="submit2" value="Add Comment"></td>
                                </tfoot>                                        
                            </table>
                                </form>
                        </div>
                    </div>
                </div><!-- /.panel-section -->
                <div class="panel-section hide">
                    <div class="text-center">
                        <div class="table-responsive">
                            <form method="post" action="/clients/comment3-add/<?php echo $client['id']; ?>">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width:50%"><strong>Inbox Impression</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Submitted by:</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Date/Time</strong></th>
                                        <th class="text-center" style="width:10%"><strong></strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if (!empty($comments3)) { ?>
                                            <?php foreach ($comments3 as $comment) { ?> 
                                                <tr>
                                                    <td class="text-left"><?php echo $comment['comment_text']; ?></td>
                                                    <td><?php echo $comment['name']; ?></td>
                                                    <td><?php $date = new DateTime($comment['date_created']); $la_time = new DateTimeZone('CST6CDT'); $date->setTimezone($la_time); echo $date->format('m/d/Y h:i:s A'); ?></td>
                                                    <td class="actions text-center"><a href="/clients/comment-delete/<?php echo $comment['id']; ?>" class="sweet-confirm-href delete fa fa-times" title="Delete Comment"></a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                </tbody>
                                <tfoot>
                                    <td class="text-left">
                                        <input type="text" name="comment_text3" class="form-control" required >
                                    </td>
                                    <td>
                                        <label><?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?></label>
                                        <input type="hidden" class="form-control" name="name3" required value="<?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?>">
                                    </td>
                                    <td>

                                    </td>
                                    <td><input type="submit" class="form-control btn btn-default" name="submit3" value="Add Comment"></td>
                                </tfoot>                                        
                            </table>
                            </form>
                        </div>
                    </div>
                </div><!-- /.panel-section -->
                <div class="panel-section hide">
                    <div class="text-center">
                        <div class="table-responsive">
                            <form method="post" action="/clients/comment4-add/<?php echo $client['id']; ?>">
                            <table class="table table-bordered data-table" id="outreach-accounts-table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width:50%"><strong>Comments</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Submitted by:</strong></th>
                                        <th class="text-center" style="width:20%"><strong>Date/Time</strong></th>
                                        <th class="text-center" style="width:10%"><strong></strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if (!empty($comments4)) { ?>
                                            <?php foreach ($comments4 as $comment) { ?> 
                                                <tr>
                                                    <td class="text-left"><?php echo $comment['comment_text']; ?></td>
                                                    <td><?php echo $comment['name']; ?></td>
                                                    <td><?php $date = new DateTime($comment['date_created']); $la_time = new DateTimeZone('CST6CDT'); $date->setTimezone($la_time); echo $date->format('m/d/Y h:i:s A'); ?></td>
                                                    <td class="actions text-center"><a href="/clients/comment-delete/<?php echo $comment['id']; ?>" class="sweet-confirm-href delete fa fa-times" title="Delete Comment"></a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>                                       
                                </tbody>
                                <tfoot>
                                    <td class="text-left">
                                        <input type="text" name="comment_text4" class="form-control" required >
                                    </td>
                                    <td>
                                        <label><?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?></label>
                                        <input type="hidden" class="form-control" name="name4" required value="<?php echo Sapper\Auth::token('firstName') . " " . Sapper\Auth::token('lastName'); ?>">
                                    </td>
                                    <td>

                                    </td>
                                    <td><input type="submit" class="form-control btn btn-default" name="submit4" value="Add Comment"></td>
                                </tfoot>                                     
                            </table>
                            </form>
                        </div>
                    </div>
                </div><!-- /.panel-section -->
            </div><!-- /.panel -->
            <?php /** Outreach Accounts */ ?>
            <div class="panel panel-default hide">
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
            <div class="panel panel-default hide">
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
                                                <a href="<?php echo $gmailAccount['id']; ?>" class="fa fa-plug sweet-confirm-href" title="Connect" data-sweet-title="Ready?"></a>
                                            <?php endif; ?>

                                            <?php if ('connected' == $gmailAccount['status']): ?>
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
            <?php /** Health Score Calculation */ ?>
            <div class="panel panel-default hide">               
                <div class="panel-heading">Health Score Calculation - <?php echo $healthScore; ?></div>
                <div class="panel-body">
                    <form role="form" method="post" action="/clients/healthscore/<?php echo $client['id']; ?>">
                        <fieldset class="form-group">
                            <legend>Have they closed the deal: </legend>
                            <div class="form-group row">
                                <label for="deal_closed" class="col-sm-3 col-form-label">&nbsp;</label>
                                <label for="deal_closed" class="col-sm-3 col-form-label"><u>Calculated by Script</u></label>
                                <label for="deal_closed" class="col-sm-3 col-form-label"><u>Added Values</u></label>
                                <label for="deal_closed" class="col-sm-3 col-form-label"><u>Total</u></label>
                            </div>
                            <div class="form-group row">
                                <label for="deal_closed" class="col-sm-3 col-form-label">How Many?</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="deal_closed" id="deal_closed" value="<?php echo $clientHSFormData['deal_closed']; ?>" placeholder="How Many" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="deal_closed_av" id="deal_closed_av" value="<?php echo $clientHSFormData['deal_closed_av']; ?>" placeholder="How Many">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="deal_closed_total" id="deal_closed_total" value="<?php echo $clientHSFormData['deal_closed'] + $clientHSFormData['deal_closed_av']; ?>" placeholder="How Many" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weeks_ago" class="col-sm-3 col-form-label">How many weeks ago?</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="weeks_ago" id="weeks_ago" value="<?php echo $clientHSFormData['weeks_ago']; ?>" placeholder="How many weeks ago?" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="weeks_ago_av" id="weeks_ago_av" value="<?php echo $clientHSFormData['weeks_ago_av']; ?>" placeholder="How many weeks ago?">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="weeks_ago_total" id="weeks_ago_total" value="<?php echo $clientHSFormData['weeks_ago'] + $clientHSFormData['weeks_ago_av']; ?>" placeholder="How many weeks ago?" readonly>
                                </div>
                            </div>
                            <legend>Meetings: </legend>
                            <div class="form-group row">
                                <label for="total_meetings" class="col-sm-3 col-form-label">Total Meetings</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="total_meetings" id="total_meetings" value="<?php echo $clientHSFormData['total_meetings']; ?>" placeholder="Total Meetings" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control show-meetings-modal" name="total_meetings_av" id="total_meetings_av" value="<?php echo $clientHSFormData['total_meetings_av']; ?>" placeholder="Total Meetings" title="Click to add monthwise breakdown" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="total_meetings_total" id="total_meetings_total" value="<?php echo $clientHSFormData['total_meetings'] + $clientHSFormData['total_meetings_av']; ?>" placeholder="Total Meetings" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contract_meetings" class="col-sm-3 col-form-label">Contract Meetings</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="contract_meetings" id="contract_meetings" value="<?php echo $clientHSFormData['contract_meetings']; ?>" placeholder="Contract Meetings" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="contract_meetings_av" id="contract_meetings_av" value="<?php echo $clientHSFormData['contract_meetings_av']; ?>" placeholder="Contract Meetings">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="contract_meetings_total" id="contract_meetings_total" value="<?php echo $clientHSFormData['contract_meetings'] + $clientHSFormData['contract_meetings_av']; ?>" placeholder="Contract Meetings" readonly>
                                </div>
                            </div>
                            <legend>Weeks: </legend>
                            <div class="form-group row">
                                <label for="total_weeks" class="col-sm-3 col-form-label">Total Weeks</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="total_weeks" id="total_weeks" value="<?php echo $clientHSFormData['total_weeks']; ?>" placeholder="Total Weeks" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="total_weeks_av" id="total_weeks_av" value="<?php echo $clientHSFormData['total_weeks_av']; ?>" placeholder="Total Weeks">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="total_weeks_total" id="total_weeks_total" value="<?php echo $clientHSFormData['total_weeks'] + $clientHSFormData['total_weeks_av']; ?>" placeholder="Total Weeks" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weeks_last_meeting" class="col-sm-3 col-form-label">Weeks since last meeting</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" name="weeks_last_meeting" id="weeks_last_meeting" value="<?php echo $clientHSFormData['weeks_last_meeting']; ?>" placeholder="Weeks since last meeting" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="weeks_last_meeting_av" id="weeks_last_meeting_av" value="<?php echo $clientHSFormData['weeks_last_meeting_av']; ?>" placeholder="Weeks since last meeting">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="weeks_last_meeting_total" id="weeks_last_meeting_total" value="<?php echo $clientHSFormData['weeks_last_meeting'] + $clientHSFormData['weeks_last_meeting_av']; ?>" placeholder="Weeks since last meeting" readonly>
                                </div>
                            </div>
                            <legend>Survey Feedback: </legend>
                            <div class="form-group row">
                                <label for="opp_in_progress" class="col-sm-3 col-form-label">Opp in Progress</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="opp_in_progress" id="opp_in_progress" value="<?php echo $clientHSFormData['opp_in_progress']; ?>" placeholder="Opp in progress" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="opp_in_progress_av" id="opp_in_progress_av" value="<?php echo $clientHSFormData['opp_in_progress_av']; ?>" placeholder="Opp in progress">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="opp_in_progress_total" id="opp_in_progress_total" value="<?php echo $clientHSFormData['opp_in_progress'] + $clientHSFormData['opp_in_progress_av']; ?>" placeholder="Opp in progress" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="right_prospect_noip" class="col-sm-3 col-form-label">Right Prospect no OiP</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="right_prospect_noip" id="right_prospect_noip" value="<?php echo $clientHSFormData['right_prospect_noip']; ?>" placeholder="" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="right_prospect_noip_av" id="right_prospect_noip_av" value="<?php echo $clientHSFormData['right_prospect_noip_av']; ?>" placeholder="">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="right_prospect_noip_total" id="right_prospect_noip_total" value="<?php echo $clientHSFormData['right_prospect_noip'] + $clientHSFormData['right_prospect_noip_av']; ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wrong_prospect_oip" class="col-sm-3 col-form-label">Wrong Prospect OiP</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect_oip" id="wrong_prospect_oip" value="<?php echo $clientHSFormData['wrong_prospect_oip']; ?>" placeholder="" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect_oip_av" id="wrong_prospect_oip_av" value="<?php echo $clientHSFormData['wrong_prospect_oip_av']; ?>" placeholder="">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect_oip_total" id="wrong_prospect_oip_total" value="<?php echo $clientHSFormData['wrong_prospect_oip'] + $clientHSFormData['wrong_prospect_oip_av']; ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wrong_prospect" class="col-sm-3 col-form-label">Wrong Prospect</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect" id="wrong_prospect" value="<?php echo $clientHSFormData['wrong_prospect']; ?>" placeholder="" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect_av" id="wrong_prospect_av" value="<?php echo $clientHSFormData['wrong_prospect_av']; ?>" placeholder="">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="wrong_prospect_total" id="wrong_prospect_total" value="<?php echo $clientHSFormData['wrong_prospect'] + $clientHSFormData['wrong_prospect_av']; ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_prospect" class="col-sm-3 col-form-label">No Prospect</label>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="no_prospect" id="no_prospect" value="<?php echo $clientHSFormData['no_prospect']; ?>" placeholder="No Prospect" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="no_prospect_av" id="no_prospect_av" value="<?php echo $clientHSFormData['no_prospect_av']; ?>" placeholder="No Prospect">
                                </div>
                                <div class="col-sm-3">
                                  <input type="number" class="form-control" name="no_prospect_total" id="no_prospect_total" value="<?php echo $clientHSFormData['no_prospect'] + $clientHSFormData['no_prospect_av']; ?>" placeholder="No Prospect" readonly>
                                </div>
                            </div>
                            <legend>Impression Scale: </legend>
                            <div class="form-group row">
                                <label for="impression_score" class="col-sm-3 col-form-label">Impression Score %</label>
                                <div class="col-sm-3">
                                    <select name="impression_score" id="impression_score" class="form-control">
                                        <option value="">Select Impression Score</option>
                                        <option value="20" <?php echo ($clientHSFormData['impression_score'] == '20') ? 'selected' : ''; ?>>1 (0% - 20%)</option>
                                        <option value="40" <?php echo ($clientHSFormData['impression_score'] == '40') ? 'selected' : ''; ?>>2 (21% - 40%)</option>
                                        <option value="60" <?php echo ($clientHSFormData['impression_score'] == '60') ? 'selected' : ''; ?>>3 (41% - 60%)</option>
                                        <option value="80" <?php echo ($clientHSFormData['impression_score'] == '80') ? 'selected' : ''; ?>>4 (61% - 80%)</option>
                                        <option value="100" <?php echo ($clientHSFormData['impression_score'] == '100') ? 'selected' : ''; ?>>5 (81% - 100%)</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group right">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <input type="hidden" name="score_id" id="score_id" value="<?php echo !empty($clientHSFormData['score_id']) ? $clientHSFormData['score_id'] : '' ?>">
                          </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.panel -->
        </div><!-- /.col-->
        <div class="col-sm-12 col-sm-offset-0 col-md-12"><!-- /.col-->
            <canvas id="inboxChart" width="400" height="400"></canvas>
        </div><!-- /.col-->

    </div><!-- /.row -->

</div><!--/.main-->

<div id="modal-month-meetings" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                <h4 class="modal-title">Meetings Breakdown</h4>
            </div>
            <div class="modal-body" style="height:450px;">
                <form id="form-month-meetings" role="form" method="post" action="/clients/ajax-month-meetings/<?php echo $client['id']; ?>">
                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">January</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_jan" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_jan']) ? $clientMonthMeetings['meetings_jan'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">February</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_feb" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_feb']) ? $clientMonthMeetings['meetings_feb'] : '0'; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">March</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_mar" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_mar']) ? $clientMonthMeetings['meetings_mar'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">April</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_apr" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_apr']) ? $clientMonthMeetings['meetings_apr'] : '0'; ?>"/>
                        </div>
                    </div>

                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">May</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_may" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_may']) ? $clientMonthMeetings['meetings_may'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">June</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_jun" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_jun']) ? $clientMonthMeetings['meetings_jun'] : '0'; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">July</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_jul" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_jul']) ? $clientMonthMeetings['meetings_jul'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">August</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_aug" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_aug']) ? $clientMonthMeetings['meetings_aug'] : '0'; ?>"/>
                        </div>   
                    </div>
                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">September</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_sep" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_sep']) ? $clientMonthMeetings['meetings_sep'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">October</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_oct" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_oct']) ? $clientMonthMeetings['meetings_oct'] : '0'; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <label class="col-sm-3 col-form-label">November</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_nov" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_nov']) ? $clientMonthMeetings['meetings_nov'] : '0'; ?>"/>
                        </div>

                        <label class="col-sm-3 col-form-label">December</label>
                        <div class="col-sm-3">
                            <input type="text" name="meetings[]" id="meeting_dec" class="form-control" data-validation="not-empty" value="<?php echo !empty($clientMonthMeetings['meetings_dec']) ? $monthMeetings['meetings_dec'] : '0'; ?>"/>
                        </div>
                    </div>  
                    
                    <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>"/>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button name="save" id="save-month-meetings" type="button" class="btn btn-primary">Save</button>
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" name="current_page" class="current-page" value="stats" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>