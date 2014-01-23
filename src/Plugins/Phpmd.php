<?php

namespace Ah\PhpGitHooks\Plugins;

use Ah\PhpGitHooks\PluginAbstract;

/**
 * Class phpmd
 * @package Ah\PhpGitHooks\Plugins
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Phpmd extends PluginAbstract
{

    /**
     * @var string
     */
    protected $binary = 'phpmd';

    /**
     * @var string
     */
    protected $name = 'PHP Mess Detector';

    /**
     * @param array $files
     * @return string
     * @throws \Exception
     */
    public function getCommand(array $files)
    {
        return sprintf('%s text codesize,unusedcode,naming', implode(" ", $files));
    }
}




