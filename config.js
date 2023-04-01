// increase the version when uploading to create a new service worker cache name
var serviceWorkerCacheVersion = 1.15;

/*
define the environment where the app is running
local -> the app is running locally
server -> the app is running on the server
*/

var environment = "local";
var appURL = "https://www.cirgeo.unipd.it/fireres/";
var backendURL = "https://www.cirgeo.unipd.it/fireres/"; 
if ( environment == "local" )
{
	appURL = "https://www.cirgeo.unipd.it/fireres/";
	backendURL = "https://www.cirgeo.unipd.it/fireres/";
}
else if ( environment == "server" )
{
	appURL = "https://www.cirgeo.unipd.it/fireres/";
	backendURL = "https://www.cirgeo.unipd.it/fireres/";
}
