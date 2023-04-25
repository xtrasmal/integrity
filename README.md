# Wirelab Code Integrity 
![code integrity](https://github.com/wirelab/integrity/actions/workflows/run-integrity.yml/badge.svg?branch=main)

This repository holds a CLI program which can be used to check the integrity of deployed code.

## About
Features:

- Build a PHAR in order to check different environments.
- Build a ZIP of the project and create checksum
- Validate the hash of the zipped project to the created checksum
- Setup integrity

Upcoming features:

- WIP: Check expected path of a file
- WIP: Check expected file count
- WIP: Code signing

## Commands:

Below are all available commands.

### Setting up

Creates an empty zip and checksum file.

`php integrity setup`

### Build Phar

Builds Integrity as deployable phar.

`php integrity build:phar`

### Build Zip

Builds a zip for the clients project and creates a checksum file. 

`php integrity build:zip`

### Validate

Validates the checksum

`php integrity validate`

### Show all commands

`php integrity` or `php integrity help`

## Preconditions & such

### 💡 Practicalities

- To build `integrity.phar` you need to edit your `php.ini` and add `phar.readonly = Off`
- Add single files that should be excluded in `excluded.php`