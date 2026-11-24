<?php
namespace App\Traits;

/** Guarda les accions fetes sobre un material. */
trait Auditoria
{
    private array $historial = [];

    public function registrarAccio(string $accio, string $detalls = ''): void
    {
        $this->historial[] = [
            'data' => date('Y-m-d H:i:s'),
            'accio' => $accio,
            'detalls' => $detalls,
        ];
    }

    public function obtenirHistorial(): array
    {
        return $this->historial;
    }

    public function obtenirUltimaAccio(): ?array
    {
        if (count($this->historial) === 0) {
            return null;
        }

        return $this->historial[count($this->historial) - 1];
    }

    public function netejarHistorial(): void
    {
        $this->historial = [];
    }
}
