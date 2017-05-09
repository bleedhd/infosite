<?php

// load the main workaround entry point file
require(__DIR__ . DS . 'site' . DS . 'plugins' . DS . 'file-language-workaround' . DS . 'file-language-workaround.php');
// instantiate the customized Kirby object
$kirby = kirbyWorkaround(__DIR__);
