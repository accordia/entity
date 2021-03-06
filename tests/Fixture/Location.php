<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/entity project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\Entity\Fixture;

use Daikon\Entity\Attribute;
use Daikon\Entity\AttributeMap;
use Daikon\Entity\Entity;
use Daikon\ValueObject\GeoPoint;
use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\ValueObjectInterface;

final class Location extends Entity
{
    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('id', IntValue::class),
            Attribute::define('name', Text::class),
            Attribute::define('street', Text::class),
            Attribute::define('postalCode', Text::class),
            Attribute::define('city', Text::class),
            Attribute::define('country', Text::class),
            Attribute::define('coords', GeoPoint::class)
        ]);
    }

    public function getIdentity(): ValueObjectInterface
    {
        return $this->getId();
    }

    public function getId(): IntValue
    {
        return $this->get('id') ?? IntValue::zero();
    }

    public function getName(): Text
    {
        return $this->get('name') ?? Text::makeEmpty();
    }

    public function getStreet(): Text
    {
        return $this->get('street') ?? Text::makeEmpty();
    }

    public function getPostalCode(): Text
    {
        return $this->get('postalCode') ?? Text::makeEmpty();
    }

    public function getCity(): Text
    {
        return $this->get('city') ?? Text::makeEmpty();
    }

    public function getCountry(): Text
    {
        return $this->get('country') ?? Text::makeEmpty();
    }

    public function getCoords(): ?GeoPoint
    {
        return $this->get('coords');
    }
}
