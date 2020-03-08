# EasyDocs/app/classes/sorter.php
---
This class is used to handle the sorting of section items in EasyDocs.
## Usage
---
```php
$sorter = new Sorter();
//or
$sorter = new chx2\Sorter();
```
## Class Variables
---
```php
public $list;
public $sorted;
private $key;
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($list)
```
* Runs when the class is instantiated. Tries to set the class variables if they are contained within the GET/POST array.
# 
---
# 
```php
$sorter->sort();
```
* Sorts section items.
# 
---
# 
```php
$sorter->escapeWalk();
```
* Called internally in the constructor. Escapes the document array post. Used for security reasons.