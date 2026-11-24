<?php
namespace App\Models;

use App\Exceptions\EmailInvalidException;
use DateTime;
use LogicException;

/** Guarda les dades i els préstecs d'un usuari de la biblioteca. */
class Usuari
{
    private int $id;
    private string $nom;
    private string $email;
    private array $materialsPrestats = [];
    private DateTime $dataRegistre;
    private array $notificacions = [];

    public function __construct(int $id, string $nom, string $email)
    {
        if (!$this->validarEmail($email)) {
            throw new EmailInvalidException('El correu electrònic no és vàlid');
        }

        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->dataRegistre = new DateTime();
    }

    public function __get(string $propietat): mixed
    {
        if (in_array($propietat, ['id', 'nom', 'email', 'dataRegistre'], true)) {
            return $this->$propietat;
        }

        return null;
    }

    public function __set(string $propietat, mixed $valor): void
    {
        if ($propietat !== 'email') {
            throw new LogicException("No es pot modificar la propietat {$propietat}");
        }

        if (!is_string($valor) || !$this->validarEmail($valor)) {
            throw new EmailInvalidException('El correu electrònic no és vàlid');
        }

        $this->email = $valor;
    }

    public function __sleep(): array
    {
        return [
            "\0App\Models\Usuari\0id",
            "\0App\Models\Usuari\0nom",
            "\0App\Models\Usuari\0email",
            "\0App\Models\Usuari\0materialsPrestats",
            "\0App\Models\Usuari\0dataRegistre",
        ];
    }

    public function __wakeup(): void
    {
        $this->notificacions = [];
    }

    public function __toString(): string
    {
        $quantitat = $this->getNumeroMaterialsPrestats();

        return "{$this->nom} <{$this->email}> - {$quantitat} préstecs";
    }

    public function afegirPrestec(Material $material): void
    {
        $this->materialsPrestats[$material->getId()] = $material;
    }

    public function eliminarPrestec(int $materialId): void
    {
        unset($this->materialsPrestats[$materialId]);
    }

    public function getMaterialsPrestats(): array
    {
        return array_values($this->materialsPrestats);
    }

    public function getNumeroMaterialsPrestats(): int
    {
        return count($this->materialsPrestats);
    }

    public function afegirNotificacio(string $missatge): void
    {
        $this->notificacions[] = $missatge;
    }

    public function obtenirNotificacions(): array
    {
        $notificacions = $this->notificacions;
        $this->notificacions = [];

        return $notificacions;
    }

    private function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDataRegistre(): DateTime
    {
        return $this->dataRegistre;
    }
}
