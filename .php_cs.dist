<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
         '@Symfony' => true,
         'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
