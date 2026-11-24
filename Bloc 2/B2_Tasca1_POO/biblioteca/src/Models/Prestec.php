<?php
namespace App\Models;

use DateTime;

/** Representa el préstec d'un material a un usuari. */
class Prestec
{
    private DateTime $dataPrestec;
    private ?DateTime $dataRetorn = null;

    public function __construct(
        private Material $material,
        private Usuari $usuari,
        private int $diesLimitPrestec = 14,
        ?DateTime $dataPrestec = null
    ) {
        $this->dataPrestec = $dataPrestec ?? new DateTime();
    }

    public function retornar(): void
    {
        if ($this->dataRetorn === null) {
            $this->dataRetorn = new DateTime();
        }
    }

    public function estaActiu(): bool
    {
        return $this->dataRetorn === null;
    }

    public function calcularDiesRetard(): int
    {
        return max(0, $this->calcularDiesTranscorreguts() - $this->diesLimitPrestec);
    }

    public function calcularMulta(): float
    {
        return $this->material->calcularMulta($this->calcularDiesRetard());
    }

    public function estaVencut(): bool
    {
        return $this->calcularDiesRetard() > 0;
    }

    public function getDiesPendents(): int
    {
        return $this->diesLimitPrestec - $this->calcularDiesTranscorreguts();
    }

    private function calcularDiesTranscorreguts(): int
    {
        $dataFinal = $this->dataRetorn ?? new DateTime();
        $diferencia = $this->dataPrestec->diff($dataFinal);

        if ($diferencia->invert === 1) {
            return 0;
        }

        return (int) $diferencia->days;
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getUsuari(): Usuari
    {
        return $this->usuari;
    }

    public function getDataPrestec(): DateTime
    {
        return $this->dataPrestec;
    }

    public function getDataRetorn(): ?DateTime
    {
        return $this->dataRetorn;
    }

    public function getDiesLimitPrestec(): int
    {
        return $this->diesLimitPrestec;
    }
}
