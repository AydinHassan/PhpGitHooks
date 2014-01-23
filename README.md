PhpGitHooks
===========
[![Latest Stable Version](https://poser.pugx.org/aydin-hassan/php-git-hooks/v/stable.png)](https://packagist.org/packages/aydin0hassan/php-git-hooks)
[![Latest Unstable Version](https://poser.pugx.org/aydin-hassan/php-git-hooks/v/unstable.png)](https://packagist.org/packages/aydin-hassan/php-git-hooks)

This project contains some simple scripts to run Unit tests and static analysis tools before allowing a commit.

Currently the tool will run:

1. PHPUnit
2. PHP Copy Paste Detector
3. PHP Code Sniffer

The tool will only run phpcs on modified files where phpcpd will be run against all files. PHPUnit will be run if there if a phpunit.xml or phpunit.xml.dist file in the root of the project.

PHP Code Sniffer will be run with ps2 coding standard and warning will be ingored (eg line limits)

This script will look for binaries in either the project's `vendor/bin` directory first and will fall back to `~/.composer/vendor/bin` so make sure the tools are installed with composer.


Install tools
-------------

    composer global require 'phpunit/phpunit:3.7.*'
    composer global require 'squizlabs/php_codesniffer:1.5.1'
    composer global require 'sebastian/phpcpd=2.0.0'
    
Install hooks
-------------

    composer global require 'aydin-hassan/php-git-hooks:0.1.0-beta1'
    cd ~/.composer/vendor/aydin-hassan/php-git-hooks
    ./install.sh
    
Done
----
Everytime you commit something from any newly cloned/ created repository these checks will be executed!
