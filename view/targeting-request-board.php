<?php
    use Sapper\Util;
?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Targeting Request Board</li>
        </ol>
    </div><!--/.row-->

    <div class="row">

        <div class="col-sm-12 col-md-4 col-md-offset-2 request-list new-requests" data-type="new">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Targeting Requests
                    <div class="badge pull-right"><?php echo count($requests); ?></div>
                </div>
                <div class="panel-body">

                    <div class="row controls m-b-10">
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <option value="">Status</option>
                                <?php
                                foreach (['Upcoming', 'Incomplete', 'Due Next Day', 'In Progress', 'Complete'] as $select_status) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $select_status,
                                        isset($status) && $select_status == $status ? 'selected' : '',
                                        ucwords($select_status)
                                    );
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row controls">
                        <div class="col-sm-6">
                            <select name="client_id" class="form-control">
                                <option value="">Client</option>
                                <?php foreach ($newRequestClients as $clientId => $clientName):
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $clientId,
                                        isset($client_id) && $clientId == $client_id ? 'selected' : '',
                                        $clientName
                                    );
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group checkbox">
                                <label for="new-sort-by-created-date">
                                    <input type="checkbox" id="sort-by-created-date" value="1" <?php echo (!empty($sort_by_created_date)) ? 'checked' : ''; ?> />
                                    Sort by created date
                                </label>
                            </div>
                        </div>
                    </div>

                    <ul>
                        <?php foreach ($requests as $newRequest): ?>
                        <li class="request-details" data-status="<?php echo $newRequest['status']; ?>" data-client-id="<?php echo $newRequest['client_id']; ?>" data-list-request-id="<?php echo $newRequest['request_id']; ?>">
                            <div class="request-header">
                                <h3><?php echo $newRequest['client_name']; ?></h3>
                                <h4><?php echo $newRequest['title']; ?></h4>
                            </div>                        

                            <div class="badges">

                                <?php if (!empty($newRequest['created_at'])): ?>
                                    <div class="badge badge-gray">
                                        <strong>Created Date:</strong> <?php echo date('M j, Y', strtotime($newRequest['created_at'])); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (array_key_exists('user_name', $newRequest) && !empty($newRequest['user_name'])): ?>
                                    <div class="badge badge-blue">
                                        <strong>Created By:</strong> <?php echo $newRequest['user_name']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="badge badge-purple">
                                    <strong>Status:</strong> <?php echo ucwords($newRequest['status']); ?>
                                </div>
                            </div>

                            <div class="request-data hidden">
                                <?php if (array_key_exists('company_attr_txt', $newRequest)): ?>
                                    <span data-label="Company Attributes"><?php echo $newRequest['company_attr_txt']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('departments', $newRequest)): ?>
                                    <span data-label="Industries"><?php echo $newRequest['departments']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('industry_keywords', $newRequest)): ?>
                                    <span data-label="Industry Keywords"><?php echo $newRequest['industry_keywords']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('employee_size_from', $newRequest) || array_key_exists('employee_size_to', $newRequest)): ?>
                                    <span data-label="Employee Size">
                                        <?php echo Util::get($newRequest, 'employee_size_from'); ?> - <?php echo Util::get($newRequest, 'employee_size_to'); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (array_key_exists('revenue_from', $newRequest) || array_key_exists('revenue_to', $newRequest)): ?>
                                    <span data-label="Revenue">
                                        <?php echo Util::get($newRequest, 'revenue_from'); ?> - <?php echo Util::get($newRequest, 'revenue_to'); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (array_key_exists('naics', $newRequest)): ?>
                                    <span data-label="NAICS"><?php echo $newRequest['naics']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('prospect_management_level', $newRequest)): ?>
                                    <span data-label="Prospect Management Level"><?php echo $newRequest['prospect_management_level']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('titles', $newRequest)): ?>
                                    <span data-label="Job Titles"><?php echo $newRequest['titles']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('titles_keywords', $newRequest)): ?>
                                    <span data-label="Job Titles Keywords"><?php echo $newRequest['titles_keywords']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('city', $newRequest)): ?>
                                    <span data-label="City"><?php echo $newRequest['city']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('states', $newRequest)): ?>
                                    <span data-label="States"><?php echo $newRequest['states']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('countries', $newRequest)): ?>
                                    <span data-label="Countries"><?php echo $newRequest['countries']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('geotarget', $newRequest)): ?>
                                    <span data-label="GeoTarget"><?php echo $newRequest['geotarget'], ' (', $newRequest['radius'], ' mi)'; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('link_notes', $newRequest)): ?>
                                    <span data-label="Link/Notes"><?php echo $newRequest['link_notes']; ?></span>
                                <?php endif; ?>
                                <?php if (array_key_exists('build_to', $newRequest)): ?>
                                    <span data-label="Build to"><?php echo $newRequest['build_to']; ?></span>
                                <?php endif; ?>

                            </div>

                            <div class="request-comments hidden">
                                <?php foreach ($newRequest['comments'] as $comment):
                                    printf(
                                        '<span data-comment-by="%s" data-created-at="%s">%s</span>',
                                        $comment['first_name'] . ' ' . $comment['last_name'],
                                        date('M j, Y h:ia', strtotime($comment['created_at'])),
                                        str_replace("\n", '<br>', $comment['comment'])
                                    );
                                endforeach; ?>
                            </div>

                            <?php if ($newRequest['num_comments'] > 0): ?>
                                <div class="comments-container m-t-b-10">
                                    <i class="fa fa-comment"></i> Comments: <?php echo $newRequest['num_comments']; ?>
                                </div>
                            <?php endif; ?>                            

                            <div class="error-details hidden">
                                <?php if ('error' == $newRequest['status'] && !empty($newRequest['error'])):
                                    $errorDetails = json_decode($newRequest['error'], true);
                                    echo '<strong>Error: </strong>' . $errorDetails[0];
                                endif; ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div id="request-card" class="modal fade targeting-request-card" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" data-list-request-id="<?php echo $newRequest['request_id']; ?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Request Details</h4>
                </div>
                <div class="modal-body request-details">
                    <div class="row">
                        <div class="col-sm-8 request-header">
                            <h3></h3>
                            <h4></h4>
                            <p></p>
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="badges"></div>
                        </div>

                    </div>

                    <div class="row request-data"></div>

                    <div class="error-details m-t-b-10"></div>
                    <hr>

                    <div class="row m-t-b-10 request-comments"></div>

                    <div class="row m-t-b-10">
                        <div class="col-sm-12">
                            <h4>Leave a Comment</h4>
                            <textarea class="form-control m-t-b-10" data-validation="not-empty"></textarea>
                            <a class="btn btn-primary btn-submit-comment m-t-b-10">
                                <i class="fa fa-comment"></i>
                                Submit
                            </a>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <div class="row m-t-b-10">
                        <div class="col-sm-3 text-center">
                            <select name="status" class="form-control status-select">
                                <?php
                                foreach (['Upcoming', 'Incomplete', 'Due Next Day', 'In Progress', 'Complete'] as $status) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $status,
                                        '',
                                        ucwords($status)
                                    );
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 text-center">
                            <a class="btn btn-default btn-delete sweet-confirm-ajax">
                                <i class="fa fa-minus-circle"></i>
                                Delete
                            </a>
                        </div>
                    </div>                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div><!-- /.main -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>
