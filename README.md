# nagios-apc-check
================
nagios-apc-check is a simple script written for the Nagios monitoring service to monitor opscode APCU cache hit / miss ratios to ensure performance of the cache.

# Installation and Usage
----------------------
Copy apc_stats.php to the source APC cache server that you wish to monitoring and ensure that Nagios has access to this script. Unfortuantely, to gather APCU cache stats we have to run this script via the primary webserver that is caching.

```   
	www.example.com/apc_stats.php
```

Copy check_apc_cache.php to the Nagios server where you place your local plugins.

Adjust the URI path that the check_apc_cache.php is looking for apc_stats.php

```
$url = "http://" . $host . ":" . $port . "/nagios-apc/apc_stats.php";
``` 

Add the command to the Nagios commands.cfg or related file

```
define command {
    command_name check_apc_cache 
    command_line $USER1$/check_apc_cache.php '$HOSTADDRESS$'
}
```


