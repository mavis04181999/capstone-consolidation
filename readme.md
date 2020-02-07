ReadME.md

	The Event Evaluation System (EES) was integrated with Centralized Event Management System (CEMS) the two system must deploy on one server.

install the following programs:
- editor vscode / sublime.
- xampp windows installer php v.7.2^.
- search engine: google chrome (recommended), firefox.

procedure to run the programs:
- after installing the following programs open the xampp and run Apache and MySql Server.
- move the two web application on htdocs (ex. c://xampp/htdocs/).
- on search engine redirect to localhost/phpmyadmin and create a database name cems_db for CEMS import the database sql file name cems_db.sql on the cems_db web application folder.
- on the other hand for EES open cmd terminal then move to the EES web application address by typing cd "address of the EES web application" (ex. cd c://xampp/htdocs/capstone-consolidation).
- then run this command "php artisan migrate" that will migrate all the database on the MySql Server.
- redirect to the localhost/phpmyadmin and check the capstone-consolidation database, open the database and open the users table go to import and import the file users.csv on the (capstone-consolidation csv folder).
- it will create the superadmin account:
	username: admin
	password: janedoe123
- on the cmd terminal again run "php artisan serve" it will start a laravel local development server
- hit the localhost:8000 on your search engine and sign in the superadmin account.
- the EES together with CEMS web application are both ready.
