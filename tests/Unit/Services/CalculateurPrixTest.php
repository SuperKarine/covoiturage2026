<?php
namespace Tests\Unit\Services;


use PHPUnit\Framework\TestCase;
use Services\CalculateurPrix;


class CalculateurPrixTest extends TestCase
{
    private CalculateurPrix $calculateur;

    protected function setUp(): void
    {
        $this->calculateur = new CalculateurPrix();
    }

    // Calculs nominaux 

    public function testCalculAvec1Place(): void
    {
        // 100 km, 1 place : (2.00 + 100 * 0.08) * (1 - 0) = 10.00€
        $result = $this->calculateur->calculer(100, 1);
        $this->assertSame(10.00, $result);
    }

    public function testCalculAvec2Places(): void
    {
        // 100 km, 2 places : 10.00 * 0.95 = 9.50€
        $result = $this->calculateur->calculer(100, 2);
        $this->assertSame(9.50, $result);
    }

    public function testCalculAvec3Places(): void
    {
        // 100 km, 3 places : 10.00 * 0.90 = 9.00€
        $result = $this->calculateur->calculer(100, 3);
        $this->assertSame(9.00, $result);
    }

    public function testCalculAvec4Places(): void
    {
        // 100 km, 4 places : 10.00 * 0.85 = 8.50€
        $result = $this->calculateur->calculer(100, 4);
        $this->assertSame(8.50, $result);
    }

    // Trajets bdd

    public function testCalculPariLyon(): void
    {
        // 465 km, 3 places : (2.00 + 465 * 0.08) * 0.90 = 35.28€
        $result = $this->calculateur->calculer(465, 3);
        $this->assertSame(35.28, $result);
    }

    // Arrondi 

    public function testResultatArrondiA2Decimales(): void
    {
        // 77 km, 2 places : (2.00 + 6.16) * 0.95 = 7.752 → 7.75€
        $result = $this->calculateur->calculer(77, 2);
        $this->assertSame(7.75, $result);
    }

    //  Comportement limite 

    public function testNombrePlacesInvalideAppliqueAucuneReduction(): void
    {
        // 5 places n'existe pas dans le tableau → ?? 0 → pas de réduction
        $resultAvec5 = $this->calculateur->calculer(100, 5);
        $resultAvec1 = $this->calculateur->calculer(100, 1);
        $this->assertSame($resultAvec1, $resultAvec5);
    }

    public function testKmFlottant(): void
    {
        // 100.5 km, 1 place : (2.00 + 100.5 * 0.08) = 10.04€
        $result = $this->calculateur->calculer(100.5, 1);
        $this->assertSame(10.04, $result);
    }
}