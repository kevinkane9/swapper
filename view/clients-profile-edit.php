<?php $formData  = ($postData  = Sapper\Route::getFlashPostData())  ? $postData  : $profile; ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Client Directory</li>
            <li><a href="/clients/edit/<?php echo $profile['client_id']; ?>"><?php echo $profile['client_name']; ?></a></li>
            <li>Search Profiles</li>
            <li class="active"><?php echo $profile['name']; ?></li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div class="row page-process">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Search Profile Settings</div>
                <div class="panel-body">
                    <form role="form" action="/clients/profile-save/<?php echo $profile['id']; ?>" method="post">

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Name:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <input type="text" class="form-control" name="name" value="<?php echo $formData['name']; ?>" />
                            </div>
                        </div>

                        <!-- Titles -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Titles:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="titles[]" class="selectpicker form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($titles as $group => $titleGroup): ?>
                                        <optgroup label="<?php echo $group; ?>">
                                            <?php foreach ($titleGroup as $titleId => $title):
                                                printf(
                                                    '<option value="%s" %s>%s</option>',
                                                    $titleId, in_array($titleId, $profileTitles) ? 'selected' : '', $title
                                                );
                                            endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"><?php echo count($profileTitles); ?></span>
                            </div>
                        </div>

                        <!-- Departments -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Departments:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="departments[]" class="selectpicker form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($departments as $department):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $department['id'],
                                            in_array($department['id'], $profileDepartments) ? 'selected' : '',
                                            $department['department']
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"><?php echo count($profileDepartments); ?></span>
                            </div>
                        </div>

                        <!-- States -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>States:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="states[]" class="selectpicker form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php $profileStates = json_decode($profile['states']); ?>
                                    <?php foreach (Sapper\Model::get('states') as $code => $state):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $code,
                                            in_array($code, $profileStates) ? 'selected' : null,
                                            $state
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"><?php echo count($profileStates); ?></span>
                            </div>
                        </div>

                        <!-- Country domains -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Country Domains:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="countries[]" class="selectpicker form-control" title="All" data-actions-box="true" data-dropup-auto="false" data-live-search="true" multiple>
                                    <?php $profileCountries = json_decode($profile['countries']); ?>
                                    <?php foreach (Sapper\Model::get('domains') as $extension => $country):
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $extension,
                                            $country,
                                            in_array($extension, $profileCountries) ? 'selected' : '',
                                            $extension
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"><?php echo count($profileCountries); ?></span>
                            </div>
                        </div>

                        <!-- # of prospects -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong># of Prospects:</strong>
                            </div>
                            <div class="col-md-2 text-center">
                                <input type="number" placeholder="All" class="form-control" name="prospects" value="<?php echo $profile['max_prospects']; ?>" min="1" />
                            </div>
                            <div class="col-md-3">
                                <select name="prospectScope" class="form-control">
                                    <option value="total" <?php echo ('total' == $profile['max_prospects_scope']) ? 'selected' : ''; ?>>Total</option>
                                    <option value="perCompany" <?php echo ('per_company' == $profile['max_prospects_scope']) ? 'selected' : ''; ?>>Per Company</option>
                                </select>
                            </div>
                        </div>

                        <!-- Geo Target -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Geo Target:</strong>
                            </div>
                            <div class="col-md-6 text-center">
                                <input type="text" placeholder="Search..." class="form-control" name="geotarget" value="<?php echo $profile['geotarget']; ?>" />
                                <input type="hidden" name="geotarget_lat" value="<?php echo $profile['geotarget_lat']; ?>" />
                                <input type="hidden" name="geotarget_lng" value="<?php echo $profile['geotarget_lng']; ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="number" placeholder="Miles" class="form-control" name="radius" value="<?php echo $profile['radius']; ?>" />
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-spinner fa-spin hidden"></i>
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>