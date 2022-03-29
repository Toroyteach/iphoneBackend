<?php

namespace App\Contract;

/**
 * Interface AcheivementContract
 * @package App\Contracts
 */
interface AchievementContract
{
    /**
     * Gets a model instance
     * @return array
     */
    public function unlockedAchievements(): array;

    /**
     * Gets a model instance
     * @return array
     */
    public function nextAvailableAchievements(): array;

    /**
     * Gets a model instal
     * @return string
     */
    public function currentBadge(): string;

    /**
     * Gets a model instance
     * @return string
     */
    public function  nextBadge(): string;

    /**
     * gets a model instance
     * @return int
     */
    public function  remainingAcheivements(): int;
}