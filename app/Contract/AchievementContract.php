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
    /**
     * gets achievement from count
     * @param string $type
     * @param string $count
     * @return int
     */
    public function  getAchievements(string $type, int $level): int;
        /**
     * gets achievement title
     * @param string $type
     * @param int $count
     * @return int
     */
    public function  getAchievementName(string $type, int $count): string;
}