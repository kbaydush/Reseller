<?php

$CFG->set('root_dir', dirname(dirname(__FILE__)));

// debug settings by default (on/off)
$CFG->set('DEBUG_MODE_BY_DEFAULT', array(
    //   gen pdf init
    'pdf_creator' => 1,
    //  send mail init
    'send_mail' => 1,
    'testmail' => 0,   //test mail [yes/no]
    'curl_http_request' => 1,          // request to Mirror [yes/no]
    'setmirror' => 'test', //Mirror server -> $CFG->MIRROR_SERVERS array values
    'pushstorage' => 0,        // data submit from file [yes/no]
    'force' => 0,       // data submit to main server [yes/no]
// Attention! If you need to see all process information than simply have to use the POST param [info = true] in request with submit
    'info' => 0        // instance dump [yes/no]
));


// system's servers are available
$CFG->set('MIRROR_SERVERS', array(
    'test' => 'http://testmirror.localhost',
    'local' => 'http://mirror.localhost'
));

// response results (redirecting path array)

$CFG->set('response_successfull', array(
    'http://mirror-db.localhost/success.html',

));

$CFG->set('response_wrong', array(
    'http://mirror-db.localhost/error.html'
));

$config = new reseller\Config(ROOT_DIR);
$config->setRegistry($CFG)
    ->setLogDirectory("logs")
    ->setMailFrom(
        new \reseller\Config\ConfigMail('orders@testsite.localhost', 'SomeCompanyName Orders')
    )
    ->setMailTest(
        new \reseller\Config\ConfigMail('averskos@gmail.com')
    )
    ->setPDF(
        new \reseller\Config\ConfigPDF('SITE LICENSE AGREEMENT', 'SomeCompanyName Inc.', 60 * 5)
    );
