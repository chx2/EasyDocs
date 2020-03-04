# EasyDocs/app/classes/settings.php
---
This class is used to handle all user settings within the EasyDocs application.
## Usage
---
```php
$settings = new Settings();
//or
$settings = new chx2\Settings();
```
## Class Variables
---
```php
public $data;
public $file;
public $list;
```
## Session Variables
---
```php
$_SESSION['success']; # string
$_SESSION['error']; # string
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($settings)
```
* Runs when the class is instantiated. Tries to set the class variables if they are contained within the GET/POST array. This function calls many of the class methods internally, as well as writing the configuration to the config.yaml file.
# 
---
# 
```php
$settings->addTheme();
```
* This function is responsible for adding a theme that the user uploads. It will only work with ZIP archives. Extracts the ZIP contents in the theme directory.
# 
---
# 
```php
$settings->updateTheme();
```
* Updates the theme to the user-selected one.
# 
---
# 
```php
$settings->addUser();
```
* Adds a user. Is called internally in the constructor.
# 
---
# 
```php
$settings->deleteUser();
```
* Deletes a user.
# 
---
# 
```php
$settings->updatePrivate(bool $switch)
```
* Toggles the "private" option to have documents set to private.
