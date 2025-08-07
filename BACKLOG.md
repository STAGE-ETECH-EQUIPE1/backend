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
| Protéger les routes `/api/client/*` | 🔥       | ✅     | ROLE_CLIENT                                                 |
| Endpoint `/api/client/me`           | 🔥       | ✅     | Affiche données du client connecté                          |
| Ajout 2FA avec Google Authenticator | 🕓       | ✅     | Se connecter avec son compte Google et vérification d'email |
| Système de mot de passe oublié      | 🕓       | ✅     | Envoyer un email lorsque l'on oublie son mot de passe       |

---

## 🛠️ Épopée 2 : Abonnement

| Tâche                                       | Priorité | Statut | Notes                                      |
| ------------------------------------------- | -------- | ------ | ------------------------------------------ |
| Liste des services                          | 🔥       | 🚧     | CRUD pour les services                     |
| Liste des packs pour un ensemble de service | 🔥       | 🕓     | Generation des packs à partir des services |

---

## 🛠️ Épopée 3 : Branding

| Tâche                                                                           | Priorité | Statut | Notes                                                     |
| ------------------------------------------------------------------------------- | -------- | ------ | --------------------------------------------------------- |
| Génération de la liste des brandings appartenant à un client spécifique         | 🔥       | ✅     |                                                           |
| Mise en place de la liste des logos à partir d'un projet de branding spécifique | 🔥       | ✅     |                                                           |
| Création d'un prompt pour générer le logo                                       | 🔥       | ✅     | Un petit texte à donner l'IA pour créer un logo           |
| Génération de logo à partir d'une IA (ex: GEMINI)                               | 🔥       | ✅     | Générer à partir des informations entrés par le client    |
| Génération de plusieurs logos à partir d'une requête de l'utilisateur (ex: 4)   | 🔥       | 🚧     | Peut-être appeler l'api de génération `n fois`            |
| Mettre en place un système de feedback par logo                                 | 🔥       | ✅     | un petit système de commentaire pour chaque logo généré   |
| Protéger les endpoints par rapport au client                                    | 🔥       | 🚧     | création de `voter` pour la sécurité                      |
| Envoyer en temps réel les logos générés vers le frontend                        | 🔥       | 🚧     | Utilisation de `Mercure` pour l'envoi des liens des logos |
| Persister l'historique des prompts lors du génération des logos                 | 🕓       | 🕓     | Création d'un table pour sauvegarder l'historique         |

---

## 🛠️ Épopée 4 : Portail Client

| Tâche                                             | Priorité | Statut | Notes                            |
| ------------------------------------------------- | -------- | ------ | -------------------------------- |
| Affichage tableau de bord client                  | 🔥       | 🕓     | Inclure données de l'utilisateur |
| Ajouter gestion de profil client                  | 🔥       | 🕓     | Modifier nom, entreprise, etc.   |
| Afficher historique des commandes                 | 🕓       | 🕓     | Requiert entité Order            |
| Ajout du modification de mot de passe utilisateur | 🕓       | 🕓     |                                  |
| Visualisation de la liste des projets de branding | 🕓       | 🕓     |                                  |

## 🛠️ Épopée 5 : Mise en place du système de paiement

| Tâche                                                    | Priorité | Statut | Notes                                              |
| -------------------------------------------------------- | -------- | ------ | -------------------------------------------------- |
| Utilisation de `Cybersource` pour le système de paiement | 🔥       | 🕓     | Utiliser `cybersource` pour les paiements en ligne |
| Utilisation de `Api MVola` pour le système de paiement   | 🕓       | 🕓     | Utiliser `Api MVola` pour les paiements            |

## ⚙️ Épopée 6 : Administration

| Tâche                                                 | Priorité | Statut | Notes                     |
| ----------------------------------------------------- | -------- | ------ | ------------------------- |
| Créer entité `Admin` en relation avec l'entité `User` | 🔥       | 🕓     | Utilise même table `user` |
| Accès au back-office `/api/admin`                     | 🔥       | 🕓     | ROLE_ADMIN                |
| Voir liste des clients                                | 🔥       | 🕓     | Données paginées          |
| Supprimer un client (soft delete)                     | 🔥       | 🕓     | Ajouter champ `deletedAt` |

---

## 🐞 Bugs connus

| Bug                                        | Statut | Notes |
| ------------------------------------------ | ------ | ----- |
| choix d'API pour la génération de `n logo` | 🔥     | 🚧    |

---

## 📌 Idées futures (non priorisées)

-   Mise en place d'un système de notification pour l'utilisateur
-   Créer un système de remboursement si non satisfait des offres
-   Ajout avatar/photo de profil
