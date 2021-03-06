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
use Daikon\ValueObject\BoolValue;
use Daikon\ValueObject\Date;
use Daikon\ValueObject\Email;
use Daikon\ValueObject\FloatValue;
use Daikon\ValueObject\Text;
use Daikon\ValueObject\Timestamp;
use Daikon\ValueObject\Url;
use Daikon\ValueObject\Uuid;
use Daikon\ValueObject\ValueObjectInterface;

final class Article extends Entity
{
    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('id', Uuid::class),
            Attribute::define('created', Timestamp::class),
            Attribute::define('title', Text::class),
            Attribute::define('url', Url::class),
            Attribute::define('feedbackMail', Email::class),
            Attribute::define('averageVoting', FloatValue::class),
            Attribute::define('workshopDate', Date::class),
            Attribute::define('workshopCancelled', BoolValue::class),
            Attribute::define('workshopLocation', Location::class),
            Attribute::define('paragraphs', ParagraphList::class)
        ]);
    }

    public function getIdentity(): ValueObjectInterface
    {
        return $this->getId();
    }

    public function getId(): Uuid
    {
        return $this->get('id') ?? Uuid::generate();
    }

    public function getTitle(): Text
    {
        return $this->get('title') ?? Text::makeEmpty();
    }

    public function getUrl(): ?Url
    {
        return $this->get('url');
    }

    public function getFeedbackMail(): ?Email
    {
        return $this->get('feedbackMail');
    }

    public function getAverageVoting(): ?FloatValue
    {
        return $this->get('averageVoting');
    }

    public function getWorkshopDate(): Date
    {
        return $this->get('workshopDate') ?? Date::makeEmpty();
    }

    public function getWorkshopLocation(): ?Location
    {
        return $this->get('workshopLocation');
    }

    public function isWorkshopCancelled(): BoolValue
    {
        return $this->get('workshopCancelled') ?? BoolValue::false();
    }

    public function getParagraphs(): ParagraphList
    {
        return $this->get('paragraphs') ?? ParagraphList::makeEmpty();
    }
}
