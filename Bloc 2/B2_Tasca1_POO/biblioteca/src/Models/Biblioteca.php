<?php
namespace App\Models;

use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoPrestatException;
use App\Exceptions\MaterialNoTrobatException;
use App\Exceptions\UsuariNoTrobatException;
use App\Interfaces\Reservable;
use DateTime;

/** Gestiona els materials, usuaris, préstecs i reserves. */
class Biblioteca
{
    private array $materials = [];
    private array $usuaris = [];
    private array $prestecs = [];

    public function __construct(private string $nom)
    {
    }

    public function afegirMaterial(Material $material): void
    {
        $this->materials[$material->getId()] = $material;
    }

    public function eliminarMaterial(int $id): bool
    {
        if (!isset($this->materials[$id])) {
            return false;
        }

        unset($this->materials[$id]);
        return true;
    }

    public function cercarPerId(int $id): ?Material
    {
        return $this->materials[$id] ?? null;
    }

    public function cercarPerTitol(string $titol): array
    {
        return array_values(array_filter($this->materials, function (Material $material) use ($titol): bool {
            return stripos($material->getTitol(), $titol) !== false;
        }));
    }

    public function cercarPerAutor(string $autor): array
    {
        return array_values(array_filter($this->materials, function (Material $material) use ($autor): bool {
            return stripos($material->getAutor(), $autor) !== false;
        }));
    }

    public function llistarDisponibles(): array
    {
        return array_values(array_filter($this->materials, function (Material $material): bool {
            return $material->isDisponible();
        }));
    }

    public function llistarPrestats(): array
    {
        return array_values(array_filter($this->materials, function (Material $material): bool {
            return !$material->isDisponible();
        }));
    }

    public function llistarPerTipus(string $tipus): array
    {
        return array_values(array_filter($this->materials, function (Material $material) use ($tipus): bool {
            return $material->getTipus() === $tipus;
        }));
    }

    public function llistarPrestecsActius(): array
    {
        return array_values(array_filter($this->prestecs, function (Prestec $prestec): bool {
            return $prestec->estaActiu();
        }));
    }

    public function llistarReserves(): array
    {
        return array_values(array_filter($this->materials, function (Material $material): bool {
            return $material instanceof Reservable && $material->estaReservat();
        }));
    }

    public function llistarPrestecsUsuari(int $usuariId): array
    {
        return array_values(array_filter($this->prestecs, function (Prestec $prestec) use ($usuariId): bool {
            return $prestec->getUsuari()->getId() === $usuariId;
        }));
    }

    public function afegirUsuari(Usuari $usuari): void
    {
        $this->usuaris[$usuari->getId()] = $usuari;
    }

    public function cercarUsuari(int|string $identificador): ?Usuari
    {
        if (is_int($identificador)) {
            return $this->usuaris[$identificador] ?? null;
        }

        foreach ($this->usuaris as $usuari) {
            if (strcasecmp($usuari->getNom(), $identificador) === 0) {
                return $usuari;
            }
        }

        return null;
    }

    public function prestarMaterial(int $materialId, int $usuariId, ?DateTime $dataPrestec = null): Prestec
    {
        $material = $this->cercarPerId($materialId);
        if ($material === null) {
            throw new MaterialNoTrobatException("No existeix cap material amb ID {$materialId}");
        }

        $usuari = $this->cercarUsuari($usuariId);
        if ($usuari === null) {
            throw new UsuariNoTrobatException("No existeix cap usuari amb ID {$usuariId}");
        }

        if ($material instanceof Reservable && $material->estaReservat()
            && strcasecmp((string) $material->getUsuariReserva(), $usuari->getNom()) !== 0) {
            throw new MaterialNoDisponibleException($materialId, 'El material està reservat per un altre usuari');
        }

        if (!$material->isDisponible()) {
            throw new MaterialNoDisponibleException($materialId, 'El material ja està prestat');
        }

        if ($material instanceof Reservable && $material->estaReservat()) {
            $material->cancelarReserva();
        }

        if (!$material->prestar()) {
            throw new MaterialNoDisponibleException($materialId, 'El material ja està prestat');
        }

        $prestec = new Prestec($material, $usuari, 14, $dataPrestec);
        $this->prestecs[] = $prestec;
        $usuari->afegirPrestec($material);
        $usuari->afegirNotificacio("Préstec realitzat: {$material->getTitol()}");

        return $prestec;
    }

    public function retornarMaterial(int $materialId): float
    {
        $material = $this->cercarPerId($materialId);
        if ($material === null) {
            throw new MaterialNoTrobatException("No existeix cap material amb ID {$materialId}");
        }

        foreach ($this->prestecs as $prestec) {
            if ($prestec->getMaterial()->getId() === $materialId && $prestec->estaActiu()) {
                $prestec->retornar();
                $multa = $prestec->calcularMulta();
                $material->retornar();
                $prestec->getUsuari()->eliminarPrestec($materialId);
                $prestec->getUsuari()->afegirNotificacio("Material retornat: {$material->getTitol()}");
                return $multa;
            }
        }

        throw new MaterialNoPrestatException("El material amb ID {$materialId} no tenia cap préstec actiu");
    }

    public function reservarMaterial(int $materialId, int $usuariId): bool
    {
        $material = $this->cercarPerId($materialId);
        if ($material === null) {
            throw new MaterialNoTrobatException("No existeix cap material amb ID {$materialId}");
        }

        if (!$material instanceof Reservable) {
            throw new MaterialNoDisponibleException($materialId, 'Les revistes no es poden reservar');
        }

        $usuari = $this->cercarUsuari($usuariId);
        if ($usuari === null) {
            throw new UsuariNoTrobatException("No existeix cap usuari amb ID {$usuariId}");
        }

        $reservada = $material->reservar($usuari->getNom());
        if ($reservada) {
            $usuari->afegirNotificacio("Reserva realitzada: {$material->getTitol()}");
        }

        return $reservada;
    }

    public function __call(string $metode, array $arguments): mixed
    {
        return match ($metode) {
            'getLlibres' => $this->llistarPerTipus('Llibre'),
            'getRevistes' => $this->llistarPerTipus('Revista'),
            'getDVDs' => $this->llistarPerTipus('DVD'),
            'getMaterials' => array_values($this->materials),
            'getUsuaris' => array_values($this->usuaris),
            'getNom' => $this->nom,
            default => throw new \BadMethodCallException("El mètode {$metode} no existeix"),
        };
    }

    public function obtenirEstadistiques(): array
    {
        $perTipus = [
            'Llibre' => count($this->llistarPerTipus('Llibre')),
            'Revista' => count($this->llistarPerTipus('Revista')),
            'DVD' => count($this->llistarPerTipus('DVD')),
        ];

        $multesPendents = 0.0;
        foreach ($this->llistarPrestecsActius() as $prestec) {
            $multesPendents += $prestec->calcularMulta();
        }

        return [
            'total' => count($this->materials),
            'disponibles' => count($this->llistarDisponibles()),
            'prestats' => count($this->llistarPrestats()),
            'reservats' => count($this->llistarReserves()),
            'perTipus' => $perTipus,
            'multesPendents' => $multesPendents,
        ];
    }
}
