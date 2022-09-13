<?php

declare(strict_types=1);

namespace App\Test\Benchmark;

use App\Entity\User;
use PhpBench\Attributes\Revs;

class SimpleBench
{
    #[Revs(1000)]
    public function benchStringVariable(): void
    {
        foreach (range(1, 1000) as $num) {
            $var = "1234567890abcdefghijklmnopqrstuvwxyz";
        }
    }

    #[Revs(1000)]
    public function benchUserObject(): void
    {
        foreach (range(1, 1000) as $num) {
            $object = new User();
        }
    }

    #[Revs(1000)]
    public function benchDatetimeNow(): void
    {
        foreach (range(1, 1000) as $num) {
            $datetime = new \DateTime("now");
        }
    }

    #[Revs(1000)]
    public function benchDatetimeFixed(): void
    {
        foreach (range(1, 1000) as $num) {
            $datetime = new \DateTime("2000-01-01 00:00:00");
        }
    }

    #[Revs(1000)]
    public function benchExplode(): void
    {
        foreach (range(1, 1000) as $num) {
            $parts = explode(",", "a,b,c,d,e,f,g,h,i,j");
        }
    }
}
