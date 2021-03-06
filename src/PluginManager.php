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

        foreach($config as $pluginName => $pluginConfig) {
            if(!is_string($pluginName)) {
                continue;
            }

            $class = 'Ah\PhpGitHooks\Plugins\\' . ucfirst($pluginName);
            if(class_exists($class)) {
                $this->addCheck(new $class($pluginConfig));
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

            if(!$return) {
                echo $plugin->getOutput();
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

        $output = array();
        $return = 0;
        exec('git rev-parse --verify HEAD 2> /dev/null', $output, $return);

        // Get GIT revision to diff against
        if($return == 0) {
            $against = 'HEAD';
        } else {
            $against = '4b825dc642cb6eb9a060e54bf8d69288fbee4904';
        }

        // Get the list of files in this commit.
        $output = array();
        $return = 0;
        exec(sprintf("git diff-index --cached --name-only %s", escapeshellarg($against)), $output, $return);

        if(empty($output)) {
            //no new files
            //so exit
            exit(0);
        }

        $filesToLint = array();
        foreach ($output as $file) {
            if(substr($file, -4) !== '.php') {
                // don't check files that aren't PHP
                continue;
            }

            // If file is removed from git do not sniff.
            if (!file_exists($file)) {
                continue;
            }

            $filesToLint[] = escapeshellarg($file);
        }

        if(empty($filesToLint)) {
            //no php files to check
            return false;
        }

        return $filesToLint;
    }
}
