<?php

namespace Ah\PhpGitHooks;

/**
 * Class PluginManager
 * @package Ah\PhpGitHooks
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class PluginManager
{
    /**
     * @var array
     */
    protected $plugins = array();

    /**
     * @param $configFileName
     */
    public function __construct($configFileName)
    {
        try {
            $this->loadConfig($configFileName);
        } catch (\InvalidArgumentException $e) {
            echo sprintf("Error Starting: '%s'\n\n", $e->getMessage());
            exit(1);
        }
    }

    /**
     * @param string $configFileName
     * @throws \InvalidArgumentException
     */
    public function loadConfig($configFileName)
    {
        if(!file_exists($configFileName) || !is_readable($configFileName)) {
            throw new \InvalidArgumentException("Config file is not readable");
        }

        $config = include($configFileName);

        if(!is_array($config)) {
            throw new \InvalidArgumentException("Config file contains invalid data, must be an array");
        }

        foreach($config as $plugin) {
            if(!is_string($plugin)) {
                continue;
            }

            $class = 'Ah\PhpGitHooks\Plugins\\' . ucfirst($plugin);
            if(class_exists($class)) {
                $this->addCheck(new $class);
            }
        }
    }

    /**
     * @param PluginAbstract $plugin
     */
    public function addCheck(PluginAbstract $plugin)
    {
        $this->plugins[] = $plugin;
    }

    /**
     * Run all the plugins
     */
    public function run()
    {
        $files = $this->getFiles();

        if(!$files) {
            //no files to check
            exit(0);
        }

        foreach($this->plugins as $plugin) {
            $return = $plugin->run($files);

            if($return > 0) {
                //plugin returned non 0 return code
                //therefore commit should not be executed
                exit(1);
            }
        }
    }

    /**
     * Get all modified files
     */
    protected function getFiles()
    {
        $files = array();

        if(empty($files)) {
            return false;
        }

        return array();
    }
}
