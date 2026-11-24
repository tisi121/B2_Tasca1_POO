<?php
namespace App\Data;

use App\Models\Biblioteca;
use App\Models\DVD;
use App\Models\Llibre;
use App\Models\Revista;
use App\Models\Usuari;
use DateTime;

/** Crea les dades inicials per poder provar totes les pàgines. */
class DataGenerator
{
    public static function crear(): Biblioteca
    {
        $biblioteca = new Biblioteca('Biblioteca Digital');

        $materials = [
            new Llibre(1, 'La plaça del Diamant', 'Mercè Rodoreda', 1962, 256),
            new Llibre(2, 'El nom de la rosa', 'Umberto Eco', 1980, 592),
            new Llibre(3, 'Solitud', 'Víctor Català', 1905, 304),
            new Llibre(4, 'Mirall trencat', 'Mercè Rodoreda', 1974, 384),
            new Revista(5, 'National Geographic', 'Diversos autors', 2024, 128),
            new Revista(6, 'Sàpiens', 'Diversos autors', 2023, 262),
            new Revista(7, 'Muy Interesante', 'Diversos autors', 2022, 491),
            new DVD(8, 'Pa negre', 'Agustí Villaronga', 2010, 108),
            new DVD(9, 'La lengua de las mariposas', 'José Luis Cuerda', 1999, 97),
            new DVD(10, 'El viatge de Chihiro', 'Hayao Miyazaki', 2001, 125),
        ];

        foreach ($materials as $material) {
            $biblioteca->afegirMaterial($material);
        }

        $usuaris = [
            new Usuari(1, 'Anna Puig', 'anna@mail.com'),
            new Usuari(2, 'Marc Soler', 'marc@mail.com'),
            new Usuari(3, 'Júlia Costa', 'julia@mail.com'),
            new Usuari(4, 'Pau Ferrer', 'pau@mail.com'),
        ];

        foreach ($usuaris as $usuari) {
            $biblioteca->afegirUsuari($usuari);
        }

        $biblioteca->prestarMaterial(1, 1, new DateTime('-40 days'));
        $biblioteca->prestarMaterial(8, 2);
        $biblioteca->reservarMaterial(9, 3);

        return $biblioteca;
    }
}
