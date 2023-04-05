<?php

namespace Supervisor;

use ReturnTypeWillChange;

/**
 * Process object holding data for a single process.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @author Buster Neece <buster@busterneece.com>
 */
final class Process implements ProcessInterface
{
    /**
     * Process states.
     */
    public const STOPPED = 0;
    public const STARTING = 10;
    public const RUNNING = 20;
    public const BACKOFF = 30;
    public const STOPPING = 40;
    public const EXITED = 100;
    public const FATAL = 200;
    public const UNKNOWN = 1000;

    private array $payload = [];

    public function __construct(array $payload) {
        $this->payload = $payload;
    }

    /**
     * @inheritDoc
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->payload['name'];
    }

    /**
     * @inheritDoc
     */
    public function getState(): int
    {
        return $this->payload['state'];
    }

    /**
     * @inheritDoc
     */
    public function isRunning(): bool
    {
        return $this->checkState(self::RUNNING);
    }

    /**
     * @inheritDoc
     */
    public function checkState($state): bool
    {
        return $this->getState() === $state;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->payload[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->payload[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        throw new \LogicException('Process object cannot be altered');
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        throw new \LogicException('Process object cannot be altered');
    }
}
