<?php

// Add request matches

$CFG->set('request_settings', array(

        'purchases' => array(
            'fid' => 111,
            'fnames' =>
                array(
                    'id' => 'mirrorId',
                    'name' => 'mirrorName',
                    'surname' => 'mirrorSurname',
                    'product' => 'mirrorProduct',
                    'LicenseKey' => 'mirrorLicenseKey',
                    'CustomerCompany' => 'mirrorCustomerCompany',
                ),

        ),

        'refunds' => array(
            'fid' => 112,
            'fnames' =>
                array(
                    'id' => 'mirrorId',
                    'name' => 'mirrorName',
                    'surname' => 'mirrorSurname',
                    'product' => 'mirrorProduct',
                    'LicenseKey' => 'mirrorLicenseKey',
                    'CustomerCompany' => 'mirrorCustomerCompany',
                ),
        ),
    )
);

// Data does not going to request
$CFG->set('params_disabled', array(

    'security_data',
    'security_hash'
));