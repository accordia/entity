<?php

namespace Accordia\Tests\Entity\EntityType;

use Accordia\Entity\EntityType\EntityTypeInterface;
use Accordia\Entity\EntityType\NestedEntityAttribute;
use Accordia\Tests\Entity\Fixture\Location;
use Accordia\Tests\Entity\Fixture\LocationType;
use Accordia\Tests\Entity\TestCase;
use Accordia\Entity\ValueObject\Nil;

final class NestedEntityAttributeTest extends TestCase
{
    private const FIXED_DATA = [
        "@type" => "location",
        "id" => 42,
        "name" => "my poi",
        "street" => "fleetstreet 23",
        "postal_code" => "1337",
        "city" => "codetown",
        "country" => "Utopia",
        "coords" => [ "lon" => 0.0, "lat" => 0.0 ]
    ];

    /**
     * @var NestedEntityAttribute $attribute
     */
    private $attribute;

    public function testMakeValueFromNative(): void
    {
        $this->assertEquals(self::FIXED_DATA, $this->attribute->makeValue(self::FIXED_DATA)->toNative());
    }

    public function testMakeValueFromObject(): void
    {
        $locationType = $this->attribute->getValueType()->get("location");
        $locationState = self::FIXED_DATA;
        $locationState["@type"] = $locationType;
        $location = Location::fromNative($locationState);
        $this->assertEquals(self::FIXED_DATA, $this->attribute->makeValue($location)->toNative());
    }

    public function testMakeEmptyValue(): void
    {
        $this->assertInstanceOf(Nil::class, $this->attribute->makeValue());
    }

    /**
     * @expectedException \Accordia\Entity\Error\AssertionFailed
     */
    public function testUnexpectedValue(): void
    {
        $this->attribute->makeValue("snafu!");
    } // @codeCoverageIgnore

    /**
     * @expectedException \Accordia\Entity\Error\MissingImplementation
     */
    public function testNonExistingTypeClass(): void
    {
        /* @var EntityTypeInterface $entityType */
        $entityType = $this->getMockBuilder(EntityTypeInterface::class)->getMock();
        NestedEntityAttribute::define("foo", [ "\\Accordia\Entity\\FooBaR" ], $entityType);
    } // @codeCoverageIgnore

    /**
     * @expectedException \Accordia\Entity\Error\CorruptValues
     */
    public function testInvalidType(): void
    {
        $data = self::FIXED_DATA;
        $data["@type"] = "foobar";
        $this->attribute->makeValue($data);
    } // @codeCoverageIgnore

    /**
     * @expectedException \Accordia\Entity\Error\AssertionFailed
     */
    public function testMissingType(): void
    {
        $data = self::FIXED_DATA;
        unset($data["@type"]);
        $this->attribute->makeValue($data);
    } // @codeCoverageIgnore

    protected function setUp(): void
    {
        /* @var EntityTypeInterface $entityType */
        $entityType = $this->getMockBuilder(EntityTypeInterface::class)->getMock();
        $this->attribute = NestedEntityAttribute::define("locations", [ LocationType::class ], $entityType);
    }
}
