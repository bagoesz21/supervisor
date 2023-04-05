<?php

namespace Supervisor;

/**
 * Process object holding data for a single process.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @author Buster Neece <buster@busterneece.com>
 */
interface ProcessInterface extends \ArrayAccess
{
    /**
     * Returns the process info array.
     */
    public function getPayload(): array;

    /**
     * Returns the process name.
     */
    public function getName(): string;

    /**
     * Checks whether the process is running.
     */
    public function isRunning(): bool;

    /**
     * Checks whether the process is running.
     */
    public function getState(): int;

    /**
     * Checks if process is in the given state.
     * @param int
     */
    public function checkState($state): bool;

    /**
     * Returns process name.
     */
    public function __toString(): string;
}
