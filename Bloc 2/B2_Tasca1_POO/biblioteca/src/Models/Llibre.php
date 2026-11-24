<?php
namespace App\Models;

use App\Interfaces\Reservable;

/** Representa un llibre que es pot prestar i reservar. */
class Llibre extends Material implements Reservable
{
    private int $numeroPagines;
    private ?string $usuariReserva = null;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroPagines
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroPagines($numeroPagines);
    }

    public function calcularMulta(int $diesRetard): float
    {
        return max(0, $diesRetard) * 0.50;
    }

    public function getTipus(): string
    {
        return 'Llibre';
    }

    public function getNumeroPagines(): int
    {
        return $this->numeroPagines;
    }

    public function setNumeroPagines(int $pagines): void
    {
        if ($pagines <= 0) {
            throw new \InvalidArgumentException('El nombre de pàgines ha de ser més gran que zero');
        }

        $this->numeroPagines = $pagines;
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
