Inventory Management System

PROJECT OVERVIEW

We have been asked to create an Inventory-Management System which will be able to handle multiple branches. 
Monitor inventory and stock level also generate reports weekly as well as issue invoices for in-store purchases.
This system will be only accessible to the employees and admins of the branch.



BUILD INSTRUCTIONS

The Project is created using PHP and JavaScript programming languages. 
To build the project you need to download and set up XAMPP.
Run XAMPP and start APACHE. 
Download the project from Github Repository from the given access link to the xampp/htdocs/terracore.
In your web browser go to the page " localhost/terracore/view/login/login.php ".


######## Login info ########

__________________________________________________________________
| Email                     | Password | Role          | Role ID |
==================================================================
| lhattersley@terracore.com |   1234   | Employee      |    1    |
------------------------------------------------------------------
| cstarling@terracore.com   |   1234   | Stock Manager |    2    |
------------------------------------------------------------------
| mobrycki@terracore.com    |   1234   | Manager       |    3    |
------------------------------------------------------------------
| skovacs@terracore.com     |   1234   | Director      |    4    |
------------------------------------------------------------------
| jfrancois@terracore.com   |   1234   | Admin         |    5    |
------------------------------------------------------------------

Manager:
===========
[|] Employee Details
[|] Branch Report
[|] Previous Reports
[x] Sign Out

Director: 
===========
[] Dashboard
[] Reports
[x] Sign Out


EMPLOYEE:
==========
[|] New Sale
[|] Stock
[x] Sign Out

ADMIN:
==========
[|] Access Users
[|] Create New User
[|] Branches
[x] Sign Out

Stock Manager:
==============
[|] Stock View
[|] Add New Product
[|] Orders
[x] Sign Out

TESTING

As the project is not using any classes and little number of functions Unit Testing was not needed.
To view all the tests please relate to the project's documentation.
