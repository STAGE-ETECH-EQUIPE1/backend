# 📝 Backlog - Portail Client Symfony

Ce fichier suit les fonctionnalités et tâches à faire pour le développement du portail client.

---

## 📌 Légende des statuts

-   ✅ : Terminé
-   🚧 : En cours
-   🕓 : À faire
-   🔥 : Prioritaire

---

## 🚀 Épopée 1 : Authentification

| Tâche                               | Priorité | Statut | Notes                                |
| ----------------------------------- | -------- | ------ | ------------------------------------ |
| Créer entité `User` avec JWT        | 🔥       | ✅     | Utilise LexikJWTAuthenticationBundle |
| Créer entité `Client` liée à `User` | 🔥       | ✅     | Relation OneToOne                    |
| Implémenter `/api/login`            | 🔥       | ✅     | JSON Login + JWT                     |
| Protéger les routes `/api/client/*` | 🔥       | ✅     | ROLE_CLIENT                          |
| Endpoint `/api/client/me`           | 🔥       | 🚧     | Affiche données du client connecté   |

---

## 🛠️ Épopée 2 : Portail Client

| Tâche                             | Priorité | Statut | Notes                            |
| --------------------------------- | -------- | ------ | -------------------------------- |
| Affichage tableau de bord client  | 🔥       | 🕓     | Inclure données de l'utilisateur |
| Ajouter gestion de profil client  | 🔥       | 🕓     | Modifier nom, entreprise, etc.   |
| Afficher historique des commandes | 🕓       | 🕓     | Requiert entité Order            |
| Ajout avatar/photo de profil      | 🕓       | 🕓     | Upload avec VichUploaderBundle   |

---

## ⚙️ Épopée 3 : Administration

| Tâche                             | Priorité | Statut | Notes                     |
| --------------------------------- | -------- | ------ | ------------------------- |
| Créer entité `Admin`              | 🕓       | 🕓     | Utilise même table `user` |
| Accès au back-office `/admin`     | 🕓       | 🕓     | ROLE_ADMIN                |
| Voir liste des clients            | 🕓       | 🕓     | Données paginées          |
| Supprimer un client (soft delete) | 🕓       | 🕓     | Ajouter champ `deletedAt` |

---

## 🐞 Bugs connus

| Bug                                               | Statut | Notes                  |
| ------------------------------------------------- | ------ | ---------------------- |
| L’authentification échoue si mauvais mot de passe | ✅     | Géré par handler Lexik |
| Problème CORS avec React en local                 | 🚧     | En cours de résolution |

---

## 📌 Idées futures (non priorisées)

-   Intégrer envoi d’e-mails (reset password, confirmation)
-   Ajout 2FA avec Google Authenticator
-   Multilingue : FR / EN / AR
-   Mobile-friendly portail client
