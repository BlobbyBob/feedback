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

By now you should be ready to go. Open the page in your browser and log in with the default user ``admin`` and the password ``masterpass``.

*Note*: Feedback uses `CodeIgniter <https://codeigniter.com>`_, a popular MVC framework. There are many configuration options that you can change according to your needs. Check out the official `CodeIgniter user guide <https://www.codeigniter.com/user_guide/>`_ for information on all possibilities.

******
Issues
******

Feedback uses the GitHub `issue tracker <https://github.com/BlobbyBob/feedback/issues>`_. If you file a new issue, please make sure to follow these guidelines.

A good issue
  is **formatted**. Use some `Markdown <https://guides.github.com/features/mastering-markdown/>`_ and some basic text structure (headings and paragraphs), so developers don't have to spend too long understanding your issue.
A good issue
  is **self-explaining**. When you file an issue consisting of only a title or one short sentence, it is hard to understand what you want. Make sure to include enough information (for example *situation right now*, *proposed change*, *possible fix*). Ideally the developer understands what you mean and there won't be any further questions.
A good issue
  uses **tags**. Tags are an easy way to save the developers some time, without needing to understand the code and how to modify it yourself.
A good issue
  is **orthographically correct**. Everyone makes typos but a typo every other word is pretty hard to read. Make sure to read your issue one more time, when you're done writing and before submitting.

Currently you can file issues about the following topics:

Bugs
  Please include a detailed description how to reproduce the bug and what the expected behaviour is.
Feature Request
  Please include a detailed description, what you expect your new feature to do and why it is useful.
Bad Coding
  Sadly developers are no gods and make mistakes or stupid decisions some times. Please include a detailed description on how which part of the code base could be improved.
Question
  You can also use the issues, in case you have question about the project. Please be specific though - developers are always short on time.

************
Contributing
************

Feedback is an open source project and encourages participation.
You can participate by creating new `issues <https://github.com/BlobbyBob/feedback/issues>`_ or `pull requests <https://github.com/BlobbyBob/feedback/pulls>`_.
If you should have particular interest in building and mainting the (nonexistent) Wiki, you can contribute these content through issues in the beginning.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the ``CHANGELOG.md`` file. Version numbers work according to `Semantic versioning <https://semver.org/>`_.

*******
License
*******

Feedback is published under the terms of the `GNU Public License v3 (GPLv3) <https://github.com/BlobbyBob/feedback/blob/master/LICENSE>`_.
Compared to other licenses, the GPLv3 is a strong copyleft license and requires forked projects to be published under the same license (and thus open source).

*************
Used Software
*************

Feedback uses some libraries. Currently the following software is used:

*  `CodeIgniter <https://codeigniter.com>`_ (MIT license)
*  `Bootstrap <https://getbootstrap.com/>`_ (MIT license)
*  `Chartist <https://gionkunz.github.io/chartist-js/>`_ (WTF Public License)
*  `BootAdmin <https://bootadmin.net/>`_ (MIT license)
*  `DataTables <https://www.datatables.net/>`_ (MIT license)
*  `html5sortable <https://lukasoppermann.github.io/html5sortable/index.html>`_ (MIT license)
*  `Moment.js <https://momentjs.com/>`_ (MIT license)
