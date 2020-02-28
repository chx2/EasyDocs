# EasyDocs
EasyDocs allows for you to create & edit user documentation with a built-in dashboard centered around the organization of documentation under various user defined topics.

No database is required to run EasyDocs. A full-installation process will take less than five minutes and will have you easily spinning up documentation in no time!

## Features
There are numerous features within EasyDocs that make the creation of user documentation easy:

- Database(less): One of the main features of EasyDocs is there is no need for a database of any sort.
- Easy Configuration: Much of EasyDocs can be modified from one config file. This file has it's definitions layed out in very
easy-to-understand terms, meaning someone without programming knowledge would be able to know what they're modifying.
- ADA Compliancy: Documentation generated for the user is fully-ada compliant by default.
- MVC-Like architecture: The structure of the EasyDocs source means modification is easy. No sifting through a gargled codebase
for editing the visuals of a specific template.

## Prerequisites

- A web server with PHP 7.2.4+ installed
- File reading/writing permissions(Required for the docs/ folder included in EasyDocs)
- [Composer](https://getcomposer.org/download/)

## Installation

**With Composer**
1. Run the following command to download the composer package:

> composer create-project chx2/easydocs -s dev

2. Edit the config.yaml file under the app/ directory to update your username & password plus add any additional users. A default one is provided but is recommended that you change it. You can edit current users & add new ones under the YAML block called users:

> admin: '1234'

Say you want a new one with the name 'superuser' and a password of '1029', you would add this line to the users block:

> superuser: '1029'

3. Enter the URL of the webserver to login. Once you have created your first section inside the ACP (Accessible by appending /login to url), you can begin to write your documentation!

## Modifications
It is possible to modify the layout and/or functionality of EasyDocs if you wish.

Inside the config.yaml file, there are two values within that hold arrays linking to any stylesheets or scripts you wish to use in your project. Besides that, There are other various places in which you can modify EasyDocs:

- bootstrap.php -> Serves as a place where global variables are initialized.
- router.php    -> Holds application routes
- assets/       -> Folder that you should store custom css/js or local scripts
- classes/      -> Folder containing logical units that manage files,sessions,data etc...
- templates/    -> Folder containing the HTML templates used by EasyDocs

## Manual Documentation
While the intended purpose of EasyDocs is to provide an editor to help you create documentation, it is entirely possible to create documentation manually if you choose to do so. Keep in mind you should follow the these steps to ensure your additions do not cause any issues within the application:

1. In your config.yaml file, add your new page name to an existing section under the Pages variable. If you want to create a new section, you will need to add that as well.

> Pages:
>   Default: [Test]

2. Under the docs/ folder, add your page name to the folder of the section you specified. If you are making a new section, you will need to create a new folder.
> docs/Default/Test.md

3. Edit your new documentation file and save when complete. Your document will show up the next time you visit the application.

## Credits
There are several plugins that are utilized within EasyDocs for simplified usage:

### Back-End
- [Bramus Router](https://github.com/bramus/router)
- [Smarty Templating Engine](https://github.com/smarty-php/smarty)
- [Symfony Yaml Parser](https://github.com/symfony/yaml)
- [Markup Parser](https://github.com/erusev/parsedown)

### Front-End
- [Bulma Framework](https://bulma.io/)
- [hunzaboy CSS Checkboxes](https://github.com/hunzaboy/CSS-Checkbox-Library)
- [jQuery](https://jquery.com/)
- [jQuery UI](https://jqueryui.com/)
- [Inscryb Markdown Editor(Fork based on original by Sparksuite)](https://github.com/inscryb/inscryb-markdown-editor)
- [Font Awesome Icons](https://fontawesome.com)


## Bug reporting
Feel free to leave a issue if something is not working with EasyDocs by default

Note, I will not respond to reports if the error occurred after custom modification of EasyDocs. The only exception I will allow is if something within EasyDocs is not behaving as seemingly intended, therefore causing errors.
