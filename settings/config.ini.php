<?php

$CFG->set('root_dir', dirname(dirname(__FILE__)));
$CFG->set('classes_dir', $CFG->get('root_dir') . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR);
$CFG->set('logs_dir', $CFG->get('root_dir') . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR);
$CFG->set('libs_dir', $CFG->get('root_dir') . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR);

$CFG->set('mail_from', 'orders@testsite.localhost');
$CFG->set('test_mail', 'averskos@gmail.com');
$CFG->set('pdf_title', 'SITE LICENSE AGREEMENT');
$CFG->set('pdf_author', 'SomeCompanyName Inc.');




// life time of PDF file
$CFG->set('pdf_lifetime', 60 * 5);

// debug settings by default (on/off)

$CFG->set('DEBUG_MODE_BY_DEFAULT', array(
    //   gen pdf init
    'pdf' => 1,
    //  send mail init
    'sendmail' => 1,
    'testmail' => 0,   //test mail [yes/no]
    'request' => 1,          // request to Mirror [yes/no]
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

