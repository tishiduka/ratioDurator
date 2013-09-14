<?php
require_once('./ratioDurator.php');

$obj = new ratioDurator;
$obj->setProbability(0.5);
$obj->setRatio(1.1);
$obj->setLimit(10);
$obj->setAbsMode(TRUE);
$score = $obj->getValue();
$dur = $obj->getProbability();

// 結果表示
echo "{$score}\n";
//echo "probability to dropout : " . (round(1 - $dur,3) * 100) . "%.\n";

exit;
