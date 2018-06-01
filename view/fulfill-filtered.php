<style>
    .inline-edit {
        background: none !important;
        border: none !important;
    }
</style>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Prospects</li>
        </ol>
    </div><!--/.row-->

    <?php if (count($bucket) > 0): ?>
        <div class="hidden" data-list-request-id="<?php echo $list_request_id; ?>"></div>
        <div class="hidden" data-download-filtered-id="<?php echo $download_filtered_id; ?>"></div>
        
        <form class="panel-body" action="/board/upload-to-outreach" method="post" id="form_prospects_upload">
        <div class="data-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default search-results">
                        <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">

                                    <?php
                                    foreach (array_keys($bucket) as $tabKey) {
                                        printf(
                                            '<li role="presentation" %s><a href="#%s" aria-controls="home" role="tab" data-toggle="tab">%s</a></li>',
                                            'new_prospects' == $tabKey ? 'class="active"' : '',
                                            $tabKey,
                                            ucwords(str_replace(['_','plus'], [' ', '+'], $tabKey)) . ' (' . number_format(count($bucket[$tabKey]), 0) . ')'
                                        );
                                    }
                                    ?>
                                    <li role="presentation"><a href="#combined" aria-controls="home" role="tab" data-toggle="tab">Combined <?php echo number_format(count($bucket_combined), 0); ?></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    
                                    <?php foreach (array_keys($bucket) as $tabKey): ?>
                                        <div role="tabpanel" class="tab-pane <?php echo 'new_prospects' == $tabKey ? 'active' : ''; ?>" id="<?php echo $tabKey; ?>">

                                            <div class="row prospect-controls">
                                                <div class="col-sm-2 width-auto p-l-0">
                                                    <strong>Prospects Selected: </strong>
                                                    <span class="prospects-selected">0</span>
                                                </div>
                                                
                                                <?php //if (empty($list_request['uploaded_to_outreach'])) { ?>
                                                    <div class="col-sm-2">
                                                        <a class="btn btn-primary btn-upload-to-outreach">
                                                            <i class="fa fa-cloud-upload"></i>
                                                            Upload to Outreach
                                                        </a>
                                                        <input type="submit" class="btn-upload-to-outreach-submit" style="height:1px; width: 1px; background:none;border:none;" name="submit_uplod_outreach">
                                                        <input type="hidden" class="hdn-prospects" name="hdn-prospects" value="">
                                                    </div>
                                                <?php //} ?>
                                                <div class="col-sm-2">
                                                    <a id="btn-save-changes" class="btn btn-primary btn-save-changes">
                                                        <i class="fa fa-floppy-o"></i>
                                                        Save Changes to DB
                                                    </a>
                                                </div> 
                                                
                                                <div class="col-sm-2">
                                                    <label class="radio-inline update-message" style="display:none;">
                                                    Modifications Saved</label>
                                                </div>
                                            </div>
                                            
                                            
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th><input type="checkbox" class="selector" /></th>
                                                            <th>Email</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Title</th>
                                                            <th>Company</th>
                                                            <th>Industry</th>
                                                            <th>City</th>
                                                            <th>State</th>
                                                            <th>Zip</th>
                                                            <th>Source</th>
                                                            <th>Last Emailed</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($bucket[$tabKey] as $prospect): ?>
                                                            <tr data-prospect-id="<?php echo $prospect['id']; ?>">
                                                                <td class="text-center"><input name="prospects[]" type="checkbox" value="<?php echo $prospect['id']; ?>"/></td>
                                                                <td>
                                                                    <?php echo $prospect['email']; ?>
                                                                    <?php /*
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a href="/prospect/edit/<?php echo $prospect['id']; ?>" target="_blank">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                     * */?>

                                                                </td>
                                                                <td><input name="prospect[<?php echo $prospect['id']; ?>][first_name]" value="<?php echo $prospect['first_name']; ?>" class="inline-edit <?php echo $prospect['id'] . "first-name"; ?>" data-editable-id="<?php echo $prospect['id'] . "first-name"; ?>"></td>
                                                                <td><input name="prospect[<?php echo $prospect['id']; ?>][last_name]" value="<?php echo $prospect['last_name']; ?>" class="inline-edit <?php echo $prospect['id'] . "last-name"; ?>" data-editable-id="<?php echo $prospect['id'] . "last-name"; ?>"></td>
                                                                <td><?php echo $prospect['title']; ?></td>
                                                                <td><?php echo $prospect['company']; ?></td>
                                                                <td><?php echo $prospect['industry']; ?></td>
                                                                <td><?php echo $prospect['city']; ?></td>
                                                                <td><?php echo $prospect['state']; ?></td>
                                                                <td><?php echo $prospect['zip']; ?></td>
                                                                <td><?php echo $prospect['source']; ?></td>
                                                                <td class="text-nowrap">
                                                                    <?php
                                                                    if (!empty($prospect['last_emailed_at'])) {
                                                                        echo date('M n, \'y', strtotime($prospect['last_emailed_at']));
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <div role="tabpanel" class="tab-pane" id="<?php echo 'combined'; ?>">

                                        <div class="row prospect-controls">
                                            <div class="col-sm-2 width-auto p-l-0">
                                                <strong>Prospects Selected: </strong>
                                                <span class="prospects-selected">0</span>
                                            </div>

                                            <?php //if (empty($list_request['uploaded_to_outreach'])) { ?>
                                                <div class="col-sm-2">
                                                    <a class="btn btn-primary btn-upload-to-outreach">
                                                        <i class="fa fa-cloud-upload"></i>
                                                        Upload to Outreach
                                                    </a>
                                                    <input type="submit" class="btn-upload-to-outreach-submit" style="height:1px; width: 1px; background:none;border:none;" name="submit_uplod_outreach">
                                                </div>
                                            <?php //} ?>

                                            <div class="col-sm-2">
                                                <a id="btn-save-changes" class="btn btn-primary btn-save-changes">
                                                    <i class="fa fa-floppy-o"></i>
                                                    Save Changes to DB
                                                </a>
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <a id="btn-pre-export" style="margin-left:6px;" class="btn btn-primary btn-pre-export">
                                                    <i class="fa fa-share-square-o"></i>
                                                    Export (Combined)
                                                </a>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <label class="radio-inline update-message"  style="display:none;">
                                                Modifications Saved</label>
                                            </div>
                                        </div>


                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="selector" /></th>
                                                        <th>Email</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Title</th>
                                                        <th>Company</th>
                                                        <th>Industry</th>
                                                        <th>City</th>
                                                        <th>State</th>
                                                        <th>Zip</th>
                                                        <th>Source</th>
                                                        <th>Last Emailed</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($bucket_combined as $prospect): ?>
                                                        <tr data-prospect-id="<?php echo $prospect['id']; ?>">
                                                            <td class="text-center"><input name="prospects[]" type="checkbox" value="<?php echo $prospect['id']; ?>"/></td>
                                                            <td>
                                                                <?php echo $prospect['email']; ?>
                                                                <?php /*
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="/prospect/edit/<?php echo $prospect['id']; ?>" target="_blank">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                 * */?>

                                                            </td>
                                                            <td><input name="prospect[<?php echo $prospect['id']; ?>][first_name]" value="<?php echo $prospect['first_name']; ?>" class="inline-edit <?php echo $prospect['id'] . "first-name"; ?>" data-editable-id="<?php echo $prospect['id'] . "first-name"; ?>"></td>
                                                            <td><input name="prospect[<?php echo $prospect['id']; ?>][last_name]" value="<?php echo $prospect['last_name']; ?>" class="inline-edit <?php echo $prospect['id'] . "last-name"; ?>" data-editable-id="<?php echo $prospect['id'] . "last-name"; ?>"></td>
                                                            <td><?php echo $prospect['title']; ?></td>
                                                            <td><?php echo $prospect['company']; ?></td>
                                                            <td><?php echo $prospect['industry']; ?></td>
                                                            <td><?php echo $prospect['city']; ?></td>
                                                            <td><?php echo $prospect['state']; ?></td>
                                                            <td><?php echo $prospect['zip']; ?></td>
                                                            <td><?php echo $prospect['source']; ?></td>
                                                            <td class="text-nowrap">
                                                                <?php
                                                                if (!empty($prospect['last_emailed_at'])) {
                                                                    echo date('M n, \'y', strtotime($prospect['last_emailed_at']));
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>                                    
                                </div>

                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            
            <input name="list_request_id" class="hide" value="<?php echo $list_request_id; ?>">
            <input name="download_filtered_id" class="hide" value="<?php echo $download_filtered_id; ?>">
            <input name="outreach_account_id" class="hide" value="<?php echo $outreach_account_id; ?>">
            <input name="client_id" class="hide" value="<?php echo $client_id; ?>">
            
        </div><!-- /.data-wrapper -->
    </form>
        
    <form class="panel-body" action="/board/export" method="post" id="form_prospects_export">
        <input name="list_request_id" class="hide" value="<?php echo $list_request_id; ?>">
        <input name="download_filtered_id" class="hide" value="<?php echo $download_filtered_id; ?>">
        <input name="outreach_account_id" class="hide" value="<?php echo $outreach_account_id; ?>">
        <input name="client_id" class="hide" value="<?php echo $client_id; ?>">        
        <input type="submit" name="post_export" id="post_export" class="hide" value="export">        
    </form>        
    <?php endif; ?>

    <div id="selector" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Select Rows</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <a class="btn btn-primary btn-select-all">Select All</a>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" class="form-control" data-validation="not-empty" /></div>
                                <div class="col-sm-6"><a class="btn btn-primary btn-select-rows">Select Rows</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div><!-- /.main -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>
