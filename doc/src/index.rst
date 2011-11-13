.. toctree::
   :maxdepth: 1

###################
Asterisell Overview
###################

Asterisell is a web application for rating, showing to customers, and billing VoIP calls.

Usage scenario:
  * you are a vendor of Voice over IP Telephony (VoIP) services;
  * your :term:`customers <customer>` pay you for this service;
  * your customers can call users residing on telephone networks that are not directly managed/owned from you;
  * for routing calls to external networks, you use the services of other :term:`telephone vendors <VoIP vendor>`, and you pay them for this service;

Every call has:
  * an income: what your :term:`customer` pays to you;
  * a cost: what you pay to other telephone service vendors (:term:`VoIP vendor`) in order to route the call;
  * an earn: the difference between the income and the cost;

You can use Asterisell for:
  * rating calls;
  * showing to your customers details about their calls;
  * billing your customers;
  * calculating what you owe to other telephone service vendors (:term:`VoIP vendor`)

You can have different :term:`partners <partner>`, and different :term:`resellers <reseller>`.

.. _installation:

############
Installation
############

Requirements
============
  
  * HTTP WEB Server;
  * PHP 5.0 or greater (PHP 4.0 is not supported);
  * `GD support <http://www.php.net/manual/en/image.installation.php>`_ enabled in PHP;
  * MySQL DBMS;

Software Infrastructure
=======================

VoIP calls are managed usually from an `Asterisk Server <http://www.asterisk.org>`_
  * it routes the calls to the proper dial peer;
  * it associates to every customer a unique "accountcode";
  * it writes Call Detail Records (CDRs) on a specific MySQL database table shared with Asterisell.

VoIP calls can be managed from other servers, or call detail records can be imported from CSV files.

Asterisell is a PHP5 web application that:
  * reads calls information from the CDR table shared with Asterisk Server;
  * associate to every call a cost (what the service provider pays to other vendors for routing the customer's call);
  * associate to every call an income (what the customer pays to the service provider);
  * displays calls info;

Download
========

The suggested way to download this release is using `Git version control system <http://git-scm.com/>`_ . This allows to:
    * download application updates in an efficient way;
    * be advised of conflicts between your customizations and application updates;
    * send back to me bug-fixes and improvements;
    * receive improvements from other in an efficient way;
    * upgrade to commercial release easily without loosing your customizations;

There is an Asterisell repository at `http://github.com/massimo-zaniboni/Asterisell. <http://github.com/massimo-zaniboni/Asterisell>`_

Choose a directory where installing Asterisell. For example `/var/www/asterisell3`. 

For initial download of the free version::

  git clone http://github.com/massimo-zaniboni/Asterisell.git

For the commercial version::

  git clone http://your-license:your-license@support.profitoss.com/asterisell/git/asterisell-commercial-stable-3.git <your-new-asterisell-directory>

replacing `your-license` with your license code, obtained after purchasing the commercial version. NOTE: the download operation is rather slow (1-8 minutes).

It is always possible upgrading a free version to a commercial version. For updating/upgrading to new releases see :ref:`asterisell_upgrading`.

File Permissions
----------------

In Linux Debian make sure that the "www-data" user can read the content of the installation directory::

  chown -R :www-data asterisell3
  chmod -R g+rwx asterisell3

Packages
--------

The typical installation requires:
  * Apache2 HTTP server
  * mod_php5
  * mod_ssl
  * MySQL database server
  * awk

Asterisell use some PHP5 libraries. On Fedora/Centos for example you must install::

    yum install awk
    yum install httpd
    yum install php php-cli php-common
    yum install mysql mysql-server php-mysql
    yum install php-bcmath php-xml php-mbstring

and then execute::

    /etc/init.d/httpd restart

MySQL Database Configuration
============================

Up to date Asterisell is tested only with `MySQL DBMS <http://www.mysql.com>`_ , but the Symfony framework support many other popular open source DBMS.

Database Access Parameters
--------------------------

Update::

  config/databases.yml
  config/propel.ini
  scripts/initdb.sh

according your needs using the correct host, username and password for MySQL access. 

Initially you must use the root/admin account of MySQL, because  configuration scripts will create a new database. Later you can create a specific user for the Asterisell database, in order to limit the capability of the Asterisell user. 

The suggested database name is `asterisell3` in order to avoid conflicts with previous or new version of Asterisell needing different database schemas.

How to create a Database User with Limited Access to Asterisell Database
------------------------------------------------------------------------

Enter into MySQL shell::

  mysql -u root -p mysql
  
Create a user that can invoke MySQL only from localhost (supposing that Asterisell webserver hosts also the MySQL DBMS)::

  CREATE USER 'asterisell3user'@'localhost' IDENTIFIED BY 'some-password-here';
  GRANT ALL ON asterisell3.* TO 'asterisell3user'@'localhost';

This example, supposes that `asterisell3` is the name of created Asterisell database, and `asterisell3user` the name of database user.

NOTE: `GRANT ALL` is needed in order to support the database upgrade script.

Installation Script
-------------------

The installation script will:
  * create a new `asterisell3` database;
  * load the tables;
  * initializing the Asterisell application with demo data;
  * fix directory permissions;
  * reset the Symfony cache;

It must not be used if it is an update of Asterisell, because otherwise all data will be lost.

In any case the script will warn you about this.

Execute::


  cd scripts
  sh initdb.sh

and answer to questions. 

The very last versions of MySQL requires `Engine=InnoDB;` instead of `Type=InnoDB;` inside file `data/sql/lib.model.schema.sql`. In case of problems during database creation (initial installation of Asterisell), you must update manually this file. 

Change Demo Data Later
----------------------

The installation script will load also some demo data in order to test Asterisell.

If you want later, start with an empty database, you can execute::

  cd scripts
  php reset_db_and_init_data.php init <some-password-for-root-user-access>

for creating an empty database, with only minimal data, and a "root" user with the chosen password for initial login.

The scripts supports other type of data initialization. This command will display all its options::

  cd scripts
  php reset_db_and_init_data.php

You can also inspect the content of `scripts/initdb.sh` in order to see the details of performed actions.

Optional Configuration for Developers
-------------------------------------

If you are a developer, and you are changing Asterisell source code, maybe you want to change also its database schema, contained in `config/schema.yml`. 

In this case, you must also instruct `config/propel.ini` about how to access the MySQL database. These are the same parameters of `config/databases.yml`, but they are used from a different tool, and so they must be repeated here.

Update `config/propel.ini` according your needs.

Adapt it, using the same parameters of the `databases.yml`. This file contains a lot of parameters, but you must only change these lines::

    propel.database.createUrl  = mysql://localhost/
    propel.database.url        = mysql://localhost/asterisell3
    propel.output.dir          = /var/www/asterisell3


If you have changed the database structure in the file `config/schema.yml`, you must also update the SQL instructions creating the MySQL database. You can use the script `scripts/makedb.sh`. It will recreate the SQL commands and then it call `initdb.sh` in order to load the new database.

Web Server
==========
  
Website Configuration 
---------------------

Create the file `asterisell.conf` inside the directory:
  * `/etc/httpd/conf.d/` or
  * `/etc/apache2/conf.d/`
  
The content is something like::

    Alias /your-voip-service /var/www/asterisell3/web/

    <Location /your-voip-service>
      Order allow,deny
      Allow from all 

      # If you have mod_ssl installed 
      # then with these lines you can force the usage of https connections
      # for all Asterisell access.
      # If you omit them, then the passwords are sent in plain text and
      # they can be intercepted from hackers...
      #
      AllowOverride All
      <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{HTTPS} off
        RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}
      </IfModule>
  
    </Location>

NOTE: remember to add `/web` to your Asterisell installation directory. This because it is only the `web` subdirectory of Asterisell project that must be part of the web-space.

Restart the apache2 httpd server in order to render active the configurations using a command like::

    /etc/init.d/httpd restart  

or::

    /etc/init.d/apache2 restart

If it is all correct then `http://your-voip-service` will display the login form.

PHP Resources
-------------

The administrator can invoke heavy jobs, for example graph and stats about calls. In this case it is usefull to increase the resources of PHP scripts inside on-line sessions.

In CENTOS the settings are in `/etc/php.ini`, in Debian are in `/etc/php5/apache2/php.ini`. Change somethiing like::

  ;;;;;;;;;;;;;;;;;;;
  ; Resource Limits ;
  ;;;;;;;;;;;;;;;;;;;

  max_execution_time = 30     ; Maximum execution time of each script, in seconds
  max_input_time = 60 ; Maximum amount of time each script may spend parsing request data
  ;max_input_nesting_level = 64 ; Maximum input variable nesting level
  memory_limit = 128M      ; Maximum amount of memory a script may consume (128MB)


into something like::



  ;;;;;;;;;;;;;;;;;;;
  ; Resource Limits ;
  ;;;;;;;;;;;;;;;;;;;

  max_execution_time = 180     ; Maximum execution time of each script, in seconds
  max_input_time = 60 ; Maximum amount of time each script may spend parsing request data
  ;max_input_nesting_level = 64 ; Maximum input variable nesting level
  memory_limit = 128M      ; Maximum amount of memory a script may consume (128MB)


increasing the execution time from 30 seconds to 180 seconds.

NOTE: heavy jobs like email sending, are done from the cron-job, in off-line mode, and they are not affected from these settings / constraints.

PHP Speedup
-----------

`APC <http://pecl.php.net/package/APC>`_ is a free, open source framework that caches data and compiled code from the PHP bytecode compiler in shared memory.
  
I suggest installing it, because it is well tested, and it speeds-up a lot the execution of Asterisell and other PHP applications.

For installing it in Debian::

  aptitude install php-apc
  
or in CENTOS follow `the instruction of this webpage <http://2bits.com/articles/installing-php-apc-gnulinux-centos-5.html>`_ (up to date the APC package is not part of CENTOS).

IMPORTANT: In order to activate it, the Apache web server must be restarted.

IMPORTANT: Up to date there can be conflicts between APC (version 3.0.19) and SwiftMailer. If after the sending of the first mail, an error message appears in the problem table (something like `Fatal error: Cannot inherit previously-inherited or override constant LEVEL_TOP from interface Swift_Mime_Message`), then try to upgrade APC or disactivate APC.

MySQL
-----

Rates based on CSV files can be rather big, because they contain a lot of data. Asterisell save them in a record, and the SQL command can be rather big.

So you must use a reasonable `max_allowed_packet` size, for communication between PHP and MySQL.

Check that inside `/etc/mysql/my.cnf` there is something like::

  [mysqld]
  max_allowed_packet = 16M
  
In case of problems, increase this limit, and then restart MySQL (NOTE: during restart new inserted CDR records will be lost)::

  /etc/init.d/mysql restart

Last versions of MySQL execute a fsync (flush) on disk for every transaction. This is a very big slow down for Asterisell, because it does not group batch work on CDRs on a single transaction. If MySQL is slow, it can be configured for flushing on disk the transactions every seconds. Add inside `/etc/mysql/my.cnf`::

  innodb_flush_log_at_trx_commit = 0

Consult `MySQL related documentation <http://dev.mysql.com/doc/refman/4.1/en/innodb-parameters.html#sysvar_innodb_flush_log_at_trx_commit>`_ for more details on side effects of this setting.

Additional File Access Permissions
----------------------------------

If you have not used the default installation script (`scripts/initdb.sh`), then make sure to execute::

    ./symfony fix-perms

or::

    chmod -R a+rw log
    chmod -R a+rw cache

in order to enable the write rights on (only) these two directories.

Cron Job
========
 
Calls Rating and Jobs Processing
--------------------------------

Asterisell rates the calls and execute other jobs off-line, using a cron-job process. This allows to use all the resources of the machine, without the constraints of online sessions.

The list of jobs to execute and the various parameters are inside `apps/asterisell/config/app.yml`.

In case of problems during job execution, a mail is sent to the administrator.

User Permissions
----------------

The process must be executed from the same user that is associated to the http connection. 

On Fedora/Centos it is typically `apache`, on Debian `www-data`. In order to retrieve it, you can enter into Asterisell web interface, select Help menu and PHP-INFO option. Then you can search the element `User/Group`. The first value is the name of the PHP/webserver user.

Cron Job Setting
----------------

Supposing the http user is "apache" you can associate to it a cron job using the command::

  crontab -u apache -e

This command will open an editor. If the defalt editor is `vi`, then digit `:i` (and press enter) in order to start editing, and `:wq` (and press enter) at the end of editing, in order to `write` and `quit/exit` from the editor

Add this line::

  5,10,15,20,25,30,35,40,45,50,55 * * * * sh -c "cd /your-asterisell-dir/scripts/ ; nice php process_jobs.php > /dev/null "


The meaning of the line is to execute at minutes 5, 10, 15, 20, ... of every hour the `php rate_all_and_test.php` command inside the Asterisell directory.

Log Rotate
----------

In order to reduce log file size put `asterisell-logrotate` with execution privileges in `/etc/cron.monthly` directory::


    #!/bin/sh
    cd /your-asterisell-install-dir
    ./symfony log-rotate asterisell prod

and set it as an executable file ::

  chmod u+x asterisell-logrotate

Note that `asterisell` after `symfony` command is the name of the application and it is not depends from the directory installation.

.. _asterisell_customizations:

Asterisell Customizations
=========================

Jobs/Workflow Customizations
----------------------------

Asterisell uses a blackboard approach to process information:
    * events are put inside the database/blackboard;
    * customizable/configurable jobs react to events;
    * jobs can produce new events;

In this way it is possible to add new jobs, changing the behaviour of the application.

If you add new `jobs` make sure to add them to the `apps/asterisell/lib/jobs/userjobs`, otherwise during subsequent update of Asterisell application, all new jobs could be lost or there can be a lot of Git merge conflicts.

Some Jobs like PDF invoicing, email composition and so on require some customization. You can create a custom Job modifying already existing jobs, put them in `apps/asterisell/lib/jobs/userjobs` directory. The more elegant way is to change also the name of the job, add it to the `apps/asterisell/config/app.yml` file, removing the old job.

Rates Customizations
--------------------

New type of rate methods can be added:
  * add a new rate inside `apps/asterisell/lib/rates`
  * enable the rate inside `apps/asterisell/config/app.yml`
  * refresh the cache `./configure.sh`

Troubleshooting
===============

File Permissions
----------------

Log Directory
~~~~~~~~~~~~~

Often after upgrades there are problems related to the Asterisell log files inside log directory.

If this file was created from root then the `apache` user is not able to add info to it and the entire Asterisell application is blocked. In this case change the permissions of file with something like::

    cd log
    chmod a+rw asterisell_prod.log
    chmod a+rw asterisell_dev.log

or better change the owner in something like::

    cd log
    chown apache asterisell_prod.log
    chown apache asterisell_dev.log

or execute::

    ./symfony fix-perms

Try also to restart the web server.

Created Files
~~~~~~~~~~~~~
  
During initial Asterisell configuration new files can be created. Check if these files are readable from web-server process. For example on my debian machine I performs::
  
     chown -R :www-data * 
     chmod -R g+rx *
     sh configure.sh

where `www-data` is the group used from my webserver.

Additional Run-Time Debug Info
------------------------------

In case of problems you can enable the development/debug version of Asterisell that shows useful informations about its execution and related problems. Execute::

    ./symfony enable asterisell dev

and open the url `http://your-web-url/asterisell_dev.php/login`

When finished remember to execute::

    ./symfony disable asterisell dev

NOTE: on the contrary of Asterisell production version, in the development version if you change Asterisell source code, you must not execute `sh configure.sh`, because the development version recreate all files every time in order to speed up development at the expense of run-time executions. 

NOTE: as in the Asterisell product version, in the development version if you change some configuration parameters you must execute `sh configure.sh` because certain Asterisell modules are regenerated according the configured values.

Run Time Configuration Problems
-------------------------------

Every problem encountered from Asterisell during the call rating process is clearly reported to the administrator with hints of how to resolve it.

The presence of problems is signaled also via email to the administrator.

In case of dubious configurations Asterisell advise the administrator and suspend the rate of affected calls.

The rate process is rather robust and error-free regarding ill defined configurations because:
  * re-rating of calls is always possible;
  * problems are always signaled;

Feedback
--------

Web servers, PHP environment, libraries, and os on... can interact in strange ways. If something is not working properly let me know!

Security
========

The end user interacts only with the `Call Report` form. The content of user input fields is checked by a very conservative function that removes every non proper character.

No particular care is put on other forms because they are accessible only from the administrator.

User session handling is managed directly from Symfony and PHP engine.

MySQL advanced optimizations
============================

For obtaining a 10x-20x speedup of call-report and related queries, the CDRs of last 1-2 months must be saved in the MySQL database cache in RAM. This makes a big difference in performances. Make sure having a `my.cnf` file like this::

  [mysqld]
  ###############################  
  # ASTERISELL RELATED SETTINGS #
  ############################### 
  # Optimize InnoDB performances for Asterisell usage.
  # NOTE: it will use the majority of the RAM of the server
  # for Asterisell and other MySQL databases.
  #
  # Set this to 60-80% the RAM of the server
  innodb_buffer_pool_size = 1G

  sort_buffer_size = 50M
  thread_cache_size = 4
  tmp_table_size = 50M
  sync_binlog = 0

  # not very important
  innodb_additional_mem_pool_size = 10M

  # Commits are flushed on the disk each second,
  # and not immediately.
  innodb_flush_log_at_trx_commit = 0

  innodb_lock_wait_timeout = 50
  table_cache = 92
  innodb_flush_method=O_DIRECT

  # speed-up rating of CDRs and also other performances - very important
  innodb_log_buffer_size = 8M

Restart MySQL for enabling changes in configuration.

.. _upgrading:

#########
Upgrading
#########

Create deploy directory
=======================

In order to reduce the downtime of main Asterisell application, you can test the new version in a separate directory, and then deploy the new version, when it is all ok.

Copy the current Asterisell directory content inside another directory::

  cp -r <source-directory> <test-directory>

Merge your customizations with new Asterisell version
=====================================================

If you have installed the application using Git (the suggested way), these are the commands for free Asterisell version::

  git commit -a -m "<DESCRIBE YOUR CUSTOM CHANGES>"
  git pull http://github.com/massimo-zaniboni/Asterisell.git

These are the commands for the commercial Asterisell version::

  git commit -a -m "<DESCRIBE YOUR CUSTOM CHANGES>"
  git pull http://your-license:your-license@support.profitoss.com/asterisell/git/asterisell-commercial-stable-3.git`

where "your-license", must be replaced with your license code, obtained after purchasing the commercial version.

Then follow the Git procedure to resolve merge conflicts. Usually there will no merge conflicts, because Git tries to preserve both you customizations and new version modifications. In case of conflicts:
  * edit the files with problem, 
  * fix the `>>>>>> .... <<<<<<<` sections, 
  * signal to git that the conflict on the file is resolved using `git add <fixed-file>`, 
  * check pending conflict with `git status`,
  * commit the final merged version when done with `git commit -a`

In case of troubles, `ask to the forum. <:http://groups.google.it/group/asterisell>`_ I will update these installation notes, according the signaled problems/suggestions.

Database Upgrade
================

Versions with the same major version number, use compatible database schema with minor changes, so they can be easily upgraded.

For security reasons, make first a backup of current database using something like::

  mysqldump -u <your-user> <your-database> --single-transaction > asterisell3.sql


Note that the `--single-transaction` option allows to make the database backup, without locking MySQL database, and so new CDRs can be processed.
  
Then upgrade the current database using::

  cd scripts
  php upgradedb.php
  
Code refresh
============

After changing some code, for example after resolving merging conflicts, or after applying customization, you *must execute*::

  sh generate.sh

in order to flush the Symfony cache and fix the permission on "log" and "cache" directories, and for generating some PHP files depending from application settings.

Application testing
===================

If you use the same database both for production and new version testing, you must first disable the cron job processing of the production version, in order avoiding two job processors running on the same database.
  
If you use different databases, make sure to use again the production database, when you deploy the application.

Deploy
======

  * Disable cron job processing.
  * Rename the current production directory to another name.
  * Rename the current testing directory to the name of production directory.
  * Make sure using the correct production database.
  * Use the correct read/write/ownership permissions for new production directory.
  * Test web-site.
  * Enable cron job processing.

##############
Configurations
##############

.. _main_configurations:

Main Configurations
===================

:file:`apps/asterisell/config/app.yml` contains the main configurations of Asterisell. Once they are properly configured, they rarely change.

The meaning of various settings are explained directly inside the file comments. Details of some settings will be explained in other tasks. Initially set only parameters of witch you are sure, leaving default values otherwise.

In order to make active the changes, you must execute :command:`./configure.sh`.

:ref:`main_configuration_file`.

.. _asterisell_owner:

Asterisell Owner Params
=======================

Use :menuselection:`Params --> Params --> Default` for defining the params of :term:`Asterisell owner`.

Web Site Appearances
====================

Logo, slogan, title, footer and similar aspects of the web-site can be customized directly from :ref:`asterisell_owner`. 

Web Site appearance can be further customized changing `apps/asterisell/templates/asterisell_layout.php` and `web/css` content.

.. _vendors_specification:

Vendors Specification
=====================

Use :menuselection:`Parties --> Customers / Vendors` for defining a :term:`VoIP vendor`. 

Use :menuselection:`Rates` for creating rates associated to the :term:`VoIP vendor`, calculating the cost of calls.

You can define one or more vendors, and you can use different vendors for different calls, associating cost rates to corresponding VoIP vendor.

Customers Specification
=======================

Use :menuselection:`Parties --> Customers / Vendors` for defining a :term:`customer`. 

Use :menuselection:`Parties --> Customer Offices` for defining one or more  :term:`customer office` associated to a customer.

Use :menuselection:`Parties --> VoIP Accounts` for defining one or more  :term:`VoIP account`, associated to an office.

The :term:`call report` will display office and account information only when they are relevant. They are not displayed in case of logged customers with only one office, or only one VoIP account. 

If a customer is not more active, disable the ``Is Active`` flag. Invoices associated to the customer will not generated.

.. _telephone_prefixes:

Telephone Prefixes in Call Report
=================================

The call report contains something like

+---------------+-----------+-------------+
|Tel.Tr.        | Location  | Connection  |
+===============+===========+=============+
|3932894234XXX	| Italy	    | Mobile Line |
|1707782466XXX  | USA       | Fixed Line  |
+---------------+-----------+-------------+

The table associates a `location` and a `connection type` to a telephone number.

This association is done inspecting the :menuselection:`Params --> Telephone Prefixes` table:
  * A prefix like "39" can be associated to a generic "Italian Operator".
  * A prefix like "393" can be associated to a generic (but more specific) "Mobile Italian Operator".
  * A prefix like "39328" can be associated to the specific "Wind Mobile Italian Operator".
  * A telephone number is associated to its more specific prefix. So "3944444" is associated to "Italian Operator", while "39344444" to "Mobile Italian Operator" and finally "393284444" to "Wind Mobile Italian Operator".

CDRs must be rerated again, in order to see the effects of changes in the table.

Telephone Prefix table is not used in rating process, but only in call report.

Initial Asterisell installation already load a complete list of standard world-wide prefixes. You can manually add custom prefixes associated to your specific settings.

The table can be completed also importing from a CSV file:
  * :menuselection:`Params --> Rates`.
  * Create a pseudo rate of type `CSV File with Tel.Prefixes and Rates`.
  * Set the rate according the format of the CSV file.
  * Make sure activating `Update also prefix table`.
  * Press `Save` button.
  * Note that in default settings, local numbers are stored internally in their complete form with the international prefix. Make sure that it is part of the table.
  * Delete the rate.
  * Check the prefix table.

.. _cdr_rating_process:

Rates
=====

Rates classify every :term:`CDR`, and associate a cost and an income to them.

Classification Rates
--------------------

A new :term:`CDR` starts with state unprocessed, and they are initially managed from :term:`classification rate`. They inspect mainly the amaflags and disposition fields where Asterisk server put billing hints/information. 

A classification rate classifies a call:
  * as ``outgoing``, if the call is made from the customer to an external telephone number;
  * as ``incoming``, it the call is from an external telephone number to the customer VoIP number;
  * as ``internal``, if the call is made from the customer to an internal VoIP account;
  * as ``ignore``, if the CDR can be ignored;

Telephone Number Normalizations
-------------------------------

Advanced CDR processing can be performed from customized ``classification rates``, that are usually created from developers according the specific needs of Asterisell instance. Some example of doable operations are:
  * recognition of complex patterns for local/mobile/interstate/intrastate telephone numbers;
  * ad-hoc formatting of telephone numbers according their type;
  * recognition of off-peak, peak or week-end calls, according the call-time;

These operations are performed by custom PHP code, so you must consult Asterisell assistance and support.

Ignored CDRs
------------

CDRs of type ``ignore`` are not further processed:
  * they are not displayed in the :term:`call report`;
  * they are not billed;
  * their fields can be in a bad format;

They remain in the :term:`CDR table`, but they are ignored.

Note that they are not deleted, and in case of change of the classification rate, usually during initial phase of Asterisell customized deployment, the ignored CDRs can be re-rated as all other CDRs, and in case they can become CDRs of other type, if the classification logic is changed. 


Internal CDRs
-------------

CDRs of type ``internal`` are calls between two local VoIP users. 

Usually they have no cost, so they are usually associated to rates saying their cost and income is simply 0.

They can be displayed or not displayed in the :term:`call report`, according the setting ``show_internal_calls`` in :ref:`main_configurations`. If they are not displayed in the call report, then they are also ignored during the invoice phase. The administrator views always all the type of calls, except ignored calls, because he must have a complete vision of CDR table content.

Incoming Calls
--------------

Incoming calls usually have no cost, so they are usually associated to rates saying their cost and income is simply 0.

They can be displayed or not displayed in the :term:`call report`, according the setting ``show_incoming_calls`` in :ref:`main_configurations`. If they are not displayed in the call report, then they are also ignored during the invoice phase. The administrator views always all the type of calls, except ignored calls, because he must have a complete vision of CDR table content.

Revenue Sharing
---------------

A call can have a negative cost. In this case you (as :term:`Asterisell owner`) are earning something for the call. There can be a revenue sharing between the :term:`VoIP vendor` and you (as :term:`Asterisell owner`). This can be the case for incoming calls for mobile telephone numbers.

A call can have a negative income. In this case there can be a revenue sharing between your customer and you.

Separate invoices can be created for revenue sharing, setting the ``Is Revenue Sharing`` field, during invoice generation. All the CDRs with negative incomes are part of revenue sharing invoices.

Normal Rates
------------

CDRs of type ``outgoing``, ``incoming``, ``internal`` are processed from ``normal rates``, for determining their cost and income.

Income rates are associated to the customers of a specific price category.

Cost rates are associated to a specific :term:`VoIP vendor`.

Rate Priorities
---------------

There can be one or more rates applicable to a CDR. It is always used the most specific rate. When there are doubts about which is the most specific rate, an error is generated, and the CDR remains unprocessed.

Every rate have a priority method. Two rates are comparable if they have the same priority method. If there are two rates applicable to the same CDR, but with two different priority method, an error is generated, because there is no way for determining what is the most specific rate.

Usually classification rates use destination channel as priority method, and normal rates the :term:`external telephone number`. 

For example given:
  * a rate ``A`` with the :term:`external telephone number` priority method, matching numbers like ``123``;
  * a rate ``B`` matching numbers like ``1234``;
  * a telephone number ``AA`` like ``12355555``;
  * a telephone number ``BB`` like ``12344444``;

then the rate ``A`` is the best match for ``AA``, while ``B`` is the best match for ``BB``.

A rate can have the ``exception`` field activated. They have a greater priority respect no exception rates. The most specific exception is selected, if there is any. This allows creating special rating rules, having priority methods different from other normal rates.

Price Categories
----------------

Income rates have a price category. They are applicable only to customers of the same price category. Example of price categories can be ``normal``, ``discounted``, ``reseller``.

Price categories must be assigned to every :term:`customer`, and optionally to :term:`customer office` when they are different from the price category of the owner customer, and optionally to :term:`VoIP account` when they are different from the price category of the owner office. The price categories are obviously specified inside :menuselection:`Parties --> Customers / Vendors`, :menuselection:`Parties --> Customer Offices`, and :menuselection:`Parties --> VoIP Accounts`.

Vendor Rates
------------

Vendors are typically identified by the ``dstchannel`` field of the :term:`CDR table`. This field is set from the Asterisk server and it identifies the channel used to route the call.

If you have different :term:`VoIP vendors<VoIP vendor>`, then you must specify different cost rates, associated to different ``dstchannels`` and :term:`VoIP vendors<VoIP vendor>`.

Rates Specified Using CSV Files
-------------------------------

CSV files are useful for specifying rates associated to :term:`external telephone number` according their initial prefix. A single CSV file can contain the rating parameters of thousands of telephone prefixes, and it can be managed from Asterisell and from :term:`Asterisell owner` in a lot more efficient way respect thousands of different rates.

Asterisell is shipped with a rather powerful rate, accepting a CSV file in many configurable formats. If it is not enough, it is possible :ref:`adding custom CSV based rates <asterisell_customizations>` following the format of the :term:`VoIP vendor`. This is an example of CSV content::

  "", "Mobile line" , "Afghanistan" ,  9375 , "0.1"
  "", "Mobile line" , "Afghanistan" ,  9377 , "0.1"
  "", "Mobile line" , "Afghanistan" ,  9378 , "0.1"
  "", "Mobile line" , "Afghanistan" ,  9379 , "0.1"
  "", "Fixed line" , "Albania" ,  355 , "0.1"
  "", "Mobile line" , "Albania" ,  35567 , "0.1"
  "", "Mobile line" , "Albania" ,  35568 , "0.1"
  "", "Mobile line" , "Albania" ,  35569 , "0.1"
  "", "Fixed line" , "Algeria" ,  213 , "0.1"
  "", "Mobile line" , "Algeria" ,  2136 , "0.1"
  "", "Mobile line" , "Algeria" ,  2137 , "0.1"
  "", "Mobile line" , "Algeria" ,  2139 , "0.1"  
  "", "Fixed line" , "Algeria [Wataniya]" ,  2135 , "0.1"
  "", "Fixed line" , "Algeria [Wataniya]" ,  21355 , "0.1"
  "", "Fixed line" , "American Samoa" ,  1684 , "0.1"
  "", "Fixed line" , "American Samoa" ,  684 , "0.1"
  "", "Mobile line" , "American Samoa" ,  1684252 , "0.1"
  "", "Mobile line" , "American Samoa" ,  1684254 , "0.1"

Up to date, there is no way in Asterisell for retrieving a loaded CSV file, again in his original format. So make sure having a copy somewhere of loaded CSV files.

Bundle Rates
------------

:term:`Bundle Rates <bundle rate>` can be used for specifying things like the minimum income, or line rental costs. They are associated to an invoicing period, and all the CDRs of this period, but not to any CDR in particular.


Invoicing
=========

Inside :ref:`main_configurations`, set the options:
  * ``invoice_date_format``
  * ``long_details_in_invoice``
  * ``use_inclusive_end_date_in_invoice``
  * ``currency``
  * ``currency_ascii_char``
  * ``currency_decimal_places_in_invoices``
  * ``culture``

Invoices are generated from the jobs:
  * ``GenerateInvoices``
  * ``GenerateInvoiceDetails``
  * ``GenerateInvoiceReportAsHTML``
  * ``GenerateInvoiceReportAsPDF``
  * ``GenerateCallReportAsPDF``
  * ``GenerateInvoiceEmail``
  * ``SendInvoiceEmails``
  * ``SendInvoiceEmail``
  * ``SendInvoiceNotificationToAccountant``

In case of invoices with a customized layout, you can substitute the job ``GenerateInvoiceReportAsPDF`` with another custom job.

Set :ref:`asterisell_owner` for setting invoice seller params.

Emails and invoices are generated using the culture specified in ``apps/asterisell/config/app.yml`` file.

Emails con be customized replacing the job ``GenerateInvoiceEmail``, with a custom job:
  * a new job like ``GenerateAcmeInvoiceEmail`` must be created;
  * the job must be added to ``jobs`` list, inside :ref:`main_configurations`, and the old ``GenerateInvoiceEmail`` must be removed;

Report about Calls
------------------

The job ``GenerateCallReportAsPDF`` generates a detailed call report about the type of calls:
  * 30 Most Expensive Outgoing Calls;
  * 30 Longest Duration Outgoing Calls;
  * 30 Most Frequently Dialled Numbers;
  * 30 Most Expensive Dialled Numbers;
  * calls ordered by destination type;

It can be sent to customers, in order show them how they used your services.

#####
Usage
#####

User Interface
==============

Filters
-------

All textual filters accessible from the administrator, require an ending ``*``. For example a filter like ``abc*``, select all the strings having ``abc`` as prefix.

Filters inside :term:`call report` add implicitly the ``*`` character to each search term, in order to simplify its usage for end users.

Online Help
-----------

Read carefully the notes of fields, and the comments at the bottom of each form.

Rating
======

Make sure understanding the :ref:`basics of CDRs rating process <cdr_rating_process>` before defining and changing rates.

Error in Rate Configurations
----------------------------

During rating process, Asterisell signals rate errors and conflicts. Rates are usually the most difficult thing to configure in Asterisell, so at least initially, errors are the norm.

Asterisell has a safe approach during rating: a :term:`CDR` is rated only if there is exactly one applicable classification rate, one cost rate, and one income rate, otherwise an error is signaled, and the CDR rating is postponed until rate configurations are fixed. So Asterisell prefers annoying the administrator with error-messages, than silently rating in the wrong way the VoIP calls. 

Error notifications contain hints about the solution of the problem, so read them carefully.

If properly configured, errors are notified to Asterisell administrator also by email:
  * job ``AdviseAdminOfNewProblems`` in :ref:`main_configurations` must be active;
  * ``Customers support email, and automatic problem notification email`` field in :ref:`asterisell_owner` must be specified; 

Unrated CDRs
~~~~~~~~~~~~

CDRs with problems are not displayed to customers, but they are only visible to administrators in the :menuselection:`Calls --> Unprocessed Calls` web form. Note that in this section there are also the few CDRs that were inserted in the CDR table, after the last cron-job processing job. After the next rating process, they will be moved to the :term:`call report`.

Examples of Problem Solution
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

An example of error notification:

  Description: No Rate to apply at date 2011-06-08 of type vendor (calculating a cost) on CDR with id ``11906``, and destination_type ``outgoing`` for customer of price category ``Normal`` for external telephone number ``0033631988888`` (with number portability applied it is ``0033631988888``), and for dstchannel ``SIP/abcd-12``.

  Effect: CDRs in the given rate interval will not be rated. 	

  Suggested Solution: Complete the rate table and wait for the next rate pass. Use menu entry Calls/Unprocessed Calls, for inspecting all details of unprocessed calls.

Its solution:
  * check all the active rates of type vendor, active at date 2011-06-08; 
  * check if they are applicable to the telephone number ``0033631988888``, and price category ``Normal``;
  * fix the rate for supporting also this type, or add a new rate;
  * delete the problems from the list;
  * re-rate old CDRs that can be affected by the changes in rates;
  * check if the error is signaled again in the error table;
  * note that errors generated during on-line rerating are not sent to the administrators emails, in order to reducing the number of sent emails during administration and maintenance work.

.. _cdr_rerating:

CDRs Re-rating
--------------

  * open :menuselection:`Calls --> Call Report`; 
  * select the time frame of CDRs you want re-rate;
  * note that other filters take no effect during re-rating, only the time-frame criteria;
  * click on `Re-rate Calls in Time-frame`;

Rates Updating
--------------

In Advance
~~~~~~~~~~

If your :term:`VoIP vendor` communicates you the changes of rates before they take effect, you can create the corresponding new rates, specifying the start date and time. They will be applied only to CDRs after the starting date. You must also set the ending date of current rates, because after the new rates are active, they must be disabled. 

This is the best way for updating the rates, because if you rerate CDRs, Asterisell can always apply the correct rate.

Current 
~~~~~~~~

If you update current rates, because there are errors, you must rerate current CDRs, otherwise the modified rates will be applied only to new inserted CDRs. CDRs are rerated :ref:`in this way<CDR_rerating>`.

Changing Customer Price Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Up to date customer price category has no start and end date, as in the case of rates. A customer has only one price category, and if you change it, it takes effect immediately. All new CDRs associated to the customer will be calculated according the new price category. If you want apply the price category also to old CDRs, you must rerate them :ref:`in this way<CDR_rerating>`.

A drawback of this approach it is that if you rerate old CDRs of the customer, they will be rated according the current price category, and not the price category when the CDRs were made. This is obviously a problem in Asterisell specification of price categories. In practice this problem it is not severe, because usually a customer changes his price category at the beginning of the new invoicing period, and rarely CDRs already billed are re-rated. So the typically way for changing price category, is rerating all the CDRs of the current month.

Invoices
========

Generation
----------

:menuselection:`Accounting --> Customer Invoices` for generating the invoice of a single customer.

:menuselection:`Accounting --> Batch Invoice Creation` for generating all invoices of active customers, of a specific billing period.

:menuselection:`Accounting --> Vendor Invoices` for generating the amount you owe to your :term:`VoIP vendor`, according the costs calculated from Asterisell. The generated pseudo invoices should correspond to the invoices received from vendors.

If you change the cost of calls already invoiced, then the invoice is not updated automatically. You can force a regeneration of an invoice using the ``Regenerate Invoice button`` which is displayed in the edit form of an invoice. It can be used also for batch invoices, and all invoices are simply updated. 

Sending Emails
--------------------------

Email is sent only if the ``Send email to customer`` button is pressed and the customer has an associated email. 

If there were a problem sending an email, then Asterisell signal the problem, and mark the invoice as not sent.

If SMTP params are left incomplete, then Asterisell will simply not send emails, and it does not consider this an error.

If SMTP params are not correct then Asterisell signal the problem inside problem table.


######################
Partners and Resellers
######################

.. _resellers:

Resellers
=========

A :term:`reseller` is a company selling VoIP calls to his customers, and where you play the role of his VoIP vendor. 

In case of resellers, there are two running instances of Asterisell:
  * your main instance;
  * reseller instance;

A reseller has distinct:
  * Asterisell website address;
  * Asterisell database;
  * customers;
  * rates;
  * invoices;

Usually a reseller uses your VoIP servers for managing the calls of his customers, and usually you install the Asterisell reseller instance on the same server of your main instance, but this is not mandatory.

License
-------

You need a separate license of Asterisell for each reseller.

Main Asterisell Instance Configuration
--------------------------------------

In your main Asterisell instance you must:
  * make sure that in `always_scheduled_jobs` of :ref:`main_configurations`, the job `ExportCDRToReseller` is active.
  * create a customer for the reseller;
  * enable the `Is Reseller` flag in the :menuselection:`Parties --> Customers / Vendors` form;
  * configure the `reseller short code`;

Usually resellers have also a reseller price category.

From now all the CDRs of VoIP accounts associated to the reseller will be exported to CSV files, and put inside the directory `cdr-exported-to-resellers/reseller-short-code`. The directory will be created automatically from Asterisell. The CSV files have name like `cdr-12345678.csv` where `123456789` is a unique and progressive number.

In case of installation of reseller and main instance on the same machine, make sure that the main instance export directory is readable and writable from the cron-job.

Supposing your reseller `Gold` has customer `Acme`, with VoIP account `acme001`:
  * you must enable VoIP account `acme01` on your VoIP server;
  * in Asterisell, you must create the VoIP account `acme01` associated to customer `Gold`;
  * you *must not* create customer `Acme` on your Asterisell instance;

So you don't know anything about the customers of your reseller, and the applied rates. You only know about the VoIP accounts you manage, and what a reseller must pay you for this service. 

Asterisell will produce a unique invoice with all the calls of the VoIP accounts associated to the reseller customer. This is the usual Asterisell work-flow, because a reseller is a normal customer inside Asterisell main instance. 

Reseller Instance Configuration
-------------------------------

  * Install Asterisell for the reseller.
  * Set `external_asterisell_voip_provider` options inside :ref:`main_configurations`. If the two instances are put on separated computers/network, you must create some script copying new CSV files in the main Asterisell instance, in a local directory of the reseller instance.
  * Make sure that in `always_scheduled_jobs`, the jobs `ImportCDRFromAsterisellProvider` and `CompareProviderCostWithCalculatedCost` are active.
  * Set vendor rates equal to the rates you apply to reseller on the main Asterisell instance. Note: CDRs imported on the reseller  instance will be checked, and the reseller will be informed if there is some difference between the cost of VoIP calls calculated from main  instance, and the cost calculated from reseller  instance, applying the vendor rates. 
  * Remove all classification rates, and add the `ProcessImportedCDR` classification rate. This rate recognizes CDRs imported from the main Asterisell instance.
  * Create initial customers, using the same VoIP accounts enabled on the main instance. Note: it is not important activating accounts first on reseller or first on main instance, because data will be not lost in any case.

Reseller instance will produce an invoice for each of his customers. This is the normal Asterisell work-flow, because every reseller customer, is a normal customer inside reseller instance.

Rerating of CDRs
----------------

If already exported CDRs will be rated again on the Asterisell main instance (for example after changing rates, or fixing errors), they will be exported again to the reseller, and reseller instance will update the old CDRs with new values, without creating duplicated/conflicting CDRs. 

So reseller instance can recognize and manage properly all events like:
  * a CDR changed cost/income;
  * a CDR changed VoIP account;
  * a CDR changed outgoing/incoming/internal state;
  * a CDR changed destination/source telephone number;
  * and so on..;

The only exception is in case of CDRs becoming :term:`ignored call` on the Asterisell main instance, after they were already sent as a different CDR type. In practice this is not a big problem because rules about CDRs to ignore, rarely change.

.. _partners:

Partners
========

A :term:`partner` is another company collaborating with you, that uses your same Asterisell instance, and the same VoIP server.

Partners can have distinct:
  * customers;
  * invoices;
  * login page;
  * web site logo, header, footer;
  * rates;

All partners have the same administrator privileges on the same Asterisell instance, so they can read and change all the data of other partners.

License
-------

On the contrary of resellers, partners can use both the same Asterisell license, because it is the same Asterisell instance.

Configuration
-------------

  * Create a partner on :menuselection:`Params --> Params`.
  * Associate customers to their partner.

Invoices
--------

Each customer invoice will use as seller the corresponding partner.

Custom Login Page
-----------------

After login a customer see always the logo, header and footers of his associated partner.

Before login it is not possible, because there is a unique Asterisell web address for each partner. So you must use a common header for all partners.

It is possible creating a custom login page, with a specific address, for each partner.. In :menuselection:`Params --> Params` web form, you can specify in `Login URN` a URL-friendly short name for the partner. Then the custom login page with the headers and footers of the partner is accessible on something like `https://www.example.com/partner-name`.
 
.. _main_configuration_file:

Main Configuration File Content
===============================

:file:`apps/asterisell/config/app.yml` 

.. literalinclude:: ../../apps/asterisell/config/app.yml

########
Glossary
########

.. glossary::
   :sorted:

   VoIP account
      A VoIP internal telephone number managed from the Asterisk server.
      It is an internal account code. Usually Asterisk VoIP server put it on the ``accountcode`` field of the :term:`CDR table`.
      Note: the Asterisk standard documentation pretends that this code is specified on a per-channel basis, but this is not the case in Asterisell configuration. So each accountcode has the same associated customer for every channel. This is also useful/practical in case of the same customer using different channels.

   customer office
      It identifies distinct physical locations, or distinct business units, of a :term:`customer`. It can have one or more :term:`VoIP accounts <VoIP account>`. 

   CDR table
      A MySQL table where the VoIP server put details about the VoIP calls. 

   CDR
     A call detail record of the :term:`CDR table`, containing all the details of a VoIP call.

   customer
      A party that uses the services of :term:`Asterisell owner` for making VoIP calls. He can have one or more :term:`customer offices <customer office>`.  
 
   partner
      A Partner is a company collaborating with you, that uses your same Asterisell instance for selling VoIP calls to his customers.

   reseller
     A Reseller is a company selling VoIP calls to his customers, and where you play the role of his :term:`VoIP vendor <VoIP vendor>`.

   Asterisell owner
      You: a company selling VoIP services to his :term:`customers <customer>`. It uses one or more :term:`VoIP vendors <VoIP vendor>`, and it can have optionally one or more :term:`partners<partner>`.

   VoIP vendor
      A company that can route VoIP calls to destination end-points, typically traditional telephone networks. It is used from the :term:`Asterisell owner` for routing the VoIP calls.

   call report
      The web page displaying all the VoIP calls, and related data to administrator or to end users. It displays specialized information according the type of logged user.

   internal telephone number
      It is the :term:`VoIP account` code. In case of :term:`outgoing call`, it is the source of the call. In case of :term:`incoming call`, it is the destination of the call.

   external telephone number
      It is the number residing on external lines, reachable using the services of the :term:`VoIP vendor`. In case of :term:`outgoing call`, it is the destination of the call. In case of :term:`incoming call`, it is the source of the call.

   incoming call
      A call coming from a telephone network not directly managed from you, and having one of your customer :term:`VoIP account` as destination. 

   outgoing call 
     A call directed to a telephone network not directly managed from you, and having one of your customer :term:`VoIP account` as source of the call.

   internal call
     A call inside a telephone network directly managed from you. The call source and destination are usually both associated to your customers.

   ignored call
     A call that has no income, cost, and that is not displayed in the :term:`call report`. It can be completely ignored. 

   classification rate
     A rate that classifies the :term:`CDR` as :term:`outgoing call`, or :term:`incoming call`, or :term:`internal call`, or :term:`ignored call`.

   income rate
     A rate that assigns the income of the :term:`CDR`, that is what the :term:`customer` must pay for it.

   cost rate
     A rate that assigns the cost of the :term:`CDR`, that is what you (the :term:`Asterisell owner`) must pay to another :term:`VoIP vendor` for routing the calls.

   bundle rate
     A rate associated to the set of CDRs of the invoicing period, as the minimum income, or line rentals.
