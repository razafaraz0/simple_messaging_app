# Simple Messaging App
The aim of the following project was to create a simple chat applicaiton. The Implementation of the  Project was done using the following technology

## Requirements
The technologies I worked with:
- PHP 7.3
- SQLite 3.28
- Slim 4 Framework

## How to Start?
To first run this application, we need to install the required dependencies using the command :

```jshelllanguage
$ composer install
```

Now run the command

```jshelllanguage
$ composer run-messenger
```
PHP server is now running on `localhost:3000`.

## Routes
Routes are defined in **config\routes.php**.


## Database
The Schema used to create the sqllite3 database:
```
CREATE TABLE usersTable (
    userId INTEGER PRIMARY KEY AUTOINCREMENT,
    userName VARCHAR NOT NULL UNIQUE
);

CREATE TABLE messagesTable (
    messageContent VARCHAR NOT NULL,
    messageSender VARCHAR NOT NULL,
    messageReciever VARCHAR NOT NULL,
    messageID INTEGER PRIMARY KEY AUTOINCREMENT,
    FOREIGN KEY (messageSender) REFERENCES usersTable (userName),
    FOREIGN KEY (messageReciever) REFERENCES usersTable (userName)
);

```

## Implementation

The entry point for this project is the public/*index.php*. This */public* will also act as a security feature as only this directory will be accessible by all browsers, search engines, and API clients. All other folders are not public and will not be accessible online.  Below are the folders of the application:

   ### Config

   This Folder contains all the configurations of the applications and related services. It should also be noted that since we are using the **Slim 4** framework, all middleware, routing, and dependency injections are handled by it.

   ### Action
   This class receives the request from the routes. They then parse the data and forward it to the relevant functions in the **Service** folder.

   ### Domain
   The **Domain** folder contains the files that handle the complex business use-cases. To reduce complexity even further, this directory also includes subdirectories called **User** and **Message** to cater to individual stakeholders

   #### Data
   DataBase Objects are defined here.

   #### Repository
   The following folder is responsible to manage the  communication between the databases with the data logic.

   #### Service
   These take input from the `Action`, deal with the repository, create a Data object, and return it back to the `Action`. In short, they deal with all the business logic.

   ### Middleware
   This Folder includes handling exceptions thrown by the application.

   ### Response
   Includes appropirate response.


## Tests Conducted
Tests are an integral part of an application to be successful. For this, I conducted many tests. These test cases are in the **tests/TestCase** folder. To run the tests enter the command: 

```jshelllanguage
$ composer test
```
After running this command we will see a total of 16 tests were condcuted with 36 assertions.


## API Request

The following tests where conducted using **Postman**

### 1) [POST] localhost:3000/addUser 
Request:
```
{
	"userName":"jill"
}
```
Response:
```
{
    "data": {
        "userID": 17,
        "userName": "jill"
    }
}
```

### 2) [POST] localhost:3000/sendMessage
Request:
```
{
	"messageSender":"jill_1",
	"messageReciever":"jill_2",
	"messageContent":"Hello from my side"
}
```
Response:
```
{
    "data": {
        "messageSender": "jill_1",
        "messageReciever": "jill_2",
        "messageContent": "Hello from my side"
    }
}
```

### 3) [GET] localhost:3000/getMessages/{RECIPIENT} 
**Note** {RECIPIENT}:
```
jill_2
```
Response:
```
{
    "data": [
        {
            "messageSender": "jill_1",
            "messageReciever": "jill_2",
            "messageContent": "Hello from my side"
        },
        {
            "messageSender": "jill_1",
            "messageReciever": "jill_2",
            "messageContent": "Are you doing good?"
        }
    ]
}
```

## Now We will on incorrect values

### 1) [POST] localhost:3000/addUser 
If 'userName' is spelled incorrectly or is missing:

Request:
```
{
	"userName":"jill"
}
```

**OR** 

```
{
	"userName":""
}
```

Response:
```
{
    "errorType": "Incorrect Parameters",
    "description": "Incorrect input `userName`. given"
}
```

### 2) [POST] localhost:3000/sendMessage

On missing or incorrect field. Lets try ommiting the 'messageContent':

Request:
```
{
	"messageSender":"jill_1",
	"messageReciever":"jill_2",
}
```
Response:
```
{
    "errorType": "Incorrect Parameters",
    "description": "Incorrect Input `sender`. given"
}
```

### 4) [GET] localhost:3000/getMessages/{RECIPIENT} 
**Note** {RECIPIENT} = null 

On missing recipent
Response:
```
{
    "errorType": "Resource Not Found",
    "description": "Not found."
}
```

## Resources  used

1. [To understand the basics of Slim 4 Framework](https://odan.github.io/2019/11/05/slim4-tutorial.html)
2. [To understand how to conducet testing using Slims4](https://odan.github.io/slim4-skeleton/testing.html)

## Author
**RAZA FARAZ**