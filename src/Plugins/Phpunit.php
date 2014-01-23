<?php

namespace Ah\PhpGitHooks\Plugins;

use Ah\PhpGitHooks\PluginAbstract;

/**
 * Class Phpunit
 * @package Ah\PhpGitHooks\Plugins
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Phpunit extends PluginAbstract
{

    /**
     * @var string
     */
    protected $binary = 'phpunit';

    /**
     * @var string
     */
    protected $name = 'PHPUnit';

    /**
     * @param array $files
     * @return string
     * @throws \Exception
     */
    public function getCommand(array $files)
	{

		if(!file_exists('phpunit.xml') && !file_exists('phpunit.xml.dist')) {
			//no test config so assume to tests to run
            throw new \Exception("No phpunit config can be found");
		}

        return '';
	}
}
