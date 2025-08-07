# ORBIXUP

## Installation du projet

1.  Prérequis

    -   [Php](https://www.php.net/)
    -   [Composer](https://getcomposer.org/)
    -   [MakeGNU](https://www.gnu.org/software/make/manual/make.html)
    -   Base de données: `PostgreSQL`
    -   [Docker](https://www.docker.com/)

Pour l'installation du projet,
configurer le fichier d'environnement `.env` ou créer un nouveau fichier `.env.local`
conforme avant d'éxecuter ce code

2.  Installation

 - En production :

```bash
make install
```

 - En développement

```bash
make init
```

## Pour lancer le serveur de développement

1. Docker

Veuillez avant tout décommenter la ligne qui requiert docker commen ligne de commande

```bash
make dev
```

2. En local

```bash
make serve
```

[Lien vers le projet](http://127.0.0.1:8000/api)

3. Fonctionnalités

-   Endpoint

`/api`: pour la documentation des api
