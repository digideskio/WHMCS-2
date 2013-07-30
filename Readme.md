## Monitis Addon for WHMCS
Monitis addon for WHMCS provides integration with the [Monitis](http://monitis.com) platform including:  

  - automation of monitor setup and management both for hosting companies and their customers  
  - direct access to monitoring data and statuses on WHMCS admin panel  
  - automated monitoring products / product addons setup and configuration  

#### Installation
Copy or clone the repository and install it as follows:  

1. monitis_addon folder needs to be uploaded to the /modules/addons/ directory of your WHMCS installation
2. upload __monitis_monitors.php__ and __monitis_networkstatus.php__ into WHMCS root folder
3. upload __monitis_monitors.tpl__ and __monitis_networkstatus.tpl__ into the template folder 
4. add new tab in the main navigation template ( __header.tpl__ ) and set link to the page __monitis_monitors.php__
5. you then need to navigate to Setup > Addon Modules within your WHMCS Admin Area to activate and configure the module
6. upon activation, you will need to configure "Access Control" settings.  

Additional settings relating to the Monitis addon configuration are provided within the addon itself.  
__Access Control__ - These checkboxes allow you to define which role groups you want to allow to access and use the project management system  
Once you're done configuring the access rights, click __Save__ to complete the process.  

Please, note that we have tested addon on WHMCS version 5.1.2 and higher.

#### Getting Started
To access the Monitis addon, simply navigate to Addons > Monitis Addon.  

First, you need to provide your Monitis account credentials ( _API key and Secret key, available from your Monitis dashboard: Account >API key_ ) on Monitis Account tab.  
If you do not have Monitis account, please, [signup](https://portal.monitis.com/free-signup).  
Next step is configuration of settings for predefined monitor types _Addons > Monitis Addon > Settings_.  
Here you define default monitor types (server and network) and configurations.  

When saving the defined settings you will be offered to automatically create monitors for all your existing servers.  

#### Monitoring your infrastructure
There is no need to log into Monitis dashboard to create required monitors or to access monitoring results.  
All the information needed for monitoring your server base is located on _Monitis Addon > Servers_ and _Monitis Addon > Monitors_ tabs.   
In order to automate monitor creation for existing or newly provisioned servers, the information provided in __Hostname__ and __IP Address__ fields of your servers (Setup > Products/Services > Servers) will be used.  
Please, be very careful when filling in these fields.  

  - __IP Address__ will be used for creating uptime monitor.  
  - __Hostname__ will be used to identify Monitis Agent installed on the server ( _It is required that Monitis Agent Name is set to the hostname_ ).  

Please, note that Monitis addon doesn’t automate Monitis Agent installation on your servers.   

#### Monitoring for web hosting clients
Monitis addon makes possible to offer monitoring to your clients as a product or product addon.

#### Products
On _Monitis Addon > Products_ tab you will see all your products, you can mark the product as Monitoring product and configure available monitor types.  
When activating a product as Monitis monitoring, two new custom fields will be created for that product – URL/IP and Monitor Type.  
Information provided in these fields will be used for creation of monitor upon order activation. 

#### Product addons
On _Monitis Addon > Addons_ tab you can mark product addon as Monitis monitoring and define monitor type.  
Product's Domain and Dedicated IP fields will be used to set up monitors.

All the monitors created as Monitoring product or product addon will be available in client area at the new tab that was added based on monitis_monitors.php.
