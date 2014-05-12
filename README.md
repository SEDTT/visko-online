visko-online
============
VisKo online is a web interface for the VisKO API created by Dr. Del Rio. (https://github.com/nicholasdelrio/visko).
Its primary use case is to help users visualize datasets without them having to know the specifics of the visualization software. VisKo-online extends this work with an updated UI, error handling, and logging. Design and development of this project was undertaken as part of the Software Engineering I & II course at the University of Texas at El Paso.

Installation
------------

In order to install VisKo and visko-online you will need the following software:
- ant
- java 1.6+
- tomcat 7
- eclipse Kepler w/ Egit extension
- apache2 w/ php5+
- phpunit 4.1+ (for testing)
- mysql server 5.6

The first step is to install a forked version of the VisKo project that has been enhanced for use with visko-online. It is available at https://github.com/SEDTT/visko . It includes a README on the top level directory that describes how to install it.

Since visko-online consists of a tomcat and apache component, there are two major parts to the installation.

### Installing ViskoBackend (Java)

With Apache Tomcat installed, in Eclipse go to *File>Import>Projects* from Git adn point it to your local clone or this repository. Go to import existing projects and import the *viskobackend* project. You will need to configure the path to VisKo's knowledge base in *WebContent>WEB-INF>web.xml>visko_location* . This value should be set to path of the *registry-tdb* folder in the Visko-web project.

Run the Backend by running the Tomcat server with eclipse.

Some common errors are not linking to the *api* project (install VisKo first), Incorrect Java version (set to your version in *Project>Properties>Java Build Path*

### Installing Visko-online (PHP)

ViskoBackend must be running in order to use the rest of the system (see above). To install visko-online just copy the contents of the *web/* directory to a path accessible by your web server, i.e. */var/www* or create an appropriate symlink.

To establish the database, create a new database and user for the visko project. The database structure can be found in *web/config/team3DB.sql*. For example, with mysql client you could set up the database using

>mysql -u visko -p visko < web/config/team3DB.sql

The next step is to configure the database location. Currently this requires editing two different files ***web/include/membersite_config.php*** and ***web/config/config.ini***. Editing the .ini is straightforward, in the .php file only set the hostname, username, password as well as the admin-email.


Running
-------
If you installed it correctly you should be able to register as a new user and use the working functionality immediately!

Remember the Visko API has to be working and accessing actual web services, and the ViskoBackend must be running (through tomcat) in order to use visko-online.
