<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Targeting Requests List</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">List Requests</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover compact fixed-cols" id="requests-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Client</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Naics</th>
                                        <th class="text-center">Industries</th>
                                        <th class="text-center">Industry Keywords</th>
                                        <th class="text-center">Employee Size From</th>
                                        <th class="text-center">Employee Size To</th>
                                        <th class="text-center">Revenue From</th>
                                        <th class="text-center">Revenue To</th>
                                        <th class="text-center">Company Attributes</th>
                                        <th class="text-center">Prospect management level</th>
                                        <th class="text-center">Titles</th>
                                        <th class="text-center">Titles keywords</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">States</th>
                                        <th class="text-center">Countries</th>
                                        <th class="text-center">Geotarget</th>
                                        <th class="text-center">Geotarget Lat</th>
                                        <th class="text-center">Geotarget Lng</th>
                                        <th class="text-center">Radius</th>
                                        <th class="text-center">Link notes</th>
                                        <th class="text-center">Created by</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $request) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $request['created_at']; ?></td>
                                            <td class="text-center"><?php echo $request['name']; ?></td>
                                            <td class="text-center"><?php echo $request['title']; ?></td>
                                            <td class="text-center"><?php echo $request['naics']; ?></td>
                                            <td class="text-center"><?php echo $request['departments']; ?></td>
                                            <td class="text-center"><?php echo $request['industry_keywords']; ?></td>
                                            <td class="text-center"><?php echo $request['employee_size_from']; ?></td>
                                            <td class="text-center"><?php echo $request['employee_size_to']; ?></td>
                                            <td class="text-center"><?php echo $request['revenue_from']; ?></td>
                                            <td class="text-center"><?php echo $request['revenue_to']; ?></td>
                                            <td class="text-center"><?php echo $request['company_attr_txt']; ?></td>
                                            <td class="text-center"><?php echo $request['prospect_management_level']; ?></td>
                                            <td class="text-center"><?php echo $request['titles']; ?></td>
                                            <td class="text-center"><?php echo $request['titles_keywords']; ?></td>
                                            <td class="text-center"><?php echo $request['city']; ?></td>
                                            <td class="text-center"><?php echo $request['states']; ?></td>
                                            <td class="text-center"><?php echo $request['countries']; ?></td>
                                            <td class="text-center"><?php echo $request['geotarget']; ?></td>
                                            <td class="text-center"><?php echo $request['geotarget_lat']; ?></td>
                                            <td class="text-center"><?php echo $request['geotarget_lng']; ?></td>
                                            <td class="text-center"><?php echo $request['radius']; ?></td>
                                            <td class="text-center"><?php echo $request['link_notes']; ?></td>
                                            <td class="text-center"><?php echo $request['user_name']; ?></td>
                                            <td class="text-center">
                                                <a href="/targeting-request/edit/<?php echo $request['request_id']; ?>"  class="fa fa-pencil" title="View/Edit"></a>
                                            </td>
                                        </tr>                                    
                                    <?php } ?>
                                </tbody>
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
										if (!empty($formData)) {
											printf(
												'<option value="%s" %s>%s</option>',
												$account['id'],
												array_key_exists('outreach_account_id', $formData) &&
												$account['id'] == $formData['outreach_account_id'] ? 'selected' : '',
												$account['email']
											);
										}
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