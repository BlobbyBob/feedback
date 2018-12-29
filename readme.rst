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
  PHP version ``>= 7.1`` is required. While Feedback may work on lower versions, it has **not been tested** on these versions, which may result in unexpected behaviour. In addition PHP 7 offers huge advantages `especially in comparison to PHP 5.x <https://visualmodo.com/why-you-should-be-using-php-7-2/>`_. There are no reasons to be still sticking with PHP 5.x.
PHP Extensions
  Currently Feedback uses three PHP extensions: ``json`` should be installed on most systems, while ``fileinfo`` and ``openssl`` might have to be added seperately.
Database
  Feedback can use any Database Management System, where a PDO Driver exists. While the Setup-Scripts for the databases are currently only available in the MySQL dialect, it should be no problem to convert them to another dialect. For the future a dialect independent database setup script is planned.

~~~~~
Setup
~~~~~

Default: user - masterpass

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
