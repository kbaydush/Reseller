This script can do:

- sync request parameters between other servers through http request with defined corresponding params in config file
- makes the curl http request with new sync parameters to the mirror site which you can set in config file
- generates PDF file with license agreement
- send mail to user with license agreement
- if server not available the data will write into the file, next request will sync the data. Also it will posible to sync saved data use cron.php

All of the process can be used optionally and can be set in config.php

DESCRIPTION:

In case we need to synchronize the form request between two other sites with different form parameters then have to set the defined synchronized request parameters in configuration file (./config.php):

[field1_name => field1_name_mirror]
[field2_name => field2_name_mirror]
[field3_name => field3_name_mirror]
[field4_name => field4_name_mirror]
....
[other => other_mirror]

The script makes redirect of http request to mirror site, generate a license agreement as pdf document and send it to the user's mail

EXAMPLE:

make POST or GET request on this app

http://testsite.localhost/sync.php?formId=10&OrderID=123456&CustomerCompany=SomeCompanyName&LicenseKey=ABC2211
