<?php

include('config.inc');
require_once('lib/bing.translate.php');
$BingTranslator = new BingTranslator($bing_app_id, $bing_secret);

$translation = $BingTranslator->getTranslation('en', 'zh-CHS', 'Who is George Washington?');

echo $translation."\n";

?>
