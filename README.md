# Randollier — Back-end API

API REST Symfony 8 pour le site e-commerce de randonnée **Randollier**.

## Stack technique

| Couche | Technologie |
|---|---|
| Framework | Symfony 8.0 (PHP >= 8.4) |
| ORM | Doctrine ORM 3 + Migrations |
| Auth | LexikJWTAuthenticationBundle 3 |
| Admin | EasyAdmin 5 |
| Sécurité | Symfony SecurityBundle |
| Sérialisation | Symfony Serializer (groups) |
| CORS | NelmioCorsBundle |
| Fixtures | DoctrineFixturesBundle |

---

## Fonctionnalités

### Authentification — LexikJWTAuthenticator

L'API utilise des tokens **JWT** (JSON Web Token) pour authentifier les requêtes.

- `POST /api/register` — Création de compte (email, mot de passe, prénom, nom)
- `POST /api/login` — Connexion, retourne un token JWT signé

Le token doit ensuite être envoyé dans le header `Authorization: Bearer <token>` pour accéder aux routes protégées.

### Sécurité — Symfony SecurityBundle

Les accès sont contrôlés par les rôles Symfony :

| Rôle | Accès |
|---|---|
| `ROLE_USER` | Routes `/api/*` authentifiées (commandes, adresses, profil) |
| `ROLE_ADMIN` | Interface EasyAdmin + toutes les routes utilisateur |

La hiérarchie des rôles (`ROLE_ADMIN` hérite de `ROLE_USER`) est définie dans `security.yaml`.

### Interface d'administration — EasyAdmin 5

Accessible sur `/admin`, réservée aux utilisateurs `ROLE_ADMIN`.

Entités gérables :
- **Produits** — création, édition, activation, mise en avant (`isFeatured`)
- **Utilisateurs** — gestion des rôles et des comptes

### API Produits

| Méthode | Route | Description | Auth |
|---|---|---|---|
| `GET` | `/api/products` | Liste tous les produits | Non |
| `GET` | `/api/products/featured` | Produits mis en avant et actifs | Non |
| `GET` | `/api/products/{id}` | Détail d'un produit | Non |

### API Commandes

| Méthode | Route | Description | Auth |
|---|---|---|---|
| `GET` | `/api/orders` | Liste les commandes de l'utilisateur connecté | Oui |

Les commandes supportent les **invités** (`guestEmail`) et les statuts :
`pending` → `paid` → `processing` → `shipped` → `delivered` / `cancelled` / `refunded`

L'adresse de livraison est **dénormalisée** (snapshot JSON) pour préserver l'historique.

### API Adresses

| Méthode | Route | Description | Auth |
|---|---|---|---|
| `GET` | `/api/addresses` | Liste les adresses de l'utilisateur | Oui |
| `POST` | `/api/addresses` | Ajoute une adresse | Oui |
| `PUT` | `/api/addresses/{id}` | Modifie une adresse | Oui |
| `DELETE` | `/api/addresses/{id}` | Supprime une adresse | Oui |

Une seule adresse peut être marquée `isDefault` — le back garantit l'unicité automatiquement.

### Sérialisation par groupes

Le Serializer Symfony est configuré avec des **groupes** pour contrôler les données exposées selon le contexte :

| Groupe | Utilisé pour | Données incluses |
|---|---|---|
| `product:list` | Liste des produits | `id`, `name`, `slug`, `price`, `image`, `category` |
| `product:show` | Détail d'un produit | Tout + `description`, `stock`, `isActive`, `reviews` |

### Data Fixtures

Les fixtures (`src/DataFixtures/AppFixtures.php`) initialisent la base de données avec :

- **4 catégories** : Homme, Femme, Sacs, Équipements
- **22 produits** de randonnée avec descriptions, prix et images
- **1 compte administrateur** : `admin@randollier.fr` / `admin1234`

---

## Installation

### Prérequis

- PHP 8.4+
- Composer
- Symfony CLI
- MySQL / PostgreSQL

### Mise en place

```bash
# 1. Installer les dépendances
composer install

# 2. Configurer les variables d'environnement
cp .env .env.local
# Renseigner DATABASE_URL et JWT_PASSPHRASE dans .env.local

# 3. Créer la base de données et jouer les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 4. Générer les clés JWT
php bin/console lexik:jwt:generate-keypair

# 5. Charger les données initiales
php bin/console doctrine:fixtures:load

# 6. Lancer le serveur
symfony server:start
```

---

## Structure du projet

```
src/
├── Controller/
│   ├── Admin/          # DashboardController, ProductCrudController, UserCrudController
│   └── Api/            # ProductController, OrderController, AddressController,
│                       # RegisterController, UserController
├── DataFixtures/       # AppFixtures
├── Entity/             # User, Product, Category, Order, OrderItem, Address, Review
├── Enum/               # OrderStatus
└── Repository/         # Repositories Doctrine
```
