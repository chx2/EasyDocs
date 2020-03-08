# EasyDocs/app/classes/authentication.php
---
This class is used to Authenticate users and log them into EasyDocs. It has support for normal users and administrative users. See below for usage and function definitions.
## Usage
---
```php
$auth = new Authentication();
//or
$auth = new chx2\Authentication();
```
## Protected Class Variables
---
```php
protected $admin;
protected $user;
protected $valid_user;
protected $valid_pass;
```
## Session Variables
---
```php
$_SESSION['logged_in']; #boolean
$_SESSION['logged_user']; #boolean
$_SESSION['error']; #string
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($input)
```
* Runs when the class is instantiated. Sets the $admin and $user variables if they are present in the session.
# 
---
# 
```php
$auth->login();
```
* Use this function to login an admin. It will first check to see if a username and password was passed with the request.
Then it will set the logged_in session variable and bring the user to the admin dashboard.
# 
---
# 
```php
$auth->isLoggedIn();
```
* Returns the logged_in session variable which will be true if the user is logged in, false if they are not.
# 
---
# 
```php
$auth->loginUser();
```
* Use this function to login a normal user. It will first check to see if a username and password was passed with the request.
Then it will set the logged_in session variable and bring the user to the home page.
# 
---
# 
```php
$auth->isUser();
```
* Use this function to check if a user exists. Returns true if they do and false if not.
# 
---
# 
```php
$auth->isLoggedUser();
```
* Returns true if the logged_user session variable is set, and false if it is not.
# 
---
# 
```php
$auth->LoggedIn();
```
* Navigates the page to the dashboard.
# 
---
# 
```php
$auth->NotLoggedIn();
```
* Sets the error session variable to 'You are not logged in' and navigates the page to the login.
# 
---
# 
```php
$auth->logout();
```
* Logs the user out by destroying their session and redirecting them to the login page.
# 
---
# 
```php
$auth->isPreview();
```
* Checks to see if an admin user is in "preview" mode. Returns true if they are and false if not.