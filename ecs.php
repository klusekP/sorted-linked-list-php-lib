<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withPhpCsFixerSets(php83Migration: true)
    ->withPreparedSets(psr12: true, common: true, symplify: true)
    ->withConfiguredRule(\PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ])
    ->withSkip([
        'SlevomatCodingStandard\\Sniffs\\Classes\\SuperfluousInterfaceNamingSniff' => [
            __DIR__ . '/src/*Interface.php',
        ],
    ])
    ->withSpacing(Option::INDENTATION_SPACES, "\n");
