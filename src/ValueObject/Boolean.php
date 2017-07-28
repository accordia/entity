<?php

namespace Daikon\Entity\ValueObject;

use Daikon\Entity\Assert\Assertion;

final class Boolean implements ValueObjectInterface
{
    /**
     * @var bool
     */
    private $value;

    /**
     * @param bool $nativeValue
     * @return self
     */
    public static function fromNative($nativeValue): Boolean
    {
        Assertion::boolean($nativeValue);
        return new Boolean($nativeValue);
    }

    public function toNative(): bool
    {
        return $this->value;
    }

    public function equals(ValueObjectInterface $otherValue): bool
    {
        return $otherValue instanceof Boolean && $this->toNative() === $otherValue->toNative();
    }

    public function __toString(): string
    {
        return $this->value ? "true" : "false";
    }

    public function isTrue(): bool
    {
        return $this->value === true;
    }

    public function isFalse(): bool
    {
        return $this->value === false;
    }

    public function negate(): Boolean
    {
        $clone = clone $this;
        $clone->value = !$this->value;
        return $clone;
    }

    private function __construct(bool $value)
    {
        $this->value = $value;
    }
}
