<?php
namespace App\Exceptions;

use Exception;

/** Indica que no es pot fer l'operació demanada sobre un material. */
class MaterialNoDisponibleException extends Exception
{
    private int $materialId;

    public function __construct(int $materialId, string $message = 'Material no disponible')
    {
        $this->materialId = $materialId;
        parent::__construct($message);
    }

    public function getMaterialId(): int
    {
        return $this->materialId;
    }

    public function __toString(): string
    {
        return "Error: el material amb ID {$this->materialId} no està disponible. {$this->getMessage()}";
    }
}
