# Projet de stage

1. Installation du projet

Pour l'installation du projet (Configurer le fichier d'environnement avant d'éxecuter ce code)

```bash
make install
```

OU

```bash
composer install
php bin/console lexik:jwt:generate-keypair # Générer une clé pour le token jwt
pho bin/console doctrine:database:create --if-not-exists
```

2. Pour lancer le serveur de développement

```bash
symfony serve
```

OU

```bash
make dev
```
