<?php
namespace App\Models;

use App\Interfaces\Reservable;

/** Representa un DVD que es pot prestar i reservar. */
class DVD extends Material implements Reservable
{
    private int $duracio;
    private ?string $usuariReserva = null;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $duracio
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setDuracio($duracio);
    }

    public function calcularMulta(int $diesRetard): float
    {
        return max(0, $diesRetard) * 1.00;
    }

    public function getTipus(): string
    {
        return 'DVD';
    }

    public function getDuracio(): int
    {
        return $this->duracio;
    }

    public function setDuracio(int $minuts): void
    {
        if ($minuts <= 0) {
            throw new \InvalidArgumentException('La duració ha de ser més gran que zero');
        }

        $this->duracio = $minuts;
    }

    public function getDuracioFormatada(): string
    {
        $hores = intdiv($this->duracio, 60);
        $minuts = $this->duracio % 60;

        return sprintf('%dh %02dmin', $hores, $minuts);
    }

    public function reservar(string $nomUsuari): bool
    {
        if ($this->usuariReserva !== null) {
            return false;
        }

        $this->usuariReserva = $nomUsuari;
        $this->registrarAccio('reservat', $nomUsuari);
        return true;
    }

    public function cancelarReserva(): bool
    {
        if ($this->usuariReserva === null) {
            return false;
        }

        $nomUsuari = $this->usuariReserva;
        $this->usuariReserva = null;
        $this->registrarAccio('reserva_cancel·lada', $nomUsuari);
        return true;
    }

    public function estaReservat(): bool
    {
        return $this->usuariReserva !== null;
    }

    public function getUsuariReserva(): ?string
    {
        return $this->usuariReserva;
    }
}
