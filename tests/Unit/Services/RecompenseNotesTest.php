<?php
namespace Tests\Unit\Services;


use PHPUnit\Framework\TestCase;
use Services\RecompenseNotes;


class RecompenseNotesTest extends TestCase
{
    private RecompenseNotes $service;

    protected function setUp(): void
    {
        $this->service = new RecompenseNotes();
    }

    // Branche récompense (>= 4.5) 

    public function testMoyenneExacte45ObtiendreRecompense(): void
    {
        $result = $this->service->evaluerRecompense(4.5);
        $this->assertSame("Récompense obtenue !", $result);
    }

    public function testMoyenneAuDessus45ObtiendreRecompense(): void
    {
        $result = $this->service->evaluerRecompense(5.0);
        $this->assertSame("Récompense obtenue !", $result);
    }

    // Branche encouragement (>= 4.0 et < 4.5) 

    public function testMoyenneExacte40Encouragement(): void
    {
        $result = $this->service->evaluerRecompense(4.0);
        $this->assertSame("Encore un effort pour obtenir une récompense.", $result);
    }

    public function testMoyenneEntre40Et45Encouragement(): void
    {
        $result = $this->service->evaluerRecompense(4.2);
        $this->assertSame("Encore un effort pour obtenir une récompense.", $result);
    }

    // Branche amélioration (< 4.0) 

    public function testMoyenneEnDessous40Amelioration(): void
    {
        $result = $this->service->evaluerRecompense(3.9);
        $this->assertSame("Il va falloir faire beaucoup d'efforts.", $result);
    }

    public function testMoyenneZeroAmelioration(): void
    {
        $result = $this->service->evaluerRecompense(0.0);
        $this->assertSame("Il va falloir faire beaucoup d'efforts.", $result);
    }
}