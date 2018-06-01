<?php

namespace Sapper;

class Route {

    private static $instance;
    private $controller, $uriParams, $bodyClasses, $flashMessage;
    static $routes =  [

        // general
        'login'          => 'login',
        'logout'         => 'logout',
        'home'           => 'home',
        'home/(sidebar)' => ['home', ['action']],
        'privacy-policy' => 'privacy-policy',
        'survey/(.*)'    => ['survey', ['event_id']],

        'my-profile' => 'my-profile',

        // manage users
        'users'                => 'users',
        'users/(add)'       => ['users', ['action']],
        'users/(create)'       => ['users', ['action']],
        'users/(edit)/(\d*)'   => ['users', ['action', 'id']],
        'users/(delete)/(\d*)' => ['users', ['action', 'id']],
        'users/(get-role)'     => ['users', ['action']],

        'roles'                => 'roles',
        'roles/(create)'       => ['roles', ['action']],
        'roles/(edit)/(\d*)'   => ['roles', ['action', 'id']],
        'roles/(delete)/(\d*)' => ['roles', ['action', 'id']],

        // client directory
        'clients'                    => 'clients',
        'clients/(create)'           => ['clients', ['action']],
        'clients/(healthscore)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(hsedit)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(csm)/(\d*)'           => ['clients', ['action', 'id']],
        'clients/(strategistadd)'       => ['clients', ['action']],
        'clients/(strategistedit)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(strategistdelete)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(ajax-get-healthscore)'       => ['clients', ['action']],        
        'clients/(ajax-update-month-meetings)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-mcr)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-avg-openrate)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-avg-replyrate)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-no-prospects-bounced)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-no-prospects-in-sequence)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-no-prospects-cold-pending)'       => ['clients', ['action']],
        'clients/(ajax-stats-get-inbox-counts)'       => ['clients', ['action']],
        'clients/(ajax-set-session-data)'       => ['clients', ['action']],
        'clients/(edit)/(\d*)'       => ['clients', ['action', 'id']],

        'clients/(ajax-get-eligible-survey-events)/(\d*)' => ['clients', ['action', 'client_id']],
        'clients/(ajax-send-survey-invitation)' => ['clients', ['action']],

        'clients/(stats)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(outreach-reports)/(\d*)'       => ['clients', ['action', 'id']],
        'clients/(delete)/(\d*)'     => ['clients', ['action', 'id']],

        'clients/(profile-create)/(\d*)' => ['clients', ['action', 'client_id']],
        'clients/(profile-delete)/(\d*)' => ['clients', ['action', 'profile_id']],
        'clients/(profile-edit)/(\d*)'   => ['clients', ['action', 'profile_id']],
        'clients/(profile-save)/(\d*)'   => ['clients', ['action', 'profile_id']],

        'clients/(dne)/(\d*)'        => ['clients', ['action', 'id']],
        'clients/(dne-get-data)'     => ['clients', ['action']],
        'clients/(dne-edit)'         => ['clients', ['action']],
        'clients/(dne-delete)'       => ['clients', ['action']],
        'clients/(dne-add)'          => ['clients', ['action']],
        'clients/(dne-upload)'       => ['clients', ['action']],
        'clients/(dne-export)/(\d*)' => ['clients', ['action', 'id']],
        
        'clients/(mapping)'      => ['clients', ['action']],
        'clients/(mappingupdate)'      => ['clients', ['action']],
        'clients/(mappingupdateinline)'      => ['clients', ['action']],
        'clients/(mappingdelete)/(\d*)' => ['clients', ['action', 'id']],
        'clients/(strategist)'       => ['clients', ['action']],
        'clients/(pod)' => ['clients', ['action']],
        
        // meeting scoreboard
        'meeting-scoreboard' => 'meeting-scoreboard',
        'meeting-scoreboard/(meetings-calendar)/(\d*)' => ['meeting-scoreboard',['action', 'id']],
        'meeting-scoreboard/(meetings-calendar)\?month=(\d*)&year=(\d*)$' => ['meeting-scoreboard',['action', 'month', 'year']],
        'meeting-scoreboard/(meetings-calendar-data)' => ['meeting-scoreboard',['action']],
        'meeting-scoreboard/(meetings-calendar-sapper)\?month=(\d*)&year=(\d*)$' => ['meeting-scoreboard',['action', 'month', 'year']],
        'meeting-scoreboard/(meetings-calendar-data-sapper)' => ['meeting-scoreboard',['action']],
        
        // outreach
        'outreach/(link-account)/(\d*)'             => ['outreach', ['action', 'client_id']],
        'outreach/(pre-oauth)/(\d*)'                => ['outreach', ['action', 'accountId']],
        'outreach/(oauth)\?code=(.*)&state=(\d*)$'  => ['outreach', ['action', 'code', 'account_id']],
        'outreach/(delete)/(\d*)'                   => ['outreach', ['action', 'accountId']],
        'outreach/(sync)/(\d*)'                     => ['outreach', ['action', 'accountId']],

        // gmail
        'gmail/(pre-oauth)/(\d*)'                   => ['gmail', ['action', 'client_id']],
        'gmail/(re-auth)/(\d*)'                     => ['gmail', ['action', 'account_id']],
        'gmail/(oauth)\?state=(.*)&code=(.*)'       => ['gmail', ['action', 'state', 'code']],
        'gmail/(scan)/(\d*)'                        => ['gmail', ['action', 'accountId']],
        'gmail/(delete)/(\d*)'                      => ['gmail', ['action', 'accountId']],
        'gmail/(disconnect)/(\d*)'                  => ['gmail', ['action', 'accountId']],
        'gmail/(update-survey-email)/(\d*)'         => ['gmail', ['action', 'accountId']],
        'gmail/(update-survey-results-email)/(\d*)' => ['gmail', ['action', 'accountId']],

        'pods'                => 'pods',
        'pods/(add)'          => ['pods', ['action']],
        'pods/(edit)/(\d*)'   => ['pods', ['action', 'id']],
        'pods/(delete)/(\d*)'   => ['pods', ['action', 'id']],

        // prospects
        'prospect/(find-tag)'   => ['prospect', ['action']],
        'prospect/(find-stage)' => ['prospect', ['action']],
        'prospect/(\D*)/(\d*)'  => ['prospect', ['action', 'prospectId']],

        'prospects/search'      => 'prospects-search',
        'prospects/search/(.*)' => ['prospects-search', ['action']],
        'prospects/search/(list-request)/(.*)' => ['prospects-search', ['action', 'id']],

        // targeting request
        'targeting-request' => 'targeting-request',
        'targeting-request-board/(.*)'     => ['targeting-request-board', ['action']],
        'targeting-request/(.*)'     => ['targeting-request', ['action']],
        'targeting-request/(edit)/(\d*)'   => ['targeting-request', ['action', 'id']],

        // zoominfo
        'zoominfo/(search)/(.*)' => ['zoominfo', ['action']],
        'zoominfo/(insert)/' => ['zoominfo', ['action']],

        'list-request/(.*)'     => ['list-request', ['action']],

        // request board
        'board/(.*)'   => ['board', ['action']],

        // list processing
        'process'      => 'process',
        'process/(.*)' => ['process', ['action']],
        
        // list processing filtered
        'process-filtered'      => 'process-filtered',
        'process-filtered/(.*)' => ['process-filtered', ['action']],        

        // downloads
        'downloads'                       => 'downloads',
        'downloads/(get-data)'            => ['downloads', ['action']],
        'downloads/(save)/(\d*)'          => ['downloads', ['action', 'id']],
        'downloads/(upload-to-outreach)'  => ['downloads', ['action']],
        'downloads/(\d*)'                 => ['downloads', ['id']],
        'downloads/(delete)/(\d*)'        => ['downloads', ['action', 'id']],
        'downloads/(download)/(.*)/(\d*)' => ['downloads', ['action', 'type', 'id']],
        
        // downloads-filtered
        'downloads-filtered'                       => 'downloads-filtered',
        'downloads-filtered/(get-data)'            => ['downloads-filtered', ['action']],
        'downloads-filtered/(save)/(\d*)'          => ['downloads-filtered', ['action', 'id']],
        'downloads-filtered/(upload-to-outreach)'  => ['downloads-filtered', ['action']],
        'downloads-filtered/(\d*)'                 => ['downloads-filtered', ['id']],
        'downloads-filtered/(delete)/(\d*)'        => ['downloads-filtered', ['action', 'id']],
        'downloads-filtered/(download)/(.*)/(\d*)' => ['downloads-filtered', ['action', 'type', 'id']],

        // filters
        'filter-departments'      => 'filter-departments',
        'filter-departments/(.*)' => ['filter-departments', ['method']],

        'filter-titles'      => 'filter-titles',
        'filter-titles/(.*)' => ['filter-titles', ['method']],

        // co-star converter
        'costar-converter' => 'costar-converter',

        // client profile recommendation
        'recommendation'                         => 'recommendation',
        'recommendation/(get-client-attributes)' => ['recommendation', ['action']],
        'recommendation/(generate)'              => ['recommendation', ['action']],
        'recommendation/(check-sufficient-data)' => ['recommendation', ['action']],

        // background-jobs
        'background-jobs' => 'background-jobs',
        'background-jobs/(kill)/(\d*)'       => ['background-jobs', ['action', 'id']],

        // settings
        'settings'  => 'settings',

        // PR Tools
        'pr-tools'                            => 'pr-tools',
        'pr-tools/(send-survey-invitations)'  => ['pr-tools', ['action']],
        'pr-tools/(process-job-queue)'        => ['pr-tools', ['action']],
    ];

    /**
     * Route constructor.
     */
    public function __construct(){
        session_start();

        if (array_key_exists('sapper-flash', $_SESSION)) {
            $this->flashMessage = $_SESSION['sapper-flash'];
        } else {
            $this->flashMessage = false;
        }

        $this->bodyClasses = ['controller-home'];
        $this->controller  = 'home';
        $uriParams         = [];

        foreach (self::$routes as $route => $controller) {
            $pattern    = '/^\/' . str_replace("/", "\\/", $route) . '$/';

            if(1 == preg_match($pattern, rtrim($_SERVER['REQUEST_URI'], '/'), $uriParams)) {

                array_shift($uriParams);

                if (is_array($controller)) {
                    $this->controller = $controller[0];
                    $params = [];
                    foreach ($controller[1] as $i => $param) {
                        $params[$param] = $uriParams[$i];
                    }
                    $this->uriParams  = $params;
                } else {
                    $this->controller = $controller;
                    $this->uriParams  = $uriParams;

                }

                $this->bodyClasses = ['controller-' . $this->controller];
            }
        }
    }

    public static function run() {
        $instance = self::getInstance();
        $file     = APP_ROOT_PATH . '/controller/' . $instance->controller . '.php';

        if (!file_exists($file)) {
            throw new \Exception('Controller file not found');
        }

        require(APP_ROOT_PATH . '/controller/' . $instance->controller . '.php');
    }

    public static function setController($controller) {
        $instance = self::getInstance();

        if (!in_array($controller, $instance::$routes)) {
            throw new \Exception('Unknown controller');
        }
        $instance->controller = $controller;
    }

    public static function getController() {
        $instance = self::getInstance();

        return $instance->controller;
    }

    public static function uriParams() {
        $instance = self::getInstance();

        return $instance->uriParams;
    }

    public static function uriParam($key) {
        $instance = self::getInstance();

        return (is_array($instance->uriParams) && array_key_exists($key, $instance->uriParams)) ? $instance->uriParams[$key] : false;
    }

    public static function addBodyClass($class) {
        $instance = self::getInstance();

        $instance->bodyClasses[] = $class;
    }

    public static function bodyClasses() {
        $instance = self::getInstance();

        return $instance->bodyClasses;
    }

    public static function setFlash($type, $message, $postData = [], $formName = null) {
        $instance = self::getInstance();

        $flashMessage = [
            'type'     => $type,
            'message'  => $message,
            'postData' => $postData
        ];

        if (null == $formName) {
            $_SESSION['sapper-flash'] = $instance->flashMessage = $flashMessage;
        } else {
            $_SESSION['sapper-flash'] = $instance->flashMessage = [$formName => $flashMessage];
        }
    }

    public static function getFlash($formName = null) {
        $instance = self::getInstance();

        if (null == $formName) {
            return $instance->flashMessage;
        } else {
            if (array_key_exists($formName, $instance->flashMessage)) {
                return $instance->flashMessage[$formName];
            } else {
                return [];
            }
        }
    }

    public static function getFlashPostData($formName = null) {
        $instance = self::getInstance();

        if (false !== $instance->flashMessage) {
            if (array_key_exists('type', $instance->flashMessage)) {
                $flashMessage = $instance->flashMessage;
            } else {
                if (array_key_exists($formName, $instance->flashMessage)) {
                    $flashMessage = $instance->flashMessage[$formName];
                } else {
                    $flashMessage = ['postData' => []];
                }
            }

            return (count($flashMessage['postData']) > 0) ? $flashMessage['postData'] : false;
        } else {
            return false;
        }
    }

    public static function resetFlash() {
        $instance = self::getInstance();

        $instance->flashMessage = false;
        unset($_SESSION['sapper-flash']);
    }

    /**
     * @return  Route Singleton instance
     */
    private static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Prevent cloning by making method private
     */
    private function __clone()
    {
    }

    /**
     * Prevent wakeup by making method private
     */
    private function __wakeup()
    {
    }
}
