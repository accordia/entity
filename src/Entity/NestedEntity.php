<?php

namespace Daikon\Entity\Entity;

use Daikon\Entity\Assert\Assertion;
use Daikon\Entity\Error\InvalidType;
use Daikon\Entity\ValueObject\Nil;
use Daikon\Entity\ValueObject\ValueObjectInterface;

abstract class NestedEntity extends Entity implements ValueObjectInterface
{
    /**
     * {@inheritdoc}
     */
    public static function fromNative($nativeState): ValueObjectInterface
    {
        return self::fromArray($nativeState);
    }

    /**
     * {@inheritdoc}
     */
    public function toNative()
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public static function makeEmpty(): ValueObjectInterface
    {
        return Nil::makeEmpty();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        foreach ($this->getValueObjectMap() as $value) {
            if (!$value->isEmpty()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param ValueObjectInterface $otherValue
     * @return bool
     */
    public function equals(ValueObjectInterface $otherValue): bool
    {
        Assertion::isInstanceOf($otherValue, static::class);
        foreach ($this->getValueObjectMap() as $attrName => $value) {
            if (!$value->equals($otherValue->get($attrName))) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("%s:%s", $this->getEntityType()->getName(), $this->getIdentity());
    }
}
