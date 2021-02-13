# Delete Expired Entries plugin for Craft CMS 3.x

This plugin automatically deletes entries when a set time has elapsed from a date/time field.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

<<<<<<< HEAD
        composer require jmkelley/dumptruck
=======
        composer require dumptruck/delete-entries
>>>>>>> d71f66b195411b04507c9de9f6d8471cb18e0f5f

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Delete Entries.

## Dump Truck Overview

This plugin can be used to delete expired entries of sections (Channel and Structure)

## Configuring Dump Truck

Go to settings of plugin and set:
**Time Elapsed** Number of days after expired entries will be deleted.
**Sections** Select channels for which it will be applied.

The process of deleting exprired entried can be scheduled with Craft Job by running 
```
php craft dump-truck/dump/entries
```

Brought to you by [Jonathan Kelley](http://www.vouchertoday.uk/)