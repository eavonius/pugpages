<?php
global $pugPageTemplatePath;

$extensionOffset = strpos($pugPageTemplatePath, '.');
$pageModelClass = substr($pugPageTemplatePath, 0, $extensionOffset);
$pageModelClass = str_replace('/', '\\', $pageModelClass);

$pageModel = new $pageModelClass;
$pageModel->handleRequest();
