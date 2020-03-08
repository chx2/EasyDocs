# EasyDocs/app/classes/docmaker.php
---
This class is used to create, update, modify, or delete markdown documents within the EasyDocs application. EasyDocs groups markdown documents in units called "sections". Both sections and markdown document names can be modified by the users.
## Usage
---
```php
$docmaker = new DocMaker();
//or
$docmaker = new chx2\DocMaker();
```
## Class Variables
---
```php
  public $list;
  public $docname; # the name of the document
  public $old_section; # for when the user renames a section
  public $old_name; # for when the user renames the document
  public $section; # the section the document is in
  public $content; # the content of the document
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
public function __construct($list)
```
* Runs when the class is instantiated. Tries to set the class variables if they are contained within the GET/POST array. 
# 
---
# 
```php
$docmaker->isSection();
```
* Returns true if the section exists. Will return false if there is a in the section document with the same name as the secion.
# 
---
# 
```php
$docmaker->addSection();
```
* Used to make a new section. Will not work if they section already exists, of if there are insufficient file permissions on the docs/ directory. If not it will create the section and notify the user.
# 
---
# 
```php
$docmaker->getContent();
```
* Gets the content of the document. This is called internally in the class by the constructor.
# 
---
# 
```php
$docmaker->deleteContent();
```
* Deletes the content of a document or an entire section of documents.
# 
---
# 
```php
$docmaker->putContent();
```
* Writes content to a document. 
# 
---
# 
```php
$docmaker->isContent();
```
* Returns true if there exists a document in a secion.
# 
---
# 
```php
$docmaker->addContent();
```
* Adds content to a document. Will not work if local file permissions are not configured correctly.
# 
---
# 
```php
$docmaker->isEdit();
```
* Determines if the document is being edited.
# 
---
# 
```php
$docmaker->editContent();
```
* Writes the edited content to the document and brings the user to the dashboard.