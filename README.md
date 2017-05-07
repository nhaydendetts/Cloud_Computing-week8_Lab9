# Cloud_Computing-week8_Lab9
PHP Rest App for Week 8, Lab 9 Assignment for Cloud Computing

The index.php in this repository provides a REST interface that allows a user to Select All, Select One, Create, Update or Delete a contact in a contact database. (Note the the documentation assumes that "indext.php" will serve as the default document for the root folder of your PHP enabled server.

In order for this interface to work, the following constant values must be set up within the Index.php file:
$host="<ADDRESS of DataBase>"; #The host address of the DB 
$dbuser="root"; #The DB username
$dbpass="XXXX"; #The DB password
$db="DataBaseName"; #The DataBase to use
$table="TableName"; #The table name to use

If the DB or Table do not exist on the MySQL database provided by the $host variable, the code with set up the proper database and table as needed.

Once the database is set up and the index.php placed in a PHP enabled server folder, you can run the REST functions as detailed below:

SELECT ALL (default action) - Selects and returns all fields for all contacts in the database as JSON object
Call URL: curl SERVER_ADDRESS/?op=fetch
PARAMETERS:
op: Expected Value: fetch  <REQUIRED>
RETURNS:
JSON object of all fields for all contacts in the database or error message

SELECT ONE - Selects and returns one contact that matches the provided email address as JSON object
Call URL: curl SERVER_ADDRESS/?op=fetch&email=email@email.com
PARAMETERS:
op: Expected Value: fetch <REQUIRED>
email: Expected Value: email address of contact you are selecting <REQUIRED>
RETURNS:
JSON object of all fields for selected contact in the database or error message

CREATE - Creates new contact record based on provided: Firstname, Lastname, Age, Email, and Zipcode. Returns a confirmation message of success or failure
Call URL: curl SERVER_ADDRESS/?op=create&email=email@email.com&fname=FirstName&lname=LastName&age=Age&zip=Zipcode
PARAMETERS:
op: Expected Value: create <REQUIRED>
email: Expected Value: email address of contact you are creating <REQUIRED>
fname: Expected Value: New contact first name <REQUIRED>
lname: Expected Value: New contact last name <REQUIRED>
age: Expected Value: New contact age (as numeric: i.e. 24) <REQUIRED>
zip: Expected Value: New contact zip code <REQUIRED>
RETURNS:
Confirmation JSON object or error message

UPDATE - Updates a contact record based on provided: Email, [Firstname, Lastname, Age, and Zipcode]. Returns a confirmation message of success or failure
Call URL: curl SERVER_ADDRESS/?op=update&email=email@email.com&fname=FirstName&lname=LastName&age=Age&zip=Zipcode
PARAMETERS:
op: Expected Value: update <REQUIRED>
email: Expected Value: email address of contact you are updating <REQUIRED>
fname: Expected Value: New contact first name <OPTIONAL>
lname: Expected Value: New contact last name <OPTIONAL>
age: Expected Value: New contact age (as numeric: i.e. 24) <OPTIONAL>
zip: Expected Value: New contact zip code <OPTIONAL>
RETURNS:
Confirmation JSON object or error message


REMOVE - Removes a contact record based on provided: Email. Returns a confirmation message of success or failure
Call URL: curl SERVER_ADDRESS/?op=remove&email=email@email.com
PARAMETERS:
op: Expected Value: update <REQUIRED>
email: Expected Value: email address of contact you are updating <REQUIRED>
RETURNS:
Confirmation JSON object or error message
