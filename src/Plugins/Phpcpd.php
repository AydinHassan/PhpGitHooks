<?php

namespace Ah\PhpGitHooks\Plugins;

use Ah\PhpGitHooks\PluginAbstract;

/**
 * Class Phpcpd
 * @package Ah\PhpGitHooks\Plugins
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Phpcpd extends PluginAbstract
{

    /**
     * @var string
     */
    protected $binary = 'phpcpd';

    /**
     * @var string
     */
    protected $name = 'PHP Copy Paste Detector';

    /**
     * @param array $files
     * @return string
     * @throws \Exception
     */
    public function getCommand(array $files)
    {
        return '. --exclude vendor';
    }
}
