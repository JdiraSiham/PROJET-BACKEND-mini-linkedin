# PROJET-BACKEND-mini-linkedin
API REST de plateforme de recrutement inspirée de LinkedIn, développée avec **Laravel 10** et authentification **JWT**.
---
## Description
Ce projet permet de gérer une plateforme de recrutement avec plusieurs rôles :
* **Candidat** : crée un profil, ajoute des compétences, postule aux offres
* **Recruteur** : publie des offres et gère les candidatures
* **Admin** : gère les utilisateurs et les offres
---
## Technologies utilisées
* Laravel 10
* PHP 8+
* MySQL
* JWT Authentication
* Eloquent ORM
---
## Fonctionnalités principales
### Authentification
* Inscription / Connexion (JWT)
* Gestion des rôles (candidat, recruteur, admin)
### Profil candidat
* Création et mise à jour du profil
* Ajout / suppression de compétences
### Offres d'emploi
* Création d’offres (recruteur)
* Liste des offres (public)
* Filtrage (localisation, type)
### Candidatures
* Postuler à une offre
* Voir ses candidatures
* Gestion du statut (acceptée, refusée)
### Administration
* Gestion des utilisateurs
* Activation / désactivation des offres
---
## Installation
```bash
git clone https://github.com/ton-repo/mini-linkedin.git
cd mini-linkedin
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```
Configurer la base de données dans `.env`, puis :
```bash
php artisan migrate:fresh --seed
php artisan serve
```
---
## Comptes de test
Après le seed :
* **Admin**
    * Email : admin@test.com
    * Password : password123
* **Recruteur / Candidat**
  Générés automatiquement (voir base de données)
---
## API Routes principales
| Méthode | Route                         | Rôle      |
| ------- | ----------------------------- | --------- |
| POST    | /api/auth/register            | Public    |
| POST    | /api/auth/login               | Public    |
| GET     | /api/offres                   | Public    |
| POST    | /api/profil                   | Candidat  |
| POST    | /api/offres                   | Recruteur |
| POST    | /api/offres/{id}/candidater   | Candidat  |
| PATCH   | /api/candidatures/{id}/statut | Recruteur |
| GET     | /api/admin/users              | Admin     |
---
## Sécurité
* Authentification avec JWT
* Middleware personnalisé `CheckRole`
* Protection des routes selon les rôles
---
## Base de données
Tables principales :
* users
* profils
* competences
* offres
* candidatures
* profil_competence (pivot)
---
## Commandes utiles
```bash
php artisan migrate:fresh --seed
php artisan serve
php artisan tinker
```
---
## Auteur
Projet réalisé dans le cadre d’apprentissage Laravel et développement API REST.

---
## Conclusion
Ce projet est une base complète pour comprendre :
* Laravel API
* Authentification JWT
* Gestion des rôles
* Relations Eloquent
---
