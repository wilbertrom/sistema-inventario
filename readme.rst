###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

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

Please see the `installation section <https://codeigniter.com/userguide3/installation/index.html>`_
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
-  `Contributing Guide <https://github.com/bcit-ci/CodeIgniter/blob/develop/contributing.md>`_
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

***************
CONFIGURACIÓN
***************
0. **Crea una la carpeta sistemaInventario en xampp/htdocs**
    Abre la carpeta en vscode y abre una terminal (ctrl + ñ)
    ejecuta el comando:
    :: 
        git clone https://github.com/octabau02/Sistema-Inventario.git
    ::
        
1. **Ve al archivo de la carpeta** ``Application/config/database.php``

   Haz cambios en la base de datos (en el puerto ``:3306``).

2. **Importaciones para la base de datos**:

   Comando para la creación de la base de datos:
   ::

      CREATE DATABASE sistemainv CHARACTER SET utf8 COLLATE utf8_general_ci;

   Comando para crear el usuario:
   ::

      GRANT ALL PRIVILEGES ON sistemainv.* TO 'sistemainvuser'@'localhost' IDENTIFIED BY 'Sistemainvuser27_' WITH GRANT OPTION;

   Comando para seleccionar la base de datos:
   ::

      USE sistemainv;

3. **Importar base de datos desde fuera de sesión MySQL**:
   ::

      mysql -u root -p sistemainv < ruta\lastdb.sql (arrastra el archivo )

4. **Ve al archivo de la carpeta** ``application/DBMigrations/lastdb.sql``



