# EasyDocs/app/classes/tool.php
---
This class is used as a misc. tool package to help with the back-end of EasyDocs.
## Usage
---
```php
$tool = new Tool();
//or
$tool = new chx2\Tool();
```
## Class Variables
---
```php
protected $action;
public $list;
public $data;
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($list = array(),$action = null)
```
* Runs when the class is instantiated. Tries to set the class variables if they are contained within the GET/POST array.
# 
---
# 
```php
$tool->run();
```
* Runs the function that is specified by the $action variable.
# 
---
# 
```php
$tool->cache();
```
* Clears the cache.
# 
---
# 
```php
$tool->export();
```
* Exports the requested sections as a combined zip file.
# 
---
# 
```php
$tool->scan();
```
* Repopulates the document list.
# 
---
# 
```php
$tool->tree();
```
* Maps the entire EasyDocs directory as an array.