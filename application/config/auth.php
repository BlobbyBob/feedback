<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Authentication Policy
| -------------------------------------------------------------------
| The Policy is the default action the Authentication library will
| require when accessing a controller or method. It will be performed
| when no other rules are found for the current page.
| You can either deny access from not logged in users by setting the
| value to 'deny' or grant access to everything by setting the value
| to 'accept'.
|
| Prototype:
|
|   $config['auth']['policy'] = 'accept';
|
*/
$config['auth']['policy'] = 'accept';


/*
| -------------------------------------------------------------------
|  Authentication Rules
| -------------------------------------------------------------------
| By setting rules you can hardcode certain non-specific access
| restrictions. To decide whether a user can access a page, the value
| is initially set to the Policy. Afterwards all rules are applied
| top-down and overwrite each other (and the policy). Thus you should
| start with general rules and end with specific rules. Be also
| aware, that there will be authentication rules saved in persistent
| storage, that will applied after these rules here.
|
| The target for the rules are specified by using the
| controller/method name to grant/prevent access to. Further you can
| use the wildcard operator '*' for method names.
| Similar to the Policy the possible values are 'accept' and 'deny'.
|
| Prototype:
|
|   $config['auth']['rules']['controller']['method'] = 'deny';
|
*/
$config['auth']['rules']['backend']['*'] = 'deny';