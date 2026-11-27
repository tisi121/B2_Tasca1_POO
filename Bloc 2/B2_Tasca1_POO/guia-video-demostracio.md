# Guia del vídeo de demostració

El vídeo ha de durar aproximadament **2 minuts**, ser una gravació de pantalla **amb veu** i seguir els nou passos d'aquesta guia en ordre. No cal fer cap introducció: comença directament amb el terminal.

## Abans de gravar

1. Des de la carpeta `biblioteca/`, inicia el servidor i obre `http://localhost:8000/index.php?page=reset`.
2. Deixa que la pàgina et redirigeixi a l'inici amb les dades inicials. Atura aquest servidor de preparació.
3. Tanca les pestanyes que no necessitis i prepara el micròfon i la gravació de pantalla.
4. Quan comencis a gravar, repeteix les ordres del pas 1. **No tornis a reiniciar les dades durant el vídeo.**

## Guió de gravació

| Pas i temps | Què mostrar | Frase orientativa |
| --- | --- | --- |
| **1 · 10 s** | Al terminal, des de `biblioteca/`, executa `composer install` i `php -S localhost:8000`. Obre `http://localhost:8000/index.php`. | «Instal·lo les dependències i inicio l'aplicació. Aquesta és la pàgina inicial.» |
| **2 · 15 s** | Obre `http://localhost:8000/index.php?page=materials` per mostrar el catàleg complet. Filtra amb `http://localhost:8000/index.php?page=materials&type=dvd` i obre el detall del DVD 10 a `http://localhost:8000/index.php?page=material&id=10`. | «Aquí es veu el catàleg, el filtre de DVD i el detall d'un material.» |
| **3 · 15 s** | Presta el llibre 2 a l'usuari 4 amb `http://localhost:8000/index.php?page=prestec&material_id=2&usuari_id=4`. Després obre el perfil `http://localhost:8000/index.php?page=usuari&id=4`. | «Presto *El nom de la rosa* a Pau Ferrer i comprovo el préstec al seu perfil.» |
| **4 · 10 s** | Intenta prestar el mateix llibre a l'usuari 1: `http://localhost:8000/index.php?page=prestec&material_id=2&usuari_id=1`. Mostra el missatge d'error. | «El llibre ja està prestat; per això es mostra l'error de material no disponible.» |
| **5 · 10 s** | Retorna el préstec vençut inicial amb `http://localhost:8000/index.php?page=retorn&material_id=1` i mostra la multa. | «Retorno *La plaça del Diamant*, que és el préstec vençut de les dades inicials, i aquí es veu la multa.» |
| **6 · 15 s** | Reserva el DVD 10 per a l'usuari 4 amb `http://localhost:8000/index.php?page=reserva&material_id=10&usuari_id=4`. Després prova de reservar la revista 5: `http://localhost:8000/index.php?page=reserva&material_id=5&usuari_id=4`, i mostra l'excepció. | «La reserva del DVD funciona. La revista no es pot reservar i l'aplicació mostra l'error corresponent.» |
| **7 · 10 s** | Mostra `http://localhost:8000/index.php?page=estadistiques` i `http://localhost:8000/index.php?page=auditoria`. | «Aquestes pàgines mostren les estadístiques i l'historial d'auditoria.» |
| **8 · 15 s** | Mostra `http://localhost:8000/index.php?page=demo_magic` i `http://localhost:8000/index.php?page=demo_serialization`. | «Aquestes dues demostracions ensenyen els mètodes màgics i la serialització d'un usuari.» |
| **9 · 20 s** | Obre `biblioteca/src/Models/Biblioteca.php` i localitza `__call()`. Explica'l amb les teves paraules. | «Quan es crida un mètode que no existeix, PHP executa `__call()` amb el nom i els arguments. El `match` selecciona l'acció dels getters disponibles; si el nom no coincideix amb cap cas, llança una `BadMethodCallException`.» |

Els temps sumen **120 segons**. Mantén les transicions ràpides i segueix l'ordre de la taula perquè es puguin avaluar tots els apartats.

## Després de gravar

- Penja el vídeo a YouTube com a **no llistat** o a Google Drive amb accés per al compte de l'institut.
- No pugis el vídeo al repositori.
- Afegeix l'enllaç del vídeo al `README.md` i lliura un sol enllaç al repositori a la tasca.
