<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Filtered Downloads</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-downloads">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Filtered Downloads</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover compact" id="downloads-filtered-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Filename</th>
                                        <th class="text-center">Total Rows</th>
                                        <th class="text-center">Not In DB</th>
                                        <th class="text-center">In DB & Not In Outreach</th>
                                        <?php /* ?>
                                        <th class="text-center">In DB & In Outreach</th>
                                        <?php */ ?>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->

<div id="create-list-request-filtered" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New List Request</h4>
            </div>
            <div class="modal-body">
                <div class="row m-t-b-10">
                    <div class="col-sm-4 text-right">
                        <strong>Title:</strong>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" data-validation="not-empty" name="title" />
                    </div>
                </div>
                <div class="row m-t-b-10">
                    <div class="col-sm-4 text-right">
                        <strong>Due Date:</strong>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control datepicker-future-only" name="due_date" />
                    </div>
                </div>
                <div class="row m-t-b-10">
                    <div class="col-sm-4 text-right">
                        <strong>Assigned To:</strong>
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control" name="assigned_to">
                            <option value=""></option>
                            <?php foreach($assignableUsers as $assignableUser):
                                printf(
                                    '<option value="%s">%s</option>',
                                    $assignableUser['id'],
                                    $assignableUser['first_name'] . ' ' . $assignableUser['last_name']
                                );
                            endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row m-t-b-10">
                    <div class="col-sm-4 text-right">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-sm-8">
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="type-of-request-wrapper hide">
                    <div class="row m-t-b-10">
                        <div class="col-sm-4 text-right">
                            <strong>Type of Request:</strong>
                        </div>
                        <div class="col-sm-8">
                            <label class="radio-inline" style="margin-top: 10px;">
                                <input type="radio" name="type_of_request" value="other" checked> Other
                            </label>
                            <label class="radio-inline" style="margin-top: 10px;">
                                <input type="radio" name="type_of_request" value="zoominfo"> Zoominfo
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row m-t-b-10">
                    <div class="col-sm-12 text-center">
                        <a class="btn btn-primary btn-create-list-request-filtered">
                            <i class="fa fa-plus"></i>
                            Create List Request
                        </a>
                    </div>
                    <input type="hidden" name="outreach_account_id" value="" />
                    <input type="hidden" name="download_filtered_id" value="" />
                    <input type="hidden" name="search_criteria" value="" />
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
