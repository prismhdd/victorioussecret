# Setting up the Project #
  * In Eclipse go to Window->Open Perspective->SVN Repository Exploring
  * On the left hand side where it shows SVN Repository right click in the area and go to New->Repository Location
  * For the URL enter https://victorioussecret.googlecode.com/svn/trunk
  * When you click ok you will be prompted for a Username/Password
    * Go to http://code.google.com/p/victorioussecret/source/checkout
    * At the end of the Project Members URL there is something like --username, what ever is after that is your username
    * As for your password click on googlecode.com password in order to view it
  * Once the repository location is added it should show up in the left pane
  * Expand it, you should see a folder name artist\_alerter
  * Right click on it and go to Checkout... and then click Finish
  * What it will do is create a project in your Eclipse workspace with all of the files from the SVN repository
  * Once that is complete go to the PHP Perspective (Window->Open Perspective) you should see artist\_alerter as one of the projects
  * Also if you expand the project you should see test.php, it is just a test file to verify everything works

# Using SVN from within Eclipse #
  * To update the project with the latest code just right click on the project and go to Team->Synchronize With Repository
  * It should show you incoming/outgoing changes, right click on the project and select Update to update, and Commit to send you changes to the Repository
  * If there is a conflict there are two things you can do
    * Override and Update - this will overwrite your changes with the latest from the repository
    * Mark as Merged - this is used after you have merged the changes together
      * After doing this you should commit the merged changes

# Setting up Apache with the Project #
  * In order to host the project the Apache configuration file needs to be modified
  * Go to Start->Programs->Apache Web Server->Configure Apache Server->Edit httpd.conf
  * Scroll down to the bottom and add this
```
Alias /artist_alerter /home/anthony/workspaces/personal/artist_alerter

<Directory "/home/anthony/workspaces/personal/artist_alerter">
        Options Indexes FollowSymLinks
        AllowOverride All

        # Controls who can get stuff from this server.
        Order allow,deny
        Allow from all
</Directory>
```
  * Make sure you change /home/anthony/workspaces/personal/artist\_alerter to be the path of your project (should be something like C:\\Documents and Settings\\MyUsername\\workspace\\artist\_alerter