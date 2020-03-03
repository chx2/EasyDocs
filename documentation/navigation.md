# EasyDocs/app/classes/navigation.php
---
This class is used to handle user navigation in EasyDocs.
## Usage
---
```php
$nav = new Navigation();
//or
$nav = new chx2\Navigation();
```
## Class Variables
---
```php
public $tree;
public $navigation;
private $section;
private $document;
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($tree, $section = '', $document = '')
```
* Runs when the class is instantiated. Tries to set the class variables if they are contained within the GET/POST array. 
# 
---
# 
```php
$nav->branch();
```
* Builds the navigation of the application.
