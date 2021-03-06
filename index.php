<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use \rezozero\monitor\engine\Collector;
use \rezozero\monitor\engine\PersistedData;
use \rezozero\monitor\kernel\CLIMonitor;
use \rezozero\monitor\kernel\Router;
use \rezozero\monitor\view;

define('BASE_FOLDER', dirname(__FILE__));

require BASE_FOLDER . '/vendor/autoload.php';

/*
 * CONF
 */
$confFile = file_get_contents(BASE_FOLDER . '/conf/conf.json');
$CONF = json_decode($confFile, true);

if (!empty($CONF['timezone'])) {
    date_default_timezone_set($CONF['timezone']);
} else {
    date_default_timezone_set('Europe/Paris');
}

/*
 * Logs
 */
// create a log channel
$log = new Logger('RZMonitor');
$log->pushHandler(new StreamHandler(BASE_FOLDER . '/data/monitor.log', Logger::INFO));

/*
 * Persisted data
 */
$data = new PersistedData(BASE_FOLDER . '/data/persistedData.json');

/*
 * Command line utility with infinite crawl loop
 */
if (php_sapi_name() == 'cli') {
    new CLIMonitor($CONF, $data, $log);
}
/*
 * Need auth for HTTP requests
 */
elseif (Router::authentificate($CONF, $log) === true) {

    $tokens = Router::parseQueryString();

    /*
     * Simple table view for Panic StatusBoard™ iOS app
     *
     * Just call yourdomain.com/table
     */
    if (isset($tokens[0]) && $tokens[0] == 'table') {
        $collector = new Collector('sites.json', $CONF, $data, $log);
        $output = new view\TableOutput();
        $output->parseArray($collector->getStatuses());
        echo $output->output();
    } else {
        /*
         * HTML view for internet browsers
         */
        $collector = new Collector('sites.json', $CONF, $data, $log);
        $output = new view\HTMLOutput();
        $output->parseArray($collector->getStatuses());
        echo $output->output();
    }
}
