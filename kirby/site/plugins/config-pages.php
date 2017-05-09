<?php

$kirby = kirby();
$kirby->plugin('constructs');
$kirby->set('page::model', 'configuration', 'Constructs\\ConfigurationPage');
