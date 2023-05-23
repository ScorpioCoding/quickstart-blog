# QuickStart

Is a small and robust Dockerized Modular Php Mvc Framework

## How to use

Using the terminal:  
-git clone the App  
-init the gulpfiles  
-run the dockerfiles  
-run the gulpfiles  
-mod the dev files to one's desires

All development is done in the dev folder and by running the command `gulp`
changes will be made to the html directory.

When putting it live just transfer the dockerfiles and the html directory

## Dockerfiles

-The main App is run on port http://localhost:6080.  
-The database port for direct access is on port 6086.  
-The database php MyAdmin is on port 6084.

## GulpFiles

-Start by running the command `npm install` to create the node_modules folder.  
-To run the gulpfiles use the commmand `gulp`

## Makefile

-Is a file with most used Docker Compose commands.  
-You can find more info at https://makefiletutorial.com  
-`Make help` will sho you the list of commands created.
