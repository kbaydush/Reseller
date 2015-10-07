

In case we need to synchronize the form request between two other sites with different form parameters then have definition of our synchronized request parameters in configuration file:

[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
[field1_name => field1_name_mirror]
....
[other => other_mirror]

The script makes redirect of http request to mirror site, generate a license agreement as pdf document and send it to the user's mail

example:

make POST or GET request on this app

http://testsite.localhost/entry_point_one.php?formId=10&OrderID=123456&CustomerCompany=SomeCompanyName&LicenseKey=ABC2211
