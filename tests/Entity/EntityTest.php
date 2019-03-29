<?php

namespace Daikon\Tests\Entity\Entity;

use Daikon\Entity\Entity\EntityDiff;
use Daikon\Entity\Exception\AssertionFailed;
use Daikon\Entity\Exception\UnknownAttribute;
use Daikon\Tests\Entity\Fixture\Article;
use Daikon\Tests\Entity\Fixture\Location;
use Daikon\Tests\Entity\Fixture\Paragraph;
use Daikon\Tests\Entity\TestCase;

class EntityTest extends TestCase
{
    private const FIXED_UUID = '941b4e51-e524-4e5d-8c17-1ef96585abc3';

    private const FIXTURE = [
        '@type' => Article::class,
        'id' => '525b4e51-e524-4e5d-8c17-1ef96585cbd3',
        'created' => '2017-04-02T23:42:05.000000+00:00',
        'title' => 'hello world!',
        'url' => 'http://www.example.com/',
        'feedbackMail' => 'info@example.com',
        'averageVoting' => 23.42,
        'workshopDate' => '2017-05-23',
        'workshopCancelled' => true,
        'workshopLocation' => [
            '@type' => Location::class,
            'id' => 42,
            'coords' => [ 'lat' => 52.5119, 'lon' => 13.3084 ]
        ],
        'paragraphs' => [[
            '@type' => Paragraph::class,
            'id' => 23,
            'kicker' => 'this is the kicker baby!',
            'content' => 'hell yeah!'
        ]]
    ];

    /** @var Article $entity */
    private $entity;

    public function testGet(): void
    {
        $this->assertEquals(self::FIXTURE['id'], $this->entity->getIdentity()->toNative());
        $this->assertEquals(self::FIXTURE['title'], $this->entity->getTitle()->toNative());
    }

    public function testHas(): void
    {
        $this->assertTrue($this->entity->has('id'));
        $this->assertTrue($this->entity->has('title'));
        $this->assertTrue($this->entity->has('paragraphs'));
        $article = $this->entity::fromNative(['id' => '941b4e51-e524-4e5d-8c17-1ef96585abc3']);
        $this->assertFalse($article->has('title'));
    }

    public function testWithValue(): void
    {
        $article = $this->entity->withValue('id', self::FIXED_UUID);
        $this->assertEquals(self::FIXTURE['id'], $this->entity->get('id')->toNative());
        $this->assertEquals(self::FIXED_UUID, $article->get('id')->toNative());
    }

    public function testDiff(): void
    {
        $article = Article::fromNative([
            'id' => self::FIXED_UUID,
            'title' => 'Hello world!'
        ]);
        $diffData = [
            'title' => 'This is different'
        ];
        $calculatedDiff = (new EntityDiff)($article->withValues($diffData), $article);
        $this->assertEquals($diffData, $calculatedDiff->toNative());
    }

    public function testIsSameAs(): void
    {
        $articleTwo = Article::fromNative(['id' => self::FIXTURE['id'], 'title' => 'Hello world!']);
        // considered same, due to identifier
        $this->assertTrue($this->entity->isSameAs($articleTwo));
    }

    public function testGetValuePath(): void
    {
        $this->assertEquals(
            self::FIXTURE['paragraphs'][0]['kicker'],
            $this->entity->get('paragraphs.0-kicker')->toNative()
        );
    }

    public function testToNative(): void
    {
        $this->assertEquals(self::FIXTURE, $this->entity->toNative());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(AssertionFailed::class);
        Article::fromNative(['id' => self::FIXED_UUID, 'title' =>  [123]]);
    } // @codeCoverageIgnore

    public function testInvalidHas(): void
    {
        $this->expectException(UnknownAttribute::class);
        $article = Article::fromNative(['id' => self::FIXED_UUID]);
        $article->has('foobar');
    } // @codeCoverageIgnore

    public function testInvalidPath(): void
    {
        $this->expectException(UnknownAttribute::class);
        $article = Article::fromNative(['id' => self::FIXED_UUID]);
        $article->get('foo.0');
    } // @codeCoverageIgnore

    protected function setUp(): void
    {
        $this->entity = Article::fromNative(self::FIXTURE);
    }
}
