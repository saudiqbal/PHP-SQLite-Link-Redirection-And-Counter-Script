Thank you for trying the PHP SQLite Link Redirection script.
You can have a Microsoft looking link redirection service with counter.
Now you can post links in different places and if the target link changes you dont have to go back to edit the whole link, just go to linkmanagement folder and edit the link there.

To use upload the directory structure to your server.
yourdomain.com/goto.php
yourdomain.com/linkerror.php
yourdomain.com/linkmanagement

Change the variables in config.inc.php in linkmanagement folder.
Change the username "admin" and password "adminpassword" in index.php file located here if($username == "admin" && $password == "adminpassword") to whatever you want.
Change the name of database in $dbname = "LinksRedirect.db"; to some random name to keep it secret.

chmod /db folder 777
chmod /db/LinksRedirect.db or whatever name you choose.

Run setup.php and then delete the file setup.php