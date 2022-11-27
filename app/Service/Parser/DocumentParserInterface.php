<?php

declare(strict_types=1);

namespace App\Service\Parser;

/**
 * Interface DocumentParserInterface.
 */
interface DocumentParserInterface
{
    public function namespaces(): array;

    /**
     * @param \DOMElement $root
     *
     * @return array
     */
    public function parse($root): array;
}
