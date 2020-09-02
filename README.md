# bunq-backend-test
Backend Engineer Home Assignment for Bunq

## Requirements
The technologies I worked with:
- PHP 7.3.11
- SQLite 3.28.0
- **[Composer](https://getcomposer.org/)**
- **[Slim 4](http://www.slimframework.com)**

## Setup
You should aleady have Composer installed on your computer. You should then navigate to it's root directory and run:

```jshelllanguage
$ composer install
$ composer chat
```
This will install all the dependencies and fire up the PHP server on `localhost:8000`.

## Architecture

The entry point for this project is *index.php*. From here we enter the bootstrap file, which takes configurations from the settings, routing, and middleware files to configure the entire project. The PHP micro framework **Slim** handles dependency injection, routing, and the middleware. Exception handling is also done in the middleware. In the **src** folder, the **Action**, **Domain**, **Middleware**, and **Response** folders hold modular parts of the source code.

### Action
These are the first entry points after the framework recives HTTP requests. There is a `BaseAction` class, which is the parent of three other classes, each of which implements the functionality of one route. An Action class recieves the request, parses the data, calls the appropriate function from the relevant service, and returns the result in HTTP format. 

### Domain
Each subfolder contains a pair of files, one to handle User business logic and the other for Message business logic.

#### Data
These are code representations of the database objects.

#### Repository
These contain code used to communicate SQL queries to the database.

#### Service
These take input from the `Action`, deal with the repository, create a Data object, and return it back to the `Action`. In short, they deal with all the business logic.

### Middleware
The only custom middleware defined for this project is for handling exceptions thrown by the app (in case of wrongly-named parameters, database errors, etc). These errors are caught and then returned as valid HTTP responses as well, so as not to break the app.

### Response
The JSON formatted payload which is returned both for valid HTTP responses, and caught-exception responses.

### Database
Defined in the **db** folder, as the *chat_app_database.sl3* file. It can be easily recreated by navigating to the directory, deleting the file, and running:
```jshelllanguage
sqlite3 chat_app_database.sl3
```

This will enter the SQL command line. Here, enter:
```
CREATE TABLE users (
id INTEGER PRIMARY KEY AUTOINCREMENT,
username VARCHAR UNIQUE NOT NULL
);

CREATE TABLE messages (
id INTEGER PRIMARY KEY AUTOINCREMENT,
sender VARCHAR,
recipient VARCHAR,
body TEXT NOT NULL,
time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (sender) REFERENCES users (username),
FOREIGN KEY (recipient) REFERENCES users (username)
);
```
This will defined the database tables.

## Tests
These are in the **tests/TestCase** folder, organized by their locations in the **src** folder. There are a total of 13 tests with 29 assertions. They can be run using:

```jshelllanguage
$ composer test
```

## The API
These routes are defined in `routes.php`.

### localhost:8000/user [POST]
Request:
```
{
	"username":"nimo"
}
```
Response:
```
{
    "data": {
        "id": 14,
        "username": "nimo"
    }
}
```
Error on missing username or misspelled `username` key:
```
{
    "errorType": "Incorrect Parameters",
    "description": "Could not find parameter `username`. Please check your input"
}
```

### localhost:8000/message [POST]
Request:
```
{
	"sender":"nimo",
	"recipient":"omin",
	"body":"opposite day"
}
```
Response:
```
{
    "data": {
        "sender": "nimo",
        "recipient": "omin",
        "body": "opposite day"
    }
}
```
Error on missing field or misspelled field (in this case `sender`) key:
```
{
    "errorType": "Incorrect Parameters",
    "description": "Could not find parameter `sender`. Please check your input"
}
```

### localhost:8000/messages/{RECIPIENT} [GET]
{RECIPIENT}:
```
omin
```
Response:
```
{
    "data": [
        {
            "sender": "nimo",
            "recipient": "omin",
            "body": "opposite day"
        }
    ]
}
```
Error on empty `{RECIPIENT}`:
```
{
    "errorType": "Resource Not Found",
    "description": "Not found."
}
```

## Note
When I started this project I knew nothing about Slim 4. I noticed the GitHub user [odan](https://github.com/odan) had answered a lot of questions across the internet and found three incredibly useful blog posts by him. 
1. [Slim 4 - Tutorial](https://odan.github.io/2019/11/05/slim4-tutorial.html)
2. [Slim 4 - PHP - DI](https://odan.github.io/2020/05/24/slim4-php-di.html)
3. [Testing](https://odan.github.io/slim4-skeleton/testing.html)

It would have been much harder to do this without him and his posts helped me a lot with designing the architecture and creating a separation of concerns. I just wanted to leave my resources here as a reference and to cite his work.