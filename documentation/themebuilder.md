# EasyDocs/app/classes/themebuilder.php
---
This class is used to handle the "theme" functionality of EasyDocs.
## Usage
---
```php
$tb = new ThemeBuilder();
//or
$tb = new chx2\ThemeBuilder();
```
## Class Variables
---
```php
public $theme;
public $themes = array();
```
## Function Declarations / Class Methods
---
# 
```php
public function __construct($path)
```
* Parses the theme settings YAML file and the settings from each theme. If an installed theme is missing a file the program is stopped.
# 
---
# 
```php
$tb->getThemeTitles();
```
* Gets the title of each theme from the theme settings.
