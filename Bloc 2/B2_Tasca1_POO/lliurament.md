# Lliurament — Biblioteca Digital

## Resum

S’ha creat una aplicació web PHP orientada a objectes per gestionar materials, usuaris, préstecs, reserves, estadístiques i auditoria. La biblioteca queda guardada a la sessió i les classes es carreguen amb Composer i PSR-4.

## Fitxers

El projecte complet és a la carpeta `biblioteca/`. Inclou el router `index.php`, les vistes, les classes de `src/`, el `composer.json`, el `.gitignore` i el `README.md`.

## Execució

Des de `Bloc 2/B2_Tasca1_POO/biblioteca/`, executeu:

```bash
composer install
php -S localhost:8000
```

Obriu `http://localhost:8000`. Les rutes disponibles i les seves funcions estan descrites al `README.md` del projecte.

## Validació

- `composer install` ha generat correctament l’autoloader.
- `php -l` ha validat els fitxers PHP del projecte.
- Les proves amb PHP han comprovat les dades inicials, el préstec vençut, la serialització, el canvi de reserva a préstec i les excepcions.
- El servidor PHP ha respost correctament a les pàgines principals, demos i operacions de préstec, reserva, retorn amb multa i reinici.
- No cal cap base de dades ni dependència externa.

## Pendents

- Afegir al `README.md` l’enllaç real del vídeo de demostració; encara no s’ha gravat.
- Publicar el projecte en un repositori Git i afegir-hi l’historial de commits requerit per l’enunciat.
