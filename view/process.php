<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Process CSV File</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-process">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Processing Settings</div>
                <div class="panel-body">
                    <form role="form" action="/process/process" method="post" enctype="multipart/form-data">

                        <!-- Client -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Client:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="client_id" class="selectpicker form-control" title="None" data-live-search="true">
                                    <option value=""></option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?php echo $client['id'];?>"><?php echo $client['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Search Profile -->
                        <div class="row search-profile hidden">
                            <div class="col-md-3 text-right column">
                                <strong>Search Profile:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select class="form-control"></select>
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
                                            <?php foreach ($titleGroup as $titleId => $title): ?>
                                                <option value="<?php echo $titleId;?>"><?php echo $title; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"></span>
                            </div>
                        </div>

                        <!-- Departments -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Departments:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="departments[]" class="selectpicker form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['id'];?>"><?php echo $department['department']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"></span>
                            </div>
                        </div>

                        <!-- States -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>States:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="states[]" class="selectpicker form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach (Sapper\Model::get('states') as $code => $state): ?>
                                        <option value="<?php echo $code;?>"><?php echo $state; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge"></span>
                            </div>
                        </div>

                        <!-- Country domains -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Country Domains:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="countries[]" class="selectpicker form-control" title="All" data-actions-box="true" data-dropup-auto="false" data-live-search="true" multiple>
                                    <?php foreach (Sapper\Model::get('domains') as $extension => $country):
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $extension,
                                            $country,
                                            in_array($extension, ['.us', '.io', '.me', '.tv', '.co']) ? 'selected' : '',
                                            $extension
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 column badge-column">
                                <span class="badge">5</span>
                            </div>
                        </div>

                        <!-- # of prospects -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong># of Prospects:</strong>
                            </div>
                            <div class="col-md-2 text-center">
                                <input type="number" placeholder="All" class="form-control" name="prospects" min="1" />
                            </div>
                            <div class="col-md-3">
                                <select name="prospectScope" class="form-control">
                                    <option value="total">Total</option>
                                    <option value="perCompany">Per Company</option>
                                </select>
                            </div>
                        </div>

                        <!-- Geo Target -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Geo Target:</strong>
                            </div>
                            <div class="col-md-6 text-center">
                                <input type="text" placeholder="Search..." class="form-control" name="geotarget" />
                                <input type="hidden" name="geotarget_lat" />
                                <input type="hidden" name="geotarget_lng" />
                            </div>
                            <div class="col-md-2">
                                <input type="number" placeholder="Miles" class="form-control" name="radius" />
                            </div>
                        </div>

                        <!-- CSV file -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>CSV File:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="file" name="file" class="form-control" data-validation="not-empty" />
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-spinner fa-spin hidden"></i>
                                Process File
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Sapper\Settings::get('google-maps-api-key'); ?>&libraries=places"></script>