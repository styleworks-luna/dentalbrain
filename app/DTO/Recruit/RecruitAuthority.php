<?php

namespace App\DTO\Recruit;

use App\Models\Recruit\Recruit;
use App\Models\Resume\Resume;
use Illuminate\Support\Facades\Auth;

class RecruitAuthority
{
    private $hasResume;

    /**
     * @return mixed
     */
    public function hasResume()
    {
        return $this->hasResume;
    }

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

    public function __construct(Recruit $recruit, bool $applied)
    {
        $this->applied = $applied;
        if (Auth::check()) {
            $this->isAdmin = Auth::user()->is_admin;
            $this->isOwner = $recruit->user_id == Auth::id();
            $this->hasResume = Resume::query()->where('user_id', '=', Auth::id())->exists();
        } else {
            $this->isAdmin = false;
            $this->isOwner = false;
            $this->hasResume = false;
        }

    }
}
