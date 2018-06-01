<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Past Downloads</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-downloads">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Past Downloads</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover compact" id="downloads-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Filename</th>
                                        <th class="text-center">Total Rows</th>
                                        <th class="text-center">Filtered Rows</th>
                                        <th class="text-center">Purged Rows</th>
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

<div class="modal fade" role="dialog" id="upload">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload to Outreach</h4>
            </div>
            <div class="modal-body">
                <div class="step-1">
                    <div>
                        <select name="outreach_account_id" class="form-control" data-validation="not-empty">
                            <option value=""></option>
                            <?php foreach ($companyAccounts as $company => $accounts): ?>
                                <optgroup label="<?php echo $company; ?>">
                                    <?php foreach ($accounts as $account): ?>
                                        <?php
											printf(
												'<option value="%s" %s>%s</option>',
												$account['id'],
												array_key_exists('outreach_account_id', $formData) &&
												$account['id'] == $formData['outreach_account_id'] ? 'selected' : '',
												$account['email']
											);
                                        ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <input type="text" class="form-control" name="tag" placeholder="Tag" data-validation="not-empty" />
                    </div>
                </div>
                <div class="step-2">
                    <p>Success! The upload will begin shortly...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-spin fa-spinner hidden"></i>
                    Upload
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->