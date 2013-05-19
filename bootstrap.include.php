<?php

/**
 * FacebookGallery
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://kit2.phpmanufaktur.de/FacebookGallery
 * @copyright 2013 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

use phpManufaktur\Basic\Control\kitCommand\Basic as kitCommand;
use phpManufaktur\FacebookGallery\Control\Gallery;

// scan the /Locale directory and add all available languages
$app['utils']->addLanguageFiles(MANUFAKTUR_PATH.'/FacebookGallery/Data/Locale');

$app->post('/command/facebookgallery', function() use ($app) {
    // init basic kitCommand
    $kitCommand = new kitCommand($app);
    // get the GET parameters for this route
    $cmsGET = $kitCommand->getCMSgetParameters();
    // we need the parameter ID for the CMS handling
    $parameter_id = isset($cmsGET['parameter_id']) ? $cmsGET['parameter_id'] : $kitCommand->getParameterID();
    $source = FRAMEWORK_URL."/facebookgallery/exec?pid=$parameter_id";
    return $kitCommand->createIFrame($source);
})
->setOption('info', MANUFAKTUR_PATH.'/FacebookGallery/command.facebookgallery.json');

// execute the general FacebookGallery class
$app->match('/facebookgallery/exec', function () use ($app) {
    $Gallery = new Gallery($app);
    return $Gallery->exec();
});