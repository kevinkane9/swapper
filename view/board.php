<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Prospects</li>
        </ol>
    </div><!--/.row-->

    <div class="row">

        <div class="col-sm-12 col-md-4 col-md-offset-2 request-list new-requests" data-type="new">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New List Requests
                    <div class="badge pull-right"><?php echo count($newRequests); ?></div>
                </div>
                <div class="panel-body">

                    <div class="row controls m-b-10">
                        <div class="col-sm-6">
                            <select name="assigned_to" class="form-control">
                                <option value="">Assignee</option>
                                <?php foreach ($assignableUsers as $assignableUser):
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $assignableUser['id'],
                                        isset($_POST['new']['assigned_to']) && $assignableUser['id'] == $_POST['new']['assigned_to'] ? 'selected' : '',
                                        $assignableUser['first_name'] . ' ' . $assignableUser['last_name']
                                    );
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <?php
                                foreach (['new', 'processing', 'error', 'closed', 'fulfilled', 'QA Check', 'awaiting import'] as $status) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $status,
                                        isset($_POST['new']['status']) && $status == $_POST['new']['status'] ? 'selected' : '',
                                        ucwords($status)
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
                                        isset($_POST['new']['client_id']) && $clientId == $_POST['new']['client_id'] ? 'selected' : '',
                                        $clientName
                                    );
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group checkbox">
                                <label for="new-sort-by-due-date">
                                    <input type="checkbox" id="new-sort-by-due-date" value="1" <?php echo (isset($_POST['new']['sort_by_due_date'])) ? 'checked' : ''; ?> />
                                    Sort by due date
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row controls m-b-10">
                        <div class="col-sm-6 col-sm-offset-6">
                            <div class="form-group checkbox">
                                <label for="new-show-archived">
                                    <input type="checkbox" id="new-show-archived" value="1" <?php echo (isset($_POST['new']['show_archived'])) ? 'checked' : ''; ?> />
                                    Show Archived
                                </label>
                            </div>
                        </div>
                    </div>

                    <ul>
                        <?php foreach ($newRequests as $newRequest): ?>
                        <?php $download_filtered_id = !empty($newRequest['download_filtered_id']) ? $newRequest['download_filtered_id'] : ''?>
                        <?php $saved_to_db = !empty($newRequest['saved_to_db']) ? $newRequest['saved_to_db'] : 0?>
                        <li class="request-details" data-status="<?php echo $newRequest['status']; ?>" data-client-id="<?php echo $newRequest['client_id']; ?>" data-list-request-id="<?php echo $newRequest['id']; ?>" data-download-filtered-id='<?php echo $download_filtered_id; ?>' data-saved-to-db="<?php echo $saved_to_db; ?>">
                            <div class="request-header">
                                <h3><?php echo $newRequest['client']; ?> 
                                    <?php if (!empty($download_filtered_id)) { ?>
                                    <i class="fa fa-filter"></i>
                                    <?php } ?>
                                </h3>
                                <h4><?php echo $newRequest['title']; ?></h4>
                                <?php if (!empty($newRequest['description'])): ?>
                                    <p><?php echo $newRequest['description']; ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="request-data hidden">
                                <?php if (array_key_exists('source', $newRequest)): ?>
                                    <span data-label="Source"><?php echo $newRequest['source']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('company', $newRequest)): ?>
                                    <span data-label="Company"><?php echo $newRequest['company']; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('industries', $newRequest)): ?>
                                    <span data-label="Industries"><?php echo implode(', ', $newRequest['industries']); ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('titles', $newRequest)): ?>
                                    <span data-label="Titles"><?php echo implode(', ', $newRequest['titles']); ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('departments', $newRequest)): ?>
                                    <span data-label="Departments"><?php echo implode(', ', $newRequest['departments']); ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('countries', $newRequest)): ?>
                                    <span data-label="Countries"><?php echo implode(', ', $newRequest['countries']); ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('geotarget', $newRequest)): ?>
                                    <span data-label="GeoTarget"><?php echo $newRequest['geotarget'], ' (', $newRequest['radius'], 'mi)'; ?></span>
                                <?php endif; ?>

                                <?php if (array_key_exists('states', $newRequest)): ?>
                                    <span data-label="States"><?php echo implode(', ', $newRequest['states']); ?></span>
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

                            <div class="badges">

                                <?php if (!empty($newRequest['due_date'])): ?>
                                    <div class="badge badge-gray">
                                        <strong>Due Date:</strong> <?php echo date('M j, Y', strtotime($newRequest['due_date'])); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (array_key_exists('created_by_first_name', $newRequest) && !empty($newRequest['created_by_first_name'])): ?>
                                    <div class="badge badge-blue">
                                        <strong>Created By:</strong> <?php echo $newRequest['created_by_first_name'], ' ', $newRequest['created_by_last_name']; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (array_key_exists('assigned_to_first_name', $newRequest) && !empty($newRequest['assigned_to_first_name'])): ?>
                                    <div class="badge badge-green">
                                        <strong>Assigned To:</strong> <?php echo $newRequest['assigned_to_first_name'], ' ', $newRequest['assigned_to_last_name']; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (array_key_exists('closed_by_first_name', $newRequest) && !empty($newRequest['closed_by_first_name'])): ?>
                                    <div class="badge badge-red">
                                        <strong>Closed By:</strong> <?php echo $newRequest['closed_by_first_name'], ' ', $newRequest['closed_by_last_name']; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (array_key_exists('fulfilled_by_first_name', $newRequest) && !empty($newRequest['fulfilled_by_first_name'])): ?>
                                    <div class="badge badge-orange">
                                        <strong>Fulfilled By:</strong> <?php echo $newRequest['fulfilled_by_first_name'], ' ', $newRequest['fulfilled_by_last_name']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="badge badge-purple">
                                    <strong>Status:</strong> <?php echo ucwords($newRequest['status']); ?>
                                </div>
                                <br><br><br>
                                <?php if (!empty($newRequest['uploaded_to_outreach'])) { ?>
                                <div class="badge badge-orange">
                                    <?php echo 'Uploaded to Outreach'; ?>
                                </div>
                                <?php } else if (!empty($newRequest['saved_to_db'])) { ?>
                                <div class="badge badge-orange">
                                    <?php echo 'Imported to Database'; ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="error-details hidden">
                                <?php if ('error' == $newRequest['status'] && !empty($newRequest['error'])):
                                    $errorDetails = json_decode($newRequest['error'], true);
                                    
                                    if (json_last_error() === 0) {
                                        $error_data = $errorDetails[0];
                                    } else {
                                        $error_data = $errorDetails;
                                    }

                                    echo '<strong>Error: </strong>' . $error_data;
                                endif; ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->

        <div class="col-sm-12 col-md-4 request-list recycled-requests" data-type="recycled">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Recycled List Requests
                    <div class="badge pull-right"><?php echo count($recycledRequests); ?></div>
                </div>
                <div class="panel-body">

                    <div class="row controls m-b-10">
                        <div class="col-sm-6">
                            <select name="assigned_to" class="form-control">
                                <option value="">Assignee</option>
                                <?php foreach ($assignableUsers as $assignableUser):
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $assignableUser['id'],
                                        isset($_POST['recycled']['assigned_to']) && $assignableUser['id'] == $_POST['recycled']['assigned_to'] ? 'selected' : '',
                                        $assignableUser['first_name'] . ' ' . $assignableUser['last_name']
                                    );
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <?php
                                foreach (['new', 'processing', 'error', 'closed', 'fulfilled', 'QA Check'] as $status) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $status,
                                        isset($_POST['recycled']['status']) && $status == $_POST['recycled']['status'] ? 'selected' : '',
                                        ucwords($status)
                                    );
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /.controls -->

                    <div class="row controls">
                        <div class="col-sm-6">
                            <select name="client_id" class="form-control">
                                <option value="">Client</option>
                                <?php foreach ($recycledRequestClients as $clientId => $clientName):
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $clientId,
                                        isset($_POST['recycled']['client_id']) && $clientId == $_POST['recycled']['client_id'] ? 'selected' : '',
                                        $clientName
                                    );
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group checkbox">
                                <label for="recycled-sort-by-due-date">
                                    <input type="checkbox" id="recycled-sort-by-due-date" value="1" <?php echo (isset($_POST['recycled']['sort_by_due_date'])) ? 'checked' : ''; ?> />
                                    Sort by due date
                                </label>
                            </div>
                        </div>
                    </div><!-- /.controls -->

                    <div class="row controls m-b-10">
                        <div class="col-sm-6 col-sm-offset-6">
                            <div class="form-group checkbox">
                                <label for="recycled-show-archived">
                                    <input type="checkbox" id="recycled-show-archived" value="1" <?php echo (isset($_POST['recycled']['show_archived'])) ? 'checked' : ''; ?> />
                                    Show Archived
                                </label>
                            </div>
                        </div>
                    </div>

                    <ul>
                        <?php foreach ($recycledRequests as $recycledRequest): ?>
                            <li class="request-details" data-status="<?php echo $recycledRequest['status']; ?>" data-list-request-id="<?php echo $recycledRequest['id']; ?>">
                                <div class="request-header">
                                    <h3><?php echo $recycledRequest['client']; ?></h3>
                                    <h4><?php echo $recycledRequest['title']; ?></h4>
                                    <?php if (!empty($recycledRequest['description'])): ?>
                                        <p><?php echo $recycledRequest['description']; ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if ($recycledRequest['num_prospects'] > 0): ?>
                                    <div class="prospects-container m-t-b-10">
                                        <i class="fa fa-users"></i> Prospects: <?php echo $recycledRequest['num_prospects']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="request-comments hidden">
                                    <?php foreach ($recycledRequest['comments'] as $comment):
                                        printf(
                                            '<span data-comment-by="%s" data-created-at="%s">%s</span>',
                                            $comment['first_name'] . ' ' . $comment['last_name'],
                                            date('M j, Y h:ia', strtotime($comment['created_at'])),
                                            str_replace("\n", '<br>', $comment['comment'])
                                        );
                                    endforeach; ?>
                                </div>

                                <?php if ($recycledRequest['num_comments'] > 0): ?>
                                    <div class="comments-container m-t-b-10">
                                        <i class="fa fa-comment"></i> Comments: <?php echo $recycledRequest['num_comments']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="badges">

                                    <?php if (!empty($recycledRequest['due_date'])): ?>
                                        <div class="badge badge-gray">
                                            <strong>Due Date:</strong> <?php echo date('M j, Y', strtotime($recycledRequest['due_date'])); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (array_key_exists('created_by_first_name', $recycledRequest) && !empty($recycledRequest['created_by_first_name'])): ?>
                                        <div class="badge badge-blue">
                                            <strong>Created By:</strong> <?php echo $recycledRequest['created_by_first_name'], ' ', $recycledRequest['created_by_last_name']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (array_key_exists('assigned_to_first_name', $recycledRequest) && !empty($recycledRequest['assigned_to_first_name'])): ?>
                                        <div class="badge badge-green">
                                            <strong>Assigned To:</strong> <?php echo $recycledRequest['assigned_to_first_name'], ' ', $recycledRequest['assigned_to_last_name']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (array_key_exists('closed_by_first_name', $recycledRequest) && !empty($recycledRequest['closed_by_first_name'])): ?>
                                        <div class="badge badge-red">
                                            <strong>Closed By:</strong> <?php echo $recycledRequest['closed_by_first_name'], ' ', $recycledRequest['closed_by_last_name']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (array_key_exists('fulfilled_by_first_name', $recycledRequest) && !empty($recycledRequest['fulfilled_by_first_name'])): ?>
                                        <div class="badge badge-orange">
                                            <strong>Fulfilled By:</strong> <?php echo $recycledRequest['fulfilled_by_first_name'], ' ', $recycledRequest['fulfilled_by_last_name']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="badge badge-purple">
                                        <strong>Status:</strong> <?php echo ucwords($recycledRequest['status']); ?>
                                    </div>
                                </div>

                                <div class="error-details hidden">
                                    <?php if ('error' == $recycledRequest['status'] && !empty($recycledRequest['error'])):
                                        $errorDetails = json_decode($recycledRequest['error'], true);
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

    <div id="request-card" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

                    <div class="prospects-container m-t-b-10"></div>

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

                    <hr>

                    <div class="row m-t-b-10 fulfill-container import-form">
                        <div class="col-sm-12">
                            <h4 class="board-csv-upload-label">Fulfill Request</h4>
                            <form method="post" action="/board/fulfill" enctype="multipart/form-data">
                                <input type="hidden" name="list_request_id" />
                                <input type="hidden" name="download_filtered_id" />
                                <input type="hidden" name="client_id" />                                
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input type="file" data-validation="not-empty" name="file" class="form-control m-t-b-10"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-upload m-t-b-10">
                                            <i class="fa fa-upload"></i>
                                            Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row m-t-b-10 fulfill-container prospects-view-form">
                        <div class="col-sm-12">
                            <form method="post" action="/board/fulfill-filtered" enctype="multipart/form-data">
                                <input type="hidden" name="list_request_id" />
                                <input type="hidden" name="download_filtered_id" />
                                <input type="hidden" name="client_id" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4 class=""><span class="prospects-count"></span> New Prospects already imported to DB</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-view-imports btn-primary m-t-b-10">
                                            <i class="fa fa-search"></i>
                                            View All Prospects
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    

                    <div class="text-center">
                        <a class="btn btn-default btn-view-prospects" target="_blank">
                            <i class="fa fa-search"></i>
                            View Prospects
                        </a>

                        <a class="btn btn-primary btn-approve sweet-confirm-ajax">
                            <i class="fa fa-check"></i>
                            Approve Request
                        </a>
                    </div>

                    <hr>

                    <div class="row m-t-b-10">
                        <div class="col-sm-6 text-center">
                            <a class="btn btn-default btn-delete sweet-confirm-ajax">
                                <i class="fa fa-minus-circle"></i>
                                Delete
                            </a>
                        </div>
                        <div class="col-sm-6 text-center">
                            <a class="btn btn-default btn-close sweet-confirm-ajax">
                                <i class="fa fa-chevron-circle-down"></i>
                                Close
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div><!-- /.main -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>
