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

    <div class="row targeting-request-card">
        <div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <a href="/targeting-request/list-requests" title='Back to Requests List' class="btn btn-default btn-sm">Back</a>
                    </div>
                    <h4>Targeting Request</h4>    
                </div>
                <div class="panel-body">
                    <form role="form" action="/targeting-request" method="post">
                        <input type="hidden" name="request_id" value="<?php echo !empty($profile['request_id']) ? $profile['request_id'] : ''; ?>">
                        <!-- Request Title -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Title:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['title']) ? $profile['title'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Client -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Client:&nbsp;&nbsp;&nbsp;</strong> <?php foreach ($clients as $client) {  echo $client_id == $client['id'] ? $client['name'] : ''; } ?>
                            </div>
                        </div>
                        <br>
                        <!-- Industry Keywords -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Industry Keywords:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['industry_keywords']) ? $profile['industry_keywords'] : ''; ?>
                            </div>
                        </div>                        
                        <br>
                        <!-- NAICS -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>NAICS:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['naics']) ? $profile['naics'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Departments -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Industries:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['departments']) ? $profile['departments'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Employee Size -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Employee Size:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['employee_size_from']) ? $profile['employee_size_from'] : ''; ?> - <?php echo !empty($profile['employee_size_to']) ? $profile['employee_size_to'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Revenue -->
                        <?php $revenue = ['$0','$500 k','$1 mil','$5 mil','$10 mil','$25 mil','$50 mil','$100 mil','$250 mil','$500 mil','$1 bil','$5 bil','No Limit']?>
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Revenue:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['revenue_from']) ? $profile['revenue_from'] : ''; ?> - <?php echo !empty($profile['revenue_to']) ? $profile['revenue_to'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Company Atributes -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Company Attributes:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['company_attr_txt']) ? $profile['company_attr_txt'] : ''; ?>
                            </div>                           
                        </div>
                        <br>
                        <!-- Prospect Management Level -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Prospect Management Level:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['prospect_management_level']) ? $profile['prospect_management_level'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Job Titles -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Job Titles:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['titles']) ? $profile['titles'] : ''; ?>
                            </div>
                        </div> 
                        <br>
                        <!-- Job Title Keywords -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Job Title Keywords:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['titles_keywords']) ? $profile['titles_keywords'] : ''; ?>
                            </div>
                        </div> 
                        <br>
                        <!-- City -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>City:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['city']) ? $profile['city'] : ''; ?>
                            </div>
                        </div>   
                        <br>
                        <!-- States -->                     
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>States:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['states']) ? $profile['states'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Country domains -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Countries:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['countries']) ? $profile['countries'] : ''; ?>
                            </div>
                        </div>                        
                        <br>
                        <!-- Geo Target -->
                        <div class="row">
                            <div class="col-md-5 text-left col-md-offset-1">
                                <strong>Geo Target:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['geotarget']) ? $profile['geotarget'] : ''; ?>
                            </div>
                            <div class="col-md-4 column">
                                <strong>Radius:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['radius']) ? $profile['radius'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Link Notes -->
                        <div class="row">
                            <div class="col-md-5 text-left col-md-offset-1">
                                <strong>Link/Notes:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['link_notes']) ? $profile['link_notes'] : ''; ?>
                            </div>
                        </div>
                        <br>
                        <!-- Build To -->
                        <div class="row">
                            <div class="col-md-8 text-left col-md-offset-1">
                                <strong>Build to:&nbsp;&nbsp;&nbsp;</strong> <?php echo !empty($profile['build_to']) ? $profile['build_to'] : ''; ?>
                            </div>
                        </div>                        
                        <br>
                        <!-- Submit -->
                        <div class="row text-center hide">
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