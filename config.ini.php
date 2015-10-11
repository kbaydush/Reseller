<?php

$CFG = new Registry();

$CFG->set('root_dir', dirname(__FILE__));
$CFG->set('classes_dir', realpath($CFG->root_dir . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR));
$CFG->set('logs_dir', realpath($CFG->root_dir . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR));
$CFG->set('libs_dir', realpath($CFG->root_dir . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR));

$CFG->set('mail_from', 'orders@testsite.localhost');
$CFG->set('test_mail', 'averskos@gmail.com');
$CFG->set('pdf_title', 'SITE LICENSE AGREEMENT');
$CFG->set('pdf_author', 'SomeCompanyName Inc.');

// Here you can add any form id which we need

$CFG->set('all_form_id_array', array(
    'purchases' => 10,
    'refunds' => 11
));


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

// Purchases params

$CFG->set('request_params',

    [
        $CFG->get('all_form_id_array')['purchases'] => array(
            'id' => 'mirrorId',
            'name' => 'mirrorName',
            'surname' => 'mirrorSurname',
            'product' => 'mirrorProduct',
            'LicenseKey' => 'mirrorLicenseKey',
            'CustomerCompany' => 'mirrorCustomerCompany',
            'security_data' => 'security_data',
            'security_hash' => 'security_hash'
        )],

    [
        $CFG->get('all_form_id_array')['refunds'] => array(
            'id' => 'mirrorId',
            'name' => 'mirrorName',
            'surname' => 'mirrorSurname',
            'product' => 'mirrorProduct',
            'LicenseKey' => 'mirrorLicenseKey',
            'CustomerCompany' => 'mirrorCustomerCompany',
            'security_data' => 'security_data',
            'security_hash' => 'security_hash')
    ]);

// Data does not going to mirror
$CFG->set('params_disabled', array(

    'security_data',
    'security_hash'
));

$CFG->set('order_product_names', array(
    'ProductLetters' => 'PROD-L-001',
    'ProductNumbers' => 'PROD-N-001',
    'ProductBasics' => 'PROD-B-0011',
    'ProductColors' => 'PROD-C-0011',
    'ProductShapes' => 'PROD-S-0011'
));

// response results (redirecting path array)

$CFG->set('response_successfull', array(
    'http://mirror-db.localhost/success.html',

));

$CFG->set('response_wrong', array(
    'http://mirror-db.localhost/error.html'
));

