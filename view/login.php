<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sapper Consulting | Login</title>

    <link href="<?php echo APP_ROOT_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo APP_ROOT_URL; ?>/css/styles.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo APP_ROOT_URL; ?>/js/html5shiv.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>/js/respond.min.js"></script>
    <![endif]-->

</head>

<body style="padding-top: 250px !important;">
    <div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading text-center" style="font-size: 23px;">Sapper Suite</div>
                <div class="panel-body">
                    <div class="text-center" style="margin: 20px 0; font-size: 16px;">
                        <p>Please login to continue</p>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="alert bg-danger" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form role="form" method="post" action="/login">
                        <input type="hidden" name="doLogin" value="1" />
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <button class="btn btn-primary">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
</div>
<script src="<?php echo APP_ROOT_URL; ?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo APP_ROOT_URL; ?>/js/bootstrap.min.js"></script>
</body>

</html>
