# Collection Postman — Mini LinkedIn API

## Importation

1. Ouvrir Postman
2. Cliquer sur **Import**
3. Sélectionner le fichier `Mini LinkedIn API.postman_collection.json`

## Environnement

Créer un environnement avec ces variables :

| Variable        | Description                        |
|-----------------|------------------------------------|
| token_candidat  | Token JWT du candidat (auto-rempli)|
| token_recruteur | Token JWT du recruteur (auto-rempli)|
| token_admin     | Token JWT de l'admin (auto-rempli) |

## Ordre d'exécution

1. Lancer `php artisan serve`
2. Exécuter les requêtes dans l'ordre de la collection
3. Commencer par les 3 connexions pour remplir les tokens

## Scénarios couverts

| # | Requête | Code attendu |
|---|---------|-------------|
| 1 | Inscription Candidat | 201 |
| 2 | Inscription Recruteur | 201 |
| 3 | Connexion Candidat | 200 |
| 4 | Connexion Recruteur | 200 |
| 5 | Connexion Admin | 200 |
| 6 | Sans token | 401 |
| 7 | Créer profil | 201 |
| 8 | Modifier profil | 200 |
| 9 | Ajouter compétence | 200 |
| 10 | Profil interdit | 403 |
| 11 | Profil doublon | 422 |
| 12 | Créer offre | 201 |
| 13 | Modifier offre | 200 |
| 14 | Offre interdit | 403 |
| 15 | Supprimer offre | 200 |
| 16 | Postuler | 201 |
| 17 | Postuler doublon | 422 |
| 18 | Changer statut | 200 |
| 19 | Statut invalide | 422 |
| 20 | Liste users admin | 200 |
| 21 | Toggle offre | 200 |
| 22 | Admin interdit | 403 |

## Notes

- Les tokens se mettent à jour automatiquement après chaque connexion
- Recréer une offre après l'avoir supprimée avant de continuer les tests
- L'admin doit être créé via Tinker avant de lancer les tests
