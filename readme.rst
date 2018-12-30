################
What is Feedback
################

**Feedback** is a survey management system. It was intentionally developed for gathering feedback from participants of a climbing gym, but can be modified to serve different use cases. Since the main focus of development is **Usability** even people with limited technical knowledge should be able to use and administrate it (once it has been set up correctly).

************
Installation
************

~~~~~~~~~~~~
Requirements
~~~~~~~~~~~~

PHP
  PHP version ``>= 7.2`` is required. While Feedback may work on lower versions, it has **not been tested** on these versions, which may result in unexpected behaviour. On PHP ``5.x`` it will definitely
PHP Extensions
  Currently Feedback uses three PHP extensions: ``json`` should be installed on most systems, while ``fileinfo`` and ``openssl`` might have to be added seperately.
Database
  Feedback can use any Database Management System, where a PDO Driver exists. While the setup scripts for the databases are currently only available in the MySQL dialect, it should be no problem to convert them to another dialect. Problematic can also be a handful of queries, that don't utilize the Query Builder and that may use MySQL exclusive syntax. For the future a dialect independent database setup script is planned.

~~~~~
Setup
~~~~~

The only possibility to install the project at the moment is by using Git and cloning the repository (or downloading and extracting it from GitHub).

``git clone https://github.com/BlobbyBob/feedback.git <folder>``

Afterwards you have to install all the dependencies using `Composer <https://getcomposer.org>`_.
If you simply want to experiment a bit with Feedback, it is recommended to add the parameter ``--dev`` to the following command. If you are on a production server, it is recommended to add ``--no-dev``.

``composer update``

Since an official installation script is currently in development, there are 3 manual installation steps to perform:

1. Open the file ``applications/config/database.sample.php`` to configure the database connection. Afterwards rename the file into ``database.php``

2. Open the file ``applications/config/config.sample.php`` and set your base url. Afterwards rename the file into ``config.php``

3. Run the ``setup.sql`` script in your database. If you want to use a prefix for the tables, you will have to add them manually.

By now you should be ready to go. The default user ``admin`` has the default password ``masterpass``.

*Note*: Feedback uses `CodeIgniter <https://codeigniter.com>`_, a popular MVC framework. There are many configuration options that you can change according to your needs. Check out the official `CodeIgniter user guide <https://www.codeigniter.com/user_guide/>`_ for information on all possibilities.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.
