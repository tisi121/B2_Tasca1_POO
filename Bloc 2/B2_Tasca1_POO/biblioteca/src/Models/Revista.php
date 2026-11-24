<?php
namespace App\Models;

/** Representa una revista, que no admet reserves. */
class Revista extends Material
{
    private int $numeroEdicio;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroEdicio
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroEdicio($numeroEdicio);
    }

    public function calcularMulta(int $diesRetard): float
    {
        return max(0, $diesRetard) * 0.25;
    }

    public function getTipus(): string
    {
        return 'Revista';
    }

    public function getNumeroEdicio(): int
    {
        return $this->numeroEdicio;
    }

    public function setNumeroEdicio(int $numero): void
    {
        if ($numero <= 0) {
            throw new \InvalidArgumentException('El número d’edició ha de ser més gran que zero');
        }

        $this->numeroEdicio = $numero;
    }
}
