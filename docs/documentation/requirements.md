# EasyDocs/app/classes/requirements.php
---
This class is used to handle all of the requirements needed to install EasyDocs.
## Usage
---
```php
$req = new Requirements();
//or
$req = new chx2\Requirements();
```
## Class Variables
---
```php
protected $required; # array
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct()
```
* Runs when the class is instantiated. Tries to set the required array values individually based upon each requirement.
---
# 
```php
$req->check();
```
* Checks the requirements. Calls the fail function if a requirement is not met.
# 
---
# 
```php
$req->fail($message);
```
* Stops the program and alerts the user that a requirement is not met.
