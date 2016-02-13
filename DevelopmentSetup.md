# NOTE: #
This is still a work in progress so all steps may not work

# Table Of Contents #
  * Installing Programs
    * Apache
    * PHP
    * PostgreSQL
    * Eclipse (Recommended IDE)

# Installing Apache #
  1. Download from http://httpd.apache.org/download.cgi
  1. You want version 2.2.9
  1. Follow the installation through accepting defaults
  1. Once it is completed in your task tray (next to clock) you should see an icon that looks like a feather with a green play button.  That is to control Apache
  1. To verify that the server works correctly open up your web browser and type localhost into the address bar
  1. It should say something like "It Works!"
  1. By default if you do not have a fire wall people from the outside will be able to access your web server do prevent this do the following
    1. Go to Start->Programs->Apache HTTP Server->Configure Apache Server->Edit httpd.conf
    1. Find the line "Listen 80"
    1. Change it to "Listen localhost:80"
    1. The Apache Server needs to be restarted for changes to take effect

# Installing PHP #
  1. Download from http://www.php.net/downloads.php
  1. Start the installer when it asks you for Web Server Setup choose Apache 2.2.x Module
  1. Next it will ask you for the directory of the Apache Configuration files
    1. The directory is C:\Program Files\Apache Software Foundation\Apache2.2\conf\
  1. After that it will allow you to choose which extensions to install choose PDO (and under PDO choose the PostgreSQL driver), PostgreSQL, XML-RPC, we may need more extensions later on but for now those should be good.
  1. Restart the Apache Server again
  1. navigate to C:\Program Files\Apache Software Foundation\Apache2.2\htdocs and create a file called index.php
  1. within the file put the following
```
<?php phpinfo(); ?>
```
  1. Now in your web browser go to http://localhost/index.php you should see a page that says PHP Version 5.2.6, that means that everything it working correctly


# Installing Postgre SQL #
  1. Download it here http://www.postgresql.org/download/
  1. Since we don't have any databases or tables you just need to install it

# Installing Eclipse #
  1. Go to http://www.eclipse.org/downloads/
  1. Choose Eclipse IDE for Java Developers (84 MB)
  1. Run the installer program and verify that you can start it up

## Installing Subclipse ##
  1. Start up Eclipse
  1. Go to Help->Software Updates...
  1. Click Add Site (button on right hand side)
  1. For the URL enter http://subclipse.tigris.org/update_1.4.x
  1. After clicking Ok the URL should show up in the list on the left, just check the checkbox next to it and click the Install button

## Installing PHPEclipse ##
  1. Perform the same steps as for Subclipse except use the following URL http://update.phpeclipse.net/update/stable/1.2.x

# Final Changes #

Once all of that is done it is necessary to setup Eclipse for the project along with Apache see http://code.google.com/p/victorioussecret/wiki/ProjectSetup