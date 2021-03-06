<?php

declare(strict_types=1);

namespace Kreait\Firebase\Auth;

use DateTimeImmutable;
use Kreait\Firebase\Util\DT;

class UserMetaData implements \JsonSerializable
{
    /**
     * @var DateTimeImmutable
     */
    public $createdAt;

    /**
     * @var DateTimeImmutable|null
     */
    public $lastLoginAt;

    public static function fromResponseData(array $data): self
    {
        $metadata = new self();
        $metadata->createdAt = DT::toUTCDateTimeImmutable($data['createdAt']);

        if ($data['lastLoginAt'] ?? null) {
            $metadata->lastLoginAt = DT::toUTCDateTimeImmutable($data['lastLoginAt']);
        }

        return $metadata;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize()
    {
        $data = $this->toArray();

        $data['createdAt'] = $data['createdAt']->format(DATE_ATOM);
        $data['lastLoginAt'] = $data['lastLoginAt'] ? $data['lastLoginAt']->format(DATE_ATOM) : $data['lastLoginAt'];

        return $data;
    }
}
