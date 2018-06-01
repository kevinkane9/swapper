<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Targeting Request</li>
            <li>Add New</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div class="row page-process">
        <div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Targeting Request</div>
                <div class="panel-body">
                    <form role="form" action="/targeting-request" method="post">
                        <input type="hidden" name="request_id" value="<?php echo !empty($profile['request_id']) ? $profile['request_id'] : ''; ?>">
                        
                        <!-- Client -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Client:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <select name="client_id" class="selectpicker form-control client_id" title="None" data-live-search="true">
                                    <option value=""></option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?php echo $client['id'];?>" <?php echo $client_id == $client['id'] ? 'selected' : ''; ?>><?php echo $client['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                            <!-- Request Title -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Title:</strong>
                            </div>                        
                            <div class="col-md-7 column">
                                <?php $requestTitle = !empty($listRequestTitle) ? $listRequestTitle : ''; ?>
                                <input type="text" class="form-control" name="title" value="<?php echo !empty($profile['title']) ? $profile['title'] : $requestTitle; ?>" />
                            </div>
                        </div>
                        <hr>
                        <!-- Industry -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Industry:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['departments'] = !empty($profile['departments']) ? explode(',',$profile['departments']) : '';?>
                                <select name="departments[]" class="department-select form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($departments as $department):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $department['department'],
                                            in_array($department['department'], $profile['departments']) ? 'selected' : '',
                                            $department['department']
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Industry Keywords -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Industry Keywords:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['industry_keywords'] = !empty($profile['industry_keywords']) ? explode(',',$profile['industry_keywords']) : '';?>
                                <select name="industry_keywords[]" class="title-select form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($profile['industry_keywords'] as $keyword): ?>
                                            <?php
                                                printf(
                                                    '<option value="%s" selected>%s</option>',
                                                    $keyword, $keyword
                                                );
                                            ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                        
                        <hr>
                        <!-- NAICS -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>NAICS:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <input type="text" class="form-control" name="naics" value="<?php echo !empty($profile['naics']) ? $profile['naics'] : ''; ?>" />
                            </div>
                        </div>
                        <hr>
                        <!-- Employee Size -->
                        <?php $employeeSize = ['1','5','10','20','50','100','250','500','1000','5000','10000','No Limit']?>
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Employee Size:</strong>
                            </div>
                            <div class="col-md-3 column">
                                <select name="employee_size_from" class="select form-control" title="All">
                                    <?php foreach ($employeeSize as $size):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $size,
                                            $size == $profile['employee_size_from'] ? 'selected' : '',
                                            $size
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                    To:
                            </div>
                            <div class="col-md-3 column">
                                <select name="employee_size_to" class="select form-control" title="All">
                                    <?php foreach ($employeeSize as $size):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $size,
                                            $size == $profile['employee_size_to'] ? 'selected' : '',
                                            $size
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Revenue -->
                        <?php $revenue = ['$0','$500 k','$1 mil','$5 mil','$10 mil','$25 mil','$50 mil','$100 mil','$250 mil','$500 mil','$1 bil','$5 bil','No Limit']?>
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Revenue:</strong>
                            </div>
                            <div class="col-md-3 column">
                                <select name="revenue_from" class="select form-control" title="All">
                                    <?php foreach ($revenue as $rev):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $rev,
                                            $rev == $profile['revenue_from'] ? 'selected' : '',
                                            $rev
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                    To:
                            </div>                            
                            <div class="col-md-3 column">
                                <select name="revenue_to" class="select form-control" title="All">
                                    <?php foreach ($revenue as $rev):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $rev,
                                            $rev == $profile['revenue_to'] ? 'selected' : '',
                                            $rev
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Company Atributes -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Company Attributes:</strong>
                            </div>
                            <div class="col-md-3 column">
                                <select name="company_attr" id="company_attr" class="select form-control" title="All">
                                    <?php foreach (['No','Yes'] as $attr):
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $attr,
                                            $attr == $profile['company_attr'] ? 'selected' : '',
                                            $attr
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 column">
                                <input type="text" class="form-control" name="company_attr_txt" id="company_attr_txt" value="<?php echo !empty($profile['company_attr_txt']) ? $profile['company_attr_txt'] : ''; ?>" />
                            </div>                            
                        </div>
                        <hr>
                        <!-- Prospect Management Level -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Prospect Management Level:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['prospect_management_level'] = !empty($profile['prospect_management_level']) ? explode(',',$profile['prospect_management_level']) : '';?>
                                <?php $prospectManagementLevels = ['C-Level','VP-Level','Director','Manager','Non-Manager',]; ?>
                                <select name="prospect_management_level[]" class="selectpicker form-control" title="All" data-actions-box="true" data-dropup-auto="false" data-live-search="true" multiple>
                                    <?php $profileProspectManagementLevels = !empty($profile['prospect_management_level']) ? json_decode($profile['prospect_management_level']) : []; ?>
                                    <?php foreach ($prospectManagementLevels as $levels):
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $levels,
                                            $levels,
                                            in_array($levels, $profile['prospect_management_level']) ? 'selected' : '',
                                            $levels
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Job Titles -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Job Titles:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['titles'] = !empty($profile['titles']) ? explode(',',$profile['titles']) : '';?>
                                <select name="titles[]" class="title-select form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($titles as $group => $titleGroup): ?>
                                            <?php foreach ($titleGroup as $titleId => $title):
                                                printf(
                                                    '<option value="%s" %s>%s</option>',
                                                    $title, in_array($title, $profile['titles']) ? 'selected' : '', $title
                                                );
                                            endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                        <hr>
                        <!-- Job Title Keywords -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Job Title Keywords:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['titles_keywords'] = !empty($profile['titles_keywords']) ? explode(',',$profile['titles_keywords']) : '';?>
                                <select name="titles_keywords[]" class="title-keyword-select form-control" title="All" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach ($profile['titles_keywords'] as $keyword): ?>
                                            <?php
                                                printf(
                                                    '<option value="%s" selected>%s</option>',
                                                    $keyword, $keyword
                                                );
                                            ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                        <hr>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>City:</strong>
                            </div>                        
                            <div class="col-md-4 column">
                                <input type="text" class="form-control" name="city" value="<?php echo !empty($profile['city']) ? $profile['city'] : ''; ?>" />
                            </div>
                        </div>   
                        <hr>
                        <!-- States -->                     
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>States:</strong>
                            </div>                        
                            <div class="col-md-8 column">
                                <?php $profile['states'] = !empty($profile['states']) ? explode(',',$profile['states']) : '';?>
                                <select name="states[]" class="selectpicker form-control" title="States" data-actions-box="true" data-live-search="true" multiple>
                                    <?php foreach (Sapper\Model::get('states') as $code => $state): ?>
                                        <?php
                                        printf(
                                            '<option value="%s" %s>%s</option>',
                                            $state,
                                            in_array($state, $profile['states']) ? 'selected' : '',
                                            $state
                                        );
                                        ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Country domains -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Countries:</strong>
                            </div>
                            <div class="col-md-8 column">
                                <?php $profile['countries'] = !empty($profile['countries']) ? explode(',',$profile['countries']) : '';?>
                                <select name="countries[]" class="selectpicker form-control" title="All" data-actions-box="true" data-dropup-auto="false" data-live-search="true" multiple>
                                    <?php foreach (Sapper\Model::get('domains') as $extension => $country):
                                        printf(
                                            '<option value="%s" data-subtext="%s" %s>%s</option>',
                                            $country,
                                            $country,
                                            in_array($country, $profile['countries']) || $country == 'United States of America'? 'selected' : '',
                                            $country
                                        );
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>                        
                        <hr>
                        <!-- Geo Target -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Geo Target:</strong>
                            </div>
                            <div class="col-md-6 text-center">
                                <input type="text" placeholder="Search..." class="form-control" name="geotarget" value="<?php echo !empty($profile['geotarget']) ? $profile['geotarget'] : ''; ?>" />
                                <input type="hidden" name="geotarget_lat" value="<?php echo !empty($profile['geotarget_lat']) ? $profile['geotarget_lat'] : ''; ?>" />
                                <input type="hidden" name="geotarget_lng" value="<?php echo !empty($profile['geotarget_lng']) ? $profile['geotarget_lng'] : ''; ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="number" placeholder="Miles" class="form-control" name="radius" value="<?php echo !empty($profile['radius']) ? $profile['radius'] : ''; ?>" />
                            </div>
                        </div>
                        <hr>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Link/Notes:</strong>
                            </div>                        
                            <div class="col-md-6 column">
                                <textarea class="form-control" name="link_notes"><?php echo !empty($profile['link_notes']) ? $profile['link_notes'] : ''; ?></textarea>
                            </div>
                        </div> 
                        <hr>
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>Build To:</strong>
                            </div>                        
                            <div class="col-md-4 column">
                                <input type="text" class="form-control" name="build_to" value="<?php echo !empty($profile['build_to']) ? $profile['build_to'] : ''; ?>" />
                            </div>                            
                        </div>                        
                        <hr>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <strong>Also save as profile:</strong>
                            </div>                        
                            <div class="col-md-3 text-left">
                                <input type="checkbox" class="" name="save_profile" value="yes" style="margin-top:10px;">
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
