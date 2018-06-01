<?php $controller = Sapper\Route::getController(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sapper Suite</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.css" rel="stylesheet">
    <link href="/css/styles.css?<?php echo $GLOBALS['sapper-env']['ASSETS_VERSION']; ?>" rel="stylesheet">
    <link href="/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    <link href="/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/css/toastr.min.css" rel="stylesheet">
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/select2.min.css" rel="stylesheet">
    <link href="/css/app.css?<?php echo $GLOBALS['sapper-env']['ASSETS_VERSION']; ?>" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css">
    <link href="/css/custom-styles.css?<?php echo $GLOBALS['sapper-env']['ASSETS_VERSION']; ?>" rel="stylesheet">

    <!--Icons-->
    <script src="/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="icon" href="/favicon.ico" />
</head>

<body style="padding-top: 50px !important; display: none;" class="<?php echo implode(' ', Sapper\Route::bodyClasses()); ?>">
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><span>Sapper</span>Suite</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo Sapper\Auth::token('firstName'), ' ', Sapper\Auth::token('lastName'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/my-profile"><i class="fa fa-user"></i> My Profile</a></li>
                        <li><a href="/logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar" <?php echo (array_key_exists('sidebar_collapsed', $_SESSION) && true == $_SESSION['sidebar_collapsed']) ? 'style="display: none;"' : ''; ?>>
    <form role="search">
        <div class="form-group"></div>
    </form>
    <ul class="nav menu">

        <?php if (Sapper\User::can('manage-users')):
            $manageUsersOpen = '';
            if (in_array($controller, ['users', 'roles'])) {
                $manageUsersOpen = 'in';
            }
        ?>


        <li class="parent">
            <a>
                <span data-toggle="collapse" href="#manage-users-nav-items"><i class="fa fa-users"></i> Manage Users</span>
            </a>

            <ul class="children collapse <?php echo $manageUsersOpen; ?>" id="manage-users-nav-items">
                <li <?php echo ('add' == $controller) ? 'class="active"' : '';?>>
                    <a href="/users/add"><i class="fa fa-user-plus"></i> Add New</a>
                </li>

                <li <?php echo ('users' == $controller) ? 'class="active"' : '';?>>
                    <a href="/users"><i class="fa fa-users"></i> Users</a>
                </li>

                <li <?php echo ('roles' == $controller) ? 'class="active"' : '';?>>
                    <a href="/roles"><i class="fa fa-address-book-o"></i> Roles</a>
                </li>
            </ul>
        </li>        
        <?php endif; ?>

        <?php if (Sapper\User::can('manage-clients')):
            $clientDirectoryOpen = '';
            if (in_array($controller, ['clients', 'pods'])) {
                $clientDirectoryOpen = 'in';
            }
        ?>
            <li class="parent">
                <a>
                    <span data-toggle="collapse" href="#client-directory-nav-items"><i class="fa fa-sitemap"></i> Client Directory</span>
                </a>

                <ul class="children collapse <?php echo $clientDirectoryOpen; ?>" id="client-directory-nav-items">
                    <li <?php echo ('clients' == $controller) ? 'class="active"' : '';?>>
                        <a href="/clients"><i class="fa fa-sitemap"></i> Client Directory</a>
                    </li>

                    <li <?php echo ('pods' == $controller) ? 'class="active"' : '';?>>
                        <a href="/pods"><i class="fa fa-sitemap"></i> Pods</a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
        
        <?php if (Sapper\User::can('manage-clients')): ?>
        <li <?php echo ('meeting-scoreboard' == $controller) ? 'class="active"' : '';?>>
            <a href="/meeting-scoreboard"><i class="fa fa-table"></i> Meeting Scoreboard</a>
        </li>
        <?php endif; ?>        

        <?php if (Sapper\User::can('search-prospects')):
            $prospectsOpen = '';
            if (in_array($controller, ['prospects-search', 'prospects-board'])) {
                $prospectsOpen = 'in';
            }
            ?>
            <li class="parent">
                <a>
                    <span data-toggle="collapse" href="#prospects-nav-items"><i class="fa fa-address-card-o"></i> Prospects</span>
                </a>

                <ul class="children collapse <?php echo $prospectsOpen; ?>" id="prospects-nav-items">
                    <li <?php echo ('prospects-search' == $controller) ? 'class="active"' : '';?>>
                        <a href="/prospects/search"><i class="fa fa-search"></i> Search</a>
                    </li>

                    <li <?php echo ('prospects-board' == $controller) ? 'class="active"' : '';?>>
                        <a href="/board/view"><i class="fa fa-list-alt"></i> Request Board</a>
                    </li>
                </ul>
            </li>

            <?php 
                $targetOpen = '';
                if (in_array($controller, ['targeting-request', 'targeting-request'])) {
                    $targetOpen = 'in';
                }
            ?>            
            <!--li class="parent">
                <a>
                    <span data-toggle="collapse" href="#targeting-request-nav-items"><i class="fa fa-crosshairs"></i> Targeting Request</span>
                </a>

                <ul class="children collapse <?php echo $targetOpen; ?>" id="targeting-request-nav-items">
                    <li <?php echo ('targeting-request' == $controller) ? 'class="active"' : '';?>>
                        <a href="/targeting-request"><i class="fa fa-plus"></i> Add New</a>
                    </li>

                    <li <?php echo ('targeting-request' == $controller) ? 'class="active"' : '';?>>
                        <a href="/targeting-request/list-requests"><i class="fa fa-list"></i> List</a>
                    </li>

                    <li <?php echo ('targeting-request-board' == $controller) ? 'class="active"' : '';?>>
                        <a href="/targeting-request-board/view"><i class="fa fa-list-alt"></i> Board</a>
                    </li>
                </ul>
            </li-->
        <?php endif; ?>

        <?php
        $listProcessingOpen = '';
        if (in_array($controller, [
                'process', 'downloads', 'process-filtered', 'downloads-filtered', 'filter-titles', 'filter-departments',
                'suppression', 'suppression-list', 'costar-converter'])
        ) {
            $listProcessingOpen = 'in';
        }
        ?>

        <li class="parent">
            <a>
                <span data-toggle="collapse" href="#list-processing-nav-items"><i class="fa fa-arrow-circle-o-right"></i> List Processing</span>
            </a>

            <ul class="children collapse <?php echo $listProcessingOpen; ?>" id="list-processing-nav-items">

                <?php if (Sapper\User::can('normalize-csv-files')): ?>
                <li class="sub-parent">

                    <a>
                        <span data-toggle="collapse" href="#prospect-converter-nav-items"><i class="fa fa-arrow-circle-o-right"></i> Prospect Converter</span>
                    </a>

                    <?php
                    $prospectConverterOpen = '';
                    if (in_array($controller, ['process', 'downloads'])) {
                        $prospectConverterOpen = 'in';
                    }
                    ?>

                    <ul class="children collapse <?php echo $prospectConverterOpen; ?>" id="prospect-converter-nav-items">
                        <li <?php echo ('process' == $controller) ? 'class="active"' : '';?>>
                            <a href="/process">
                                <i class="fa fa-refresh"></i> Prospect Converter
                            </a>
                        </li>

                        <li <?php echo ('downloads' == $controller) ? 'class="active"' : '';?>>
                            <a href="/downloads"><i class="fa fa-download"></i> Past Downloads</a>
                        </li>

                    </ul>
                </li>

                <li class="sub-parent">

                    <a>
                        <span data-toggle="collapse" href="#zoomerang-nav-items"><i class="fa fa-arrow-circle-o-right"></i> Zoomerang</span>
                    </a>

                    <?php
                    $zoomerangOpen = '';
                    if (in_array($controller, ['process-filtered', 'downloads-filtered'])) {
                        $zoomerangOpen = 'in';
                    }
                    ?>

                    <ul class="children collapse <?php echo $zoomerangOpen; ?>" id="zoomerang-nav-items">
                        <li <?php echo ('process-filtered' == $controller) ? 'class="active"' : '';?>>
                            <a href="/process-filtered">
                                <i class="fa fa-refresh"></i> Prospects CSV Filter
                            </a>
                        </li>
                        <li <?php echo ('downloads-filtered' == $controller) ? 'class="active"' : '';?>>
                            <a href="/downloads-filtered"><i class="fa fa-download"></i> Filtered Downloads</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (Sapper\User::can('normalize-costar-files')): ?>
                <li <?php echo ('costar-converter' == $controller) ? 'class="active"' : '';?>>
                    <a href="/costar-converter"><i class="fa fa-refresh"></i> Co-Star Normalizer</a>
                </li>
                <?php endif; ?>

                <li class="parent sub-parent">
                    <a>
                        <span data-toggle="collapse" href="#filter-nav-items"><i class="fa fa-filter"></i> Manage Filters</span>
                    </a>

                    <ul class="children collapse <?php echo (0 === strpos($controller, 'filter')) ? 'in' : ''; ?>" id="filter-nav-items">
                        <li <?php echo ('filter-titles' == $controller) ? 'class="active"' : '';?>>
                            <a href="/filter-titles">
                                <i class="fa fa-list-ul"></i> Titles
                            </a>
                        </li>

                        <li <?php echo ('filter-departments' == $controller) ? 'class="active"' : '';?>>
                            <a href="/filter-departments">
                                <i class="fa fa-list-ul"></i> Departments
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        <li <?php echo ('recommendation' == $controller) ? 'class="active"' : '';?>>
            <a href="/recommendation"><i class="fa fa-file-text-o"></i> Client Profile Recommendation</a>
        </li>

        <li><hr></li>

        <li <?php echo ('background-jobs' == $controller) ? 'class="active"' : '';?>>
            <a href="/background-jobs"><i class="fa fa-binoculars"></i> Background Jobs</a>
        </li>

        <li <?php echo ('settings' == $controller) ? 'class="active"' : '';?>>
            <a href="/settings"><i class="fa fa-cogs"></i> Settings</a>
        </li>

        <?php if (IS_PR_BUILD): ?>
            <li <?php echo ('pr-tools' == $controller) ? 'class="active"' : '';?>>
                <a href="/pr-tools"><i class="fa fa-wrench"></i> PR Tools</a>
            </li>
        <?php endif; ?>
    </ul>

</div><!--/.sidebar-->
