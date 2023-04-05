<?php

declare(strict_types=1);

namespace Supervisor;

/**
 * A class documenting the results of a "reloadAndApplyConfig" operation.
 */
final class ReloadResult implements ReloadResultInterface
{
    private array $added = [];
    private array $modified = [];
    private array $removed = [];

    public function __construct() {}

    /**
     * @inheritDoc
     */
    public function getAffected(): array
    {
        return array_merge($this->added, $this->modified, $this->removed);
    }

    /**
     * @inheritDoc
     */
    public function getAdded(): array
    {
        return $this->added;
    }

    /**
     * @inheritDoc
     */
    public function getModified(): array
    {
        return $this->modified;
    }

    /**
     * @inheritDoc
     */
    public function getRemoved(): array
    {
        return $this->removed;
    }

    public static function fromReloadConfig(array $reloadResult): self
    {
        [$added, $modified, $removed] = $reloadResult[0] ?? [null, null, null];

        return new self(
            $added ?? [],
            $modified ?? [],
            $removed ?? []
        );
    }
}
