<?php

namespace Accordia\Entity\EntityType;

use Accordia\Entity\Entity\EntityInterface;
use Accordia\Entity\ValueObject\ValueObjectInterface;

interface AttributeInterface
{
    /**
     * @param string $name
     * @param mixed $valueType
     * @param EntityTypeInterface $entityType
     * @return Attribute
     */
    public static function define(
        string $name,
        $valueType,
        EntityTypeInterface $entityType
    ): AttributeInterface;

    /**
     * Create an attribute specific VO instance from the given (possibly native)value.
     *
     * @param mixed $value
     * @param EntityInterface $parent The entity that the value is being created for.
     * @return ValueObjectInterface
     */
    public function makeValue($value = null, EntityInterface $parent = null): ValueObjectInterface;

    /**
     * Returns the name of the attribute.
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the attribute"s type.
     * @return EntityTypeInterface
     */
    public function getEntityType(): EntityTypeInterface;

    /**
     * Returns the attribute"s parent, if it has one.
     * @return null|AttributeInterface
     */
    public function getParent(): ?AttributeInterface;

    /**
     * Return information reflecting the attribute's value e.g. VO class or allowed nested-types
     * @return mixed
     */
    public function getValueType();
}
