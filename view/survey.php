<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post Meeting Survey | Sapper Consulting</title>

    <link href="<?php echo APP_ROOT_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo APP_ROOT_URL; ?>/css/styles.css" rel="stylesheet">
    <link href="<?php echo APP_ROOT_URL; ?>/css/app.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo APP_ROOT_URL; ?>/js/html5shiv.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>/js/respond.min.js"></script>
    <![endif]-->

</head>

<body class="view-survey">
    <div class="container">

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading text-center" style="height: 110px;">
                        <h1 style="font-size: 36px; margin: 5px 0;">Sapper Suite</h1>
                        <h2 style="font-size: 26px; margin: 10px 0 0 0;">Post Meeting Survey</h2>
                    </div>
                    <div class="panel-body">

                        <?php switch($state):
                            case 'not_found': ?>
                                <p class="text-center">Invalid link. Please contact us for help.</p>
                                <?php break;
                            case 'completed': ?>
                                <p class="text-center">The survey for this meeting has already been completed.</p>
                                <?php break;
                            case 'submitted': ?>
                                <p class="text-center">Thank you. Your feedback has been submitted.</p>
                                <?php break;
                            case 'new': ?>
                                <form role="form" method="post" action="/survey/<?php echo $eventId; ?>">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Name of Prospect</label>
                                            <?php if (null !== $prospect && false !== $prospect): ?>
                                                <p><?php echo $prospect['first_name'], ' ', $prospect['last_name']; ?></p>
                                                <input type="hidden" name="prospect_name" value="" />
                                            <?php else: ?>
                                                <input class="form-control" name="prospect_name" type="text" autofocus="" data-validation="not-empty">
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group" data-validation="atleast-1-checked">
                                            <label class="data-validation-error-elm">Did the prospect attend the meeting?</label>
                                            <div class="inline-input-groups">
                                                <div class="input-group">
                                                    <input type="radio" name="prospect_attended" value="1" id="prospect_attendedYes">
                                                    <label for="prospect_attendedYes">Yes</label>
                                                </div>
                                                <div class="input-group">
                                                    <input type="radio" name="prospect_attended" value="0" id="prospect_attendedNo">
                                                    <label for="prospect_attendedNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" data-validation="atleast-1-checked">
                                            <label class="data-validation-error-elm">How would you characterize the meeting?</label>
                                            <div class="input-group">
                                                <input type="radio" name="feedback" value="wrong_prospect" id="feedbackWrong_prospect">
                                                <label for="feedbackWrong_prospect">Wrong prospect; No opportunity</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" name="feedback" value="right_prospect_no_opportunity" id="feedbackRight_prospect_no_opportunity">
                                                <label for="feedbackRight_prospect_no_opportunity">Right prospect; No opportunity</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" name="feedback" value="right_prospect_opportunity_in_progress" id="feedbackRight_prospect_opportunity_in_progress">
                                                <label for="feedbackRight_prospect_opportunity_in_progress">Right prospect; Opportunity in progress</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" name="feedback" value="NA" id="feedbackNa">
                                                <label for="feedbackNa">N/A; Prospect did not show</label>
                                            </div>
                                            <div class="input-group">
                                                <input type="radio" name="feedback" value="other" id="feedbackOther">
                                                <label for="feedbackOther">Other: <input type="text" name="feedback_other" /></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Additional comments:</label>
                                            <textarea class="form-control" name="comments"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                                        </div>
                                    </fieldset>
                                </form>
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->

    </div>
<script src="<?php echo APP_ROOT_URL; ?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo APP_ROOT_URL; ?>/js/bootstrap.min.js"></script>
<script src="/js/helpers.js"></script>
<script src="<?php echo APP_ROOT_URL; ?>/js/app.js"></script>
</body>

</html>