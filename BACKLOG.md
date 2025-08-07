# 📝 Backlog - ORBIXUP: Digital Premium Infrastructure

Ce fichier suit les fonctionnalités et tâches à faire pour le développement du projet `ORBIXUP: Digital Premium Ingrastructure`

---

## 📌 Légende des statuts

-   ✅ : Terminé
-   🚧 : En cours
-   🕓 : À faire
-   🔥 : Prioritaire

---

## 🚀 Épopée 1 : Authentification

| Tâche                               | Priorité | Statut | Notes                                                       |
| ----------------------------------- | -------- | ------ | ----------------------------------------------------------- |
| Créer entité `User` avec JWT        | 🔥       | ✅     | Utilise LexikJWTAuthenticationBundle                        |
| Créer entité `Client` liée à `User` | 🔥       | ✅     | Relation OneToOne                                           |
| Implémenter `/api/login`            | 🔥       | ✅     | JSON Login + JWT                                            |
| Protéger les routes `/api/client/*` | 🔥       | 🕓     | ROLE_CLIENT                                                 |
| Endpoint `/api/client/me`           | 🔥       | ✅     | Affiche données du client connecté                          |
| Ajout 2FA avec Google Authenticator | 🕓       | 🚧     | Se connecter avec son compte Google et vérification d'email |
| Système de mot de passe oublié      | 🕓       | ✅     | Envoyer un email lorsque l'on oublie son mot de passe       |

---

## 🛠️ Épopée 2 : Abonnement

| Tâche                                       | Priorité | Statut | Notes                                      |
| ------------------------------------------- | -------- | ------ | ------------------------------------------ |
| Liste des services                          | 🔥       | 🚧     | CRUD pour les services                     |
| Liste des packs pour un ensemble de service | 🔥       | 🕓     | Generation des packs à partir des services |

---

## 🛠️ Épopée 3 : Branding

| Tâche                                                                           | Priorité | Statut | Notes                                                   |
| ------------------------------------------------------------------------------- | -------- | ------ | ------------------------------------------------------- |
| Génération de la liste des brandings appartenant à un client spécifique         | 🔥       | ✅     |                                                         |
| Mise en place de la liste des logos à partir d'un projet de branding spécifique | 🔥       | ✅     |                                                         |
| Création d'un prompt pour générer le logo                                       | 🔥       | ✅     |                                                         |
| Génération de logo à partir d'une IA (ex: GEMINI)                               | 🔥       | ✅     | Générer à partir des informations entrés par le client  |
| Génération de plusieurs logos à partir d'une requête de l'utilisateur (ex: 4)   | 🔥       | 🕓     |                                                         |
| Mettre en place un système de feedback par logo                                 | 🔥       | 🚧     | un petit système de commentaire pour chaque logo généré |
| Endpoint pour chaque fonctionnalité                                             | 🔥       | 🚧     | Création des routes pour chaque fonctionnalité          |
| Protéger les endpoints par rapport au client                                    | 🔥       | 🚧     |                                                         |
| Persister l'historique des prompts lors du génération des logos                 | 🕓       | 🕓     |                                                         |

---

## 🛠️ Épopée 4 : Portail Client

| Tâche                             | Priorité | Statut | Notes                            |
| --------------------------------- | -------- | ------ | -------------------------------- |
| Affichage tableau de bord client  | 🔥       | 🕓     | Inclure données de l'utilisateur |
| Ajouter gestion de profil client  | 🔥       | 🕓     | Modifier nom, entreprise, etc.   |
| Afficher historique des commandes | 🕓       | 🕓     | Requiert entité Order            |
| Ajout avatar/photo de profil      | 🕓       | 🕓     | Upload avec VichUploaderBundle   |

## 🛠️ Épopée 5 : Mise en place du système de paiement

| Tâche                                                    | Priorité | Statut | Notes                                             |
| -------------------------------------------------------- | -------- | ------ | ------------------------------------------------- |
| Utilisation de `Cybersource` pour le système de paiement | 🔥       | 🕓     | Utiliser `cybersource` pour les paiement en ligne |

## ⚙️ Épopée 6 : Administration

| Tâche                             | Priorité | Statut | Notes                     |
| --------------------------------- | -------- | ------ | ------------------------- |
| Créer entité `Admin`              | 🕓       | 🕓     | Utilise même table `user` |
| Accès au back-office `/admin`     | 🕓       | 🕓     | ROLE_ADMIN                |
| Voir liste des clients            | 🕓       | 🕓     | Données paginées          |
| Supprimer un client (soft delete) | 🕓       | 🕓     | Ajouter champ `deletedAt` |

---

## 🐞 Bugs connus

| Bug                                               | Statut | Notes                     |
| ------------------------------------------------- | ------ | ------------------------- |
| L’authentification échoue si mauvais mot de passe | ✅     | Géré par handler LexikJWT |
| Mise en place du docker sur le projet             | ✅     | En cours de résolution    |

---

## 📌 Idées futures (non priorisées)

-   Multilingue : FR / EN
-   Mobile-friendly portail client
-   Mise en place d'un système de notification pour l'utilisateur
-   Utilisation de MVola Api pour le paiement en local
-   Créer un système de remboursement si non satisfait des offres
