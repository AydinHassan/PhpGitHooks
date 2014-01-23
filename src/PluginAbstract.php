<?php

namespace Ah\PhpGitHooks;

/**
 * Class PluginAbstract
 * @package Ah\PhpGitHooks
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
abstract class PluginAbstract
{
    /**
     * @var string Binary Path
     */
    protected $binary;

    /**
     * @var string
     */
    protected $output;

    /**
     * @var string
     */
    protected $name;

    /**
     * Check shit
     */
    public function __construct() {

        if (!is_string($this->binary)) {
            throw new \Exception("Binary name is not set");
        }

        if (!is_string($this->name)) {
            throw new \Exception("Command name is not set");
        }
    }

    /**
     * Check for the binary in the project vendor first and then
     * fallback to global composer vendor dir
     *
     * @return string
     * @throws \Exception
     */
    protected function getBinaryLocation()
    {

        $binaryPath = null;
        if (file_exists(sprintf('vendor/bin/%s', $this->binary))) {
            $binaryPath = sprintf('vendor/bin/%s', $this->binary);
        } elseif (file_exists(sprintf('%s/.composer/vendor/bin/%s', getenv("HOME"), $this->binary))) {
            $binaryPath = sprintf('%s/.composer/vendor/bin/%s', getenv("HOME"), $this->binary);
        }

        if (!$binaryPath) {
            throw new \Exception(sprintf("Could not find the location of '%s'", $this->binary));
        }

        return $binaryPath;
    }

    /**
     * @param $command
     * @return bool
     */
    public function executeCommand($command)
    {

        $output = array();
        $return = 0;
        exec(sprintf('%s %s', $this->getBinaryLocation(), $command), $output, $return);

        if($return === 255) {
            $this->output = sprintf('%s did not run successfully', $this->name);
            return false;
        }

        if ($return !== 0) {
            $this->output = implode("\n", $output);
            return false;
        }

        //check returned true - all good
        return true;
    }

    /**
     * Run the check
     *
     * @param array $files
     * @return bool
     * @throws \Exception
     */
    public function run(array $files)
    {
        try {
            $command = $this->getCommand($files);
        } catch(\Exception $e) {
            return true;
        }

        return $this->executeCommand($command);
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param array $files
     * @return string
     */
    abstract protected function getCommand(array $files);


}