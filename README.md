
- sync request parameters with defined corresponding params in config file
- makes the curl http request with new sync parameters to the mirror site which you can set in config file
- generates PDF file with license agreement
- send mail to user with license agreement

All of the process can be used optionally and can be set in config.php

DESCRIPTION:

In case we need to synchronize the form request between two other sites with different form parameters then have to set definition of our synchronized request parameters in configuration file (./config.php):

[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
....
[other => other_mirror]

The script makes redirect of http request to mirror site, generate a license agreement as pdf document and send it to the user's mail

EXAMPLE:

make POST or GET request on this app

http://testsite.localhost/entry_point_one.php?formId=10&OrderID=123456&CustomerCompany=SomeCompanyName&LicenseKey=ABC2211
