<?php

class InitExtension extends CConsoleCommand
{
    /**
     * Run the main command method
     * @param array     
     */
    public function run($args)
    {
        // prepare some vars
        $files      = array();
        $currentDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $destDir    = YiiBase::getPathOfAlias('ext.' . $args[1]) . DIRECTORY_SEPARATOR;
        
        // show debug
        echo("DEBUG: Creating extension dir...\n");
        
        // create dirs
        $this->ensureDirectory($destDir);
        $this->ensureDirectory($destDir . 'assets' . DIRECTORY_SEPARATOR);
        
        // show debug
        echo("DEBUG: Copying extension files...\n");
        
        // build file list
        $files[] = array('source' => $currentDir . 'ESwfObject.php', 
                         'target' => $destDir . 'ESwfObject.php');
                         
        $files[] = array('source' => $currentDir . 'assets' . DIRECTORY_SEPARATOR . 'expressInstall.swf', 
                         'target' => $destDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'expressInstall.swf');
                         
        $files[] = array('source' => $currentDir . 'assets' . DIRECTORY_SEPARATOR . 'swfobject.js', 
                         'target' => $destDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'swfobject.js' );
        
        // copy files
        $this->copyFiles($files);        
    }
}