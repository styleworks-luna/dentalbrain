<?php

namespace App\DTO\Recruit;

use App\Models\Recruit\Recruit;

class RecruitAuthority
{
    private $applied;
    private $isOwner;
    private $isAdmin;

    /**
     * @return bool
     */
    public function isApplied(): bool
    {
        return $this->applied;
    }

    /**
     * @return bool
     */
    public function isOwner(): bool
    {
        return $this->isOwner;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function __construct(bool $isOwner, bool $applied, bool $isAdmin = false)
    {
        $this->isOwner = $isOwner;
        $this->applied = $applied;
        $this->isAdmin = $isAdmin;
    }
}
