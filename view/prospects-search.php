<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Prospects</li>
        </ol>
    </div><!--/.row-->

    <?php /** Search Prospects */ ?>
    <?php if ('list-request' !== Sapper\Route::uriParam('action')): ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
            <div class="panel panel-default search-form">
                <div class="panel-heading">Search Prospects</div>
                <form class="panel-body" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
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
                        <div class="col-xs-12 col-sm-4">
                            <select name="search_profile_id" class="form-control" <?php echo !array_key_exists('searchProfiles', $formData) ? 'disabled' : ''; ?>>
                                <?php
                                if (array_key_exists('searchProfiles', $formData)) {
                                    echo '<option value=""></option>';

                                    foreach ($formData['searchProfiles'] as $searchProfile) {
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $searchProfile['id'],
                                            $searchProfile['id'] == $formData['search_profile_id'] ? 'selected' : '',
                                            $searchProfile['name']
                                        );
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <select name="source_id" class="form-control">
                                <?php
                                if (array_key_exists('source_selected', $formData)) {
                                    printf(
                                        '<option value="%s">%s</option>',
                                        $formData['source_selected']['id'],
                                        $formData['source_selected']['name']
                                    );
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($formData['email']) ? $formData['email'] : ''; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo isset($formData['first_name']) ? $formData['first_name'] : ''; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo isset($formData['last_name']) ? $formData['last_name'] : ''; ?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <select name="company_id" class="form-control">
                                <?php
                                if (array_key_exists('company_selected', $formData)) {
                                    printf(
                                        '<option value="%s">%s</option>',
                                        $formData['company_selected']['id'],
                                        $formData['company_selected']['name']
                                    );
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <select name="industries[]" class="form-control" multiple="multiple">
                                <?php if (array_key_exists('industries_selected', $formData)): ?>
                                    <?php foreach ($formData['industries_selected'] as $industryId => $industry): ?>
                                        <?php
                                        printf(
                                            '<option value="%s" selected>%s</option>',
                                            $industryId,
                                            $industry
                                        );
                                        ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-4">
                            <select name="titles[]" class="selectpicker form-control" title="Title(s)" data-actions-box="true" data-live-search="true" multiple>
                                <?php foreach ($titles as $group => $titleGroup): ?>
                                    <optgroup label="<?php echo $group; ?>">
                                        <?php foreach ($titleGroup as $titleId => $title): ?>
                                            <?php
                                            printf(
                                                '<option value="%s" %s>%s</option>',
                                                $titleId,
                                                array_key_exists('titles', $formData) &&
                                                in_array($titleId, $formData['titles']) ? 'selected' : '',
                                                $title
                                            );
                                            ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-4">
                            <select name="departments[]" class="selectpicker form-control" title="Department(s)" data-actions-box="true" data-live-search="true" multiple>
                                <?php foreach ($departments as $department): ?>
                                    <?php
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $department['id'],
                                        array_key_exists('departments', $formData) &&
                                        in_array($department['id'], $formData['departments']) ? 'selected' : '',
                                        $department['department']
                                    );
                                    ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4 country-domains-container">
                            <select name="countries[]" class="selectpicker form-control" title="All" data-actions-box="true" data-dropup-auto="false" data-live-search="true" multiple>
                                <?php foreach (Sapper\Model::get('domains') as $extension => $country):

                                    if (array_key_exists('countries', $formData)) {
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $extension,
                                            $country,
                                            in_array($extension, $formData['countries']) ? 'selected' : '',
                                            $extension
                                        );
                                    } else {
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $extension,
                                            $country,
                                            in_array($extension, ['.us', '.io', '.me']) ? 'selected' : '',
                                            $extension
                                        );
                                    }
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" placeholder="Geo Target" class="form-control" name="geotarget" value="<?php echo isset($formData['geotarget']) ? $formData['geotarget'] : ''; ?>" />
                            <input type="hidden" name="geotarget_lat" value="<?php echo isset($formData['geotarget_lat']) ? $formData['geotarget_lat'] : ''; ?>" />
                            <input type="hidden" name="geotarget_lng" value="<?php echo isset($formData['geotarget_lng']) ? $formData['geotarget_lng'] : ''; ?>" />
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <input type="number" placeholder="Miles" class="form-control" name="radius" value="<?php echo isset($formData['radius']) ? $formData['radius'] : ''; ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <select name="states[]" class="selectpicker form-control" title="States" data-actions-box="true" data-live-search="true" multiple>
                                <?php foreach (Sapper\Model::get('states') as $code => $state): ?>
                                    <?php
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $code,
                                        array_key_exists('states', $formData) && in_array($code, $formData['states']) ? 'selected' : '',
                                        $state
                                    );
                                    ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <select name="prospect_scope" class="form-control">
                                <?php
                                foreach ([
                                    'other_accounts' => 'Other Outreach accounts',
                                    'this_account'   => 'This Outreach account',
                                    'all_accounts'   => 'All Outreach accounts'
                                ] as $val => $label) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $val,
                                        array_key_exists('prospect_scope', $formData) && $val == $formData['prospect_scope'] ? 'selected' : '',
                                        $label
                                    );
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                                Search
                            </button>

                            <button type="reset" class="btn btn-default">
                                Reset
                            </button>
                        </div>
                    </div>
                    <?php if (count($bucket) > 0): ?>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a class="btn btn-primary btn-request-new-list">
                                    <i class="fa fa-plus"></i>
                                    Request New List
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div><!-- /.panel -->
        </div><!-- /.col-->
    </div><!-- /.row -->
    <?php endif; ?>

    <?php if (count($bucket) > 0): ?>
        <div class="hidden" data-list-request-title="<?php echo $listRequestTitle; ?>"></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default search-results">
                    <div class="panel-body">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">

                                <?php
                                foreach (array_keys($bucket) as $tabKey) {
                                    printf(
                                        '<li role="presentation" %s><a href="#%s" aria-controls="home" role="tab" data-toggle="tab">%s</a></li>',
                                        'never_contacted' == $tabKey ? 'class="active"' : '',
                                        $tabKey,
                                        ucwords(str_replace(['_','plus'], [' ', '+'], $tabKey)) . ' (' . number_format(count($bucket[$tabKey]), 0) . ')'
                                    );
                                }
                                ?>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <?php foreach (array_keys($bucket) as $tabKey): ?>
                                    <div role="tabpanel" class="tab-pane <?php echo 'never_contacted' == $tabKey ? 'active' : ''; ?>" id="<?php echo $tabKey; ?>">

                                        <div class="row prospect-controls">
                                            <div class="col-sm-2 width-auto p-l-0">
                                                <strong>Prospects Selected: </strong>
                                                <span class="prospects-selected">0</span>
                                            </div>
                                            <div class="col-sm-3">
                                                <a class="btn btn-primary btn-upload-to-outreach">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Upload to Outreach
                                                </a>
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
                                                            <td class="text-center"><input type="checkbox" /></td>
                                                            <td>
                                                                <a href="/prospect/edit/<?php echo $prospect['id']; ?>" target="_blank">
                                                                    <?php echo $prospect['email']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $prospect['first_name']; ?></td>
                                                            <td><?php echo $prospect['last_name']; ?></td>
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
                            </div>

                        </div>

                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col -->
        </div><!-- /.row -->
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

    <div id="create-list-request" class="modal fade" tabindex="-1" role="dialog">
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
                    <div class="row m-t-b-10">
                        <div class="col-sm-12 text-center">
                            <a class="btn btn-primary btn-create-list-request">
                                <i class="fa fa-plus"></i>
                                Create List Request
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div><!-- /.main -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>
