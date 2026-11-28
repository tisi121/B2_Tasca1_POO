# Biblioteca Digital

Aplicació web PHP per gestionar llibres, revistes, DVDs, usuaris, préstecs i reserves. Les classes es carreguen amb Composer i les dades es conserven a la sessió.

## Instal·lació i execució

Des de la carpeta `biblioteca/`:

```bash
composer install
php -S localhost:8000
```

Obriu `http://localhost:8000` al navegador. No cal cap base de dades.

## Pàgines

| URL | Funció |
| --- | --- |
| `index.php` | Resum de la biblioteca |
| `index.php?page=materials` | Llistat de materials |
| `index.php?page=materials&type=llibre` | Filtre per llibres; també `revista` i `dvd` |
| `index.php?page=material&id=1` | Detall i historial d'auditoria |
| `index.php?page=usuaris` | Llistat d'usuaris |
| `index.php?page=usuari&id=1` | Perfil amb préstecs actius |
| `index.php?page=usuari&id=1&action=prestecs` | Historial de préstecs |
| `index.php?page=prestec&material_id=2&usuari_id=1` | Fer un préstec |
| `index.php?page=retorn&material_id=1` | Retornar un material i veure la multa |
| `index.php?page=prestecs` | Préstecs actius i venciments |
| `index.php?page=reserva&material_id=9&usuari_id=1` | Reservar un llibre o DVD |
| `index.php?page=reserves` | Reserves actives |
| `index.php?page=estadistiques` | Estadístiques |
| `index.php?page=auditoria` | Historial d'accions de tots els materials |
| `index.php?page=demo_magic` | Exemples dels mètodes màgics |
| `index.php?page=demo_serialization` | Exemple de serialització d'un usuari |
| `index.php?page=demo_exceptions` | Comprova que cada operació genera l’excepció esperada |
| `index.php?page=demo_autoload` | Classes carregades de l'aplicació |
| `index.php?page=reset` | Reiniciar les dades de la sessió |

## Dades de demostració

La primera visita crea 4 llibres, 3 revistes, 3 DVDs, 4 usuaris, dos préstecs actius (un de vençut) i una reserva. La pàgina de préstecs permet retornar el préstec vençut del llibre amb ID 1.

## Decisions

- `PageRouter` separa la resolució de les pàgines de l’arrencada i el renderitzat.
- `Material` concentra les propietats i operacions comunes; cada subclasse calcula la seva multa.
- `Reservable` només s'implementa a `Llibre` i `DVD`.
- `Auditoria` comparteix l'historial entre els materials.
- La biblioteca es guarda a `$_SESSION`; l'autoloader de Composer es carrega abans de `session_start()`.

## Vídeo de demostració

Enllaç al vídeo de demostració: [Obrir vídeo a Google Drive](https://drive.google.com/drive/folders/1MxrnmCuMXSussB2o-tgX1zfGb3FQsUqS?usp=drive_link)
