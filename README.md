# VRE etalk


## Summary
This application is used by the VRE application (see https://gitlab.isb-sib.ch/mark16-vre-group/vre).

The main directories are :

- conf : configuration directory. The file "_app.conf_TEMPLATE.php" is a template for As this file is not managed by Git, it must be created directly on the server. 
- htdocs : the application root.
 
## How to install

- Pull this repository 
- Create the MySQL database 
- Run the DDL script  
- Create 2 directories under htdocs : data and tmp.
- Create a file "conf/_app.conf.php" on the model of "conf/_app.conf_TEMPLATE.php", and edit the DB credentials according the database configuration.
  
## How to use

- Create new folder to open a new series
- Use /edit/ menu to edit etalks