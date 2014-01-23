PhpGitHooks
===========

This project contains some simple scripts to run Unit tests and static analysis tools before allowing a commit.

Currently the tool will run:

1. PHPUnit
2. PHP Copy Paste Detector
3. PHP Code Sniffer

The tool will only run phpcs on modified files where phpcpd will be run against all files. PHPUnit will be run if there if a phpunit.xml or phpunit.xml.dist file in the root of the project.

PHP Code Sniffer will be run with PSR-2 coding standard and warning will be ingored (eg line limits)

This script will look for binaries in either the project's `vendor/bin` directory first and will fall back to `~/.composer/vendor/bin` so make sure the tools are installed with composer.

See [PHP-FIG](https://github.com/php-fig/fig-standards) for the coding standards.


Install tools
-------------

    composer global require 'phpunit/phpunit:3.7.*'
    composer global require 'squizlabs/php_codesniffer:1.5.1'
    composer global require 'sebastian/phpcpd=2.0.0'
    
Install hooks
-------------

    git clone https://github.com/AydinHassan/PhpGitHooks.git
    ./install.sh

If you have any existing repositories you should run `git init` in the root of the repo to enable the hooks in them. All new repos will inherit the hooks.
    
Done
----
Everytime you commit something from any newly cloned/ created repository these checks will be executed!

Todo
----
- [ ] Figure out how to execute global hooks if local repo hooks are defined

