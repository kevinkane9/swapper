<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Client Profile Recommendation</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div>
        <div class="panel panel-default">
            <div class="panel-heading text-center">Target Profile Request</div>
            <div class="panel-body">
                <div id="backdrop" class="hidden">
                    <i class="fa fa-spin fa-spinner fa-3x"></i>
                </div>
                <form role="form" method="post" action="/recommendation/generate">
                    <div class="row m-b-25">
                        <div class="col-md-6">
                            <h4 class="intro-text current-client">
                                To get your client profile recommendation, start by selecting a client name
                                and filling out one or more attributes.
                            </h4>
                            <h4 class="intro-text not-current-client hidden">
                                To get your client profile recommendation, start by filling out one or more
                                attributes.
                            </h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="hidden" name="current_sapper_client" value="1" />
                            <label>Current Sapper Client?</label>
                            <i class="fa fa-toggle-on icon-toggle"></i>
                        </div>
                    </div><!-- /.row -->

                    <div class="row form-fields">
                        <div class="col-md-6">

                            <?php /** Sapper Client Name */ ?>
                            <div class="row m-b-10 sapper-client-name-container">
                                <div class="col-md-6 text-right">
                                    <label>Sapper Client Name</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="client_id" id="client" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client['id']; ?>">
                                                <?php echo $client['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** State */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>State</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="state" id="state" class="form-control">
                                        <option value=""></option>
                                        <?php foreach (Sapper\Model::get('states') as $code => $state): ?>
                                            <?php
                                            printf(
                                                '<option value="%s">%s</option>',
                                                strtolower($state),
                                                $state
                                            );
                                            ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** City */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>City</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="city" class="form-control" placeholder="Enter your City" name="city" />
                                </div>
                            </div><!-- /.row -->

                            <?php /** Zip Code */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>Zip Code</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="zip" class="form-control" placeholder="Enter your Zip" name="zip" />
                                </div>
                            </div><!-- /.row -->

                        </div>
                        <div class="col-md-6">

                            <?php /** My Approved Industries */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>My Approved Industries</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="approved_industry_ids[]" id="approved-industries"
                                            class="form-control selectpicker" multiple title="All Industries"
                                            data-live-search="true" data-actions-box="true"
                                            data-dropdown-align-right="true">
                                        <?php foreach ($prospectIndustries as $prospectIndustry):

                                            // skip industry if it begins with a #
                                            if (!ctype_alpha(substr($prospectIndustry['name'], 0, 1))) {
                                                continue;
                                            }

                                            printf(
                                                '<option value="%s">%s</option>',
                                                $prospectIndustry['id'],
                                                $prospectIndustry['name']
                                            );
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Approved Titles */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>My Approved Titles</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="approved_title_group_ids[]" id="approved-titles" class="form-control selectpicker" multiple title="All Titles">
                                        <?php foreach ($titleGroups as $titleGroup):
                                            printf(
                                                '<option value="%s">%s</option>',
                                                $titleGroup['id'],
                                                $titleGroup['name']
                                            );
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Number of Employees */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>Number of Employees</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="number_of_employees" id="num-employees" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($employeeRanges as $employeeRange): ?>
                                            <option value="<?php echo $employeeRange['display_name']; ?>">
                                                <?php echo $employeeRange['display_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Company Revenue */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>My Company Revenue</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="company_revenue" id="company-revenue" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($revenueRanges as $revenueRange): ?>
                                            <option value="<?php echo $revenueRange['display_name']; ?>">
                                                <?php echo $revenueRange['display_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Industry */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>My Industry</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="industry" id="industry" class="form-control">
                                        <option value=""></option>
                                        <?php foreach (Sapper\Model::get('industries-linkedin') as $industry): ?>
                                            <option value="<?php echo $industry; ?>"><?php echo $industry; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Founding Year */ ?>
                            <div class="row m-b-10">
                                <div class="col-md-6 text-right">
                                    <label>My Founding Year</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="founding_year" id="founding-year" class="form-control">
                                        <option value=""></option>
                                        <?php for ($i = date('Y'); $i > (date('Y')-200); $i--): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div><!-- /.row -->

                            <?php /** My Approved Titles */ ?>
                            <div class="text-right cta">
                                <a class="btn btn-primary btn-generate">Generate</a>
                                <a class="btn btn-default btn-reset">Reset</a>
                            </div><!-- /.row -->

                        </div>
                    </div><!-- /.row -->
                </form>
            </div>
        </div>
    </div><!-- /.col-->

</div><!--/.main-->
