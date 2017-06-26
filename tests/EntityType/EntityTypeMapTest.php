<?php

namespace Daikon\Tests\Entity\EntityType;

use Daikon\Entity\EntityType\EntityTypeMap;
use Daikon\Tests\Entity\Fixture\ArticleType;
use Daikon\Tests\Entity\Fixture\ParagraphType;
use Daikon\Tests\Entity\TestCase;

class EntityTypeMapTest extends TestCase
{
    /**
     * @var EntityTypeMap $typeMap
     */
    private $typeMap;

    public function testHas(): void
    {
        $this->assertTrue($this->typeMap->has("article"));
        $this->assertFalse($this->typeMap->has("paragraph"));
    }

    public function testByName(): void
    {
        $this->assertInstanceOf(ArticleType::class, $this->typeMap->byName("Article"));
        $this->assertNull($this->typeMap->byName("Paragraph"));
    }

    public function testByPrefix(): void
    {
        $this->assertInstanceOf(ArticleType::class, $this->typeMap->get("article"));
    }

    public function testByClass(): void
    {
        $this->assertInstanceOf(ArticleType::class, $this->typeMap->byClassName(ArticleType::class));
        $this->assertNull($this->typeMap->byClassName(ParagraphType::class));
    }

    public function testCount(): void
    {
        $this->assertCount(1, $this->typeMap);
    }

    public function testGetIterator(): void
    {
        $this->assertEquals(1, iterator_count($this->typeMap));
    }

    protected function setUp(): void
    {
        $articleType = new ArticleType;
        $this->typeMap = new EntityTypeMap([ $articleType ]);
    }
}
