<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/entity project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Entity\Path;

final class ValuePathPart
{
    private string $attributeName;

    private int $position;

    public function __construct(string $attributeName, int $position = -1)
    {
        $this->attributeName = $attributeName;
        $this->position = $position;
    }

    public function getAttributeName(): string
    {
        return $this->attributeName;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function hasPosition(): bool
    {
        return $this->position >= 0;
    }

    public function __toString(): string
    {
        return $this->hasPosition()
            ? $this->getAttributeName().'.'.$this->getPosition()
            : $this->getAttributeName();
    }
}
