<?php

namespace Ah\PhpGitHooks\Plugins;

use Ah\PhpGitHooks\PluginAbstract;

/**
 * Class Phpcs
 * @package Ah\PhpGitHooks\Plugins
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Phpcs extends PluginAbstract
{

    /**
     * @var string
     */
    protected $binary = 'phpcs';

    /**
     * @var string
     */
    protected $name = 'PHP Code Sniffer';

    /**
     * @param array $files
     * @return string
     * @throws \Exception
     */
    public function getCommand(array $files)
    {
        $standard = (isset($this->config['ruleset'])) ? $this->config['ruleset'] : 'psr2';

        return sprintf('-n --standard=%s %s', $standard, implode(" ", $files));
    }
}




