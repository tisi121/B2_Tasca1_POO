<?php
namespace App\Interfaces;

/** Defineix les operacions de reserva dels materials que les permeten. */
interface Reservable
{
    public function reservar(string $nomUsuari): bool;

    public function cancelarReserva(): bool;

    public function estaReservat(): bool;

    public function getUsuariReserva(): ?string;
}
