# 🧾 Assistant Dépenses — Extraction Intelligente de Reçus avec Laravel & IA

## 📌 Description

Assistant Dépenses est une application web développée avec Laravel permettant d'extraire automatiquement les dépenses contenues dans des reçus fournisseurs grâce à l'intelligence artificielle.

L'utilisateur colle simplement le texte d'un reçu et l'application analyse son contenu afin d'en extraire des dépenses structurées, catégorisées et enregistrées dans une base de données.

Le projet utilise :

- Laravel 13
- Laravel AI SDK
- Groq API
- Queue & Jobs
- Eloquent ORM
- Form Requests
- Enum Casts
- OpenSpec
- MySQL

---

# 🎯 Objectif du projet

Automatiser la saisie des dépenses à partir de reçus papier afin de permettre aux commerçants de :

- suivre leurs dépenses
- visualiser leurs achats
- classer automatiquement les produits
- éviter la saisie manuelle

---

# 🚀 Fonctionnalités

## 🔐 Authentification

- Inscription
- Connexion
- Déconnexion

---

## 🧾 Gestion des reçus

### Ajouter un reçu

L'utilisateur colle le texte brut d'un reçu fournisseur.

Exemple :

```text
2 Coca Cola 12.50
1 Huile Lesieur 45.00
3 Savon Dove 8.00
```

Le reçu est enregistré avec le statut :

```text
EN_ATTENTE
```

---

### Liste des reçus

Affichage de :

- Date de création
- Statut
- Nombre de dépenses extraites

Statuts disponibles :

- En attente
- Traité
- Échoué

---

### Détail d'un reçu

Affichage de :

- Texte source
- Statut
- Dépenses extraites
- Total estimé
- Devise

---

### Suppression d'un reçu

Suppression du reçu et de toutes ses dépenses associées.

---

## 🤖 Extraction IA

Après la création du reçu :

1. Un Job est dispatché dans la Queue.
2. Laravel AI envoie le texte à Groq.
3. L'IA retourne un JSON structuré.
4. Les données sont validées.
5. Les dépenses sont enregistrées en base.

---

### Contrat JSON attendu

```json
{
  "articles": [
    {
      "libelle": "Coca Cola",
      "quantite": 2,
      "prix_unitaire": 12.5,
      "categorie": "boissons"
    }
  ],
  "total_estime": 25,
  "devise": "MAD"
}
```

---

## 📊 Gestion des dépenses

Liste complète des dépenses avec :

- Libellé
- Quantité
- Prix unitaire
- Catégorie
- Reçu associé

Filtrage par catégorie :

- Alimentaire
- Boissons
- Hygiène
- Entretien
- Autre

---

# 🏗️ Architecture du projet

## Relations Eloquent

```php
Recu hasMany Depense
Depense belongsTo Recu
```

---

## Form Request

Validation des données via :

```bash
StoreRecuRequest
```

Contrôles :

- requis
- taille minimale
- taille maximale

---

## Queue & Jobs

Traitement IA asynchrone :

```bash
php artisan make:job ExtraireDepensesDuRecu
```

L'utilisateur ne reste jamais bloqué pendant le traitement.

Lancement du worker :

```bash
php artisan queue:work
```

---

## Enum Casts

### Statut du reçu

```php
enum RecuStatus
{
    case EN_ATTENTE;
    case TRAITE;
    case ECHOUE;
}
```

### Catégorie de dépense

```php
enum DepenseCategorie
{
    case ALIMENTAIRE;
    case BOISSONS;
    case HYGIENE;
    case ENTRETIEN;
    case AUTRE;
}
```

---

## Payload IA

Conservation du résultat brut :

```php
protected $casts = [
    'payload_brut' => 'array'
];
```

---

# 🗄️ Base de données

## Table users

| Champ | Type |
|---------|---------|
| id | bigint |
| name | string |
| email | string |
| password | string |

---

## Table recus

| Champ | Type |
|---------|---------|
| id | bigint |
| user_id | foreignId |
| texte_source | longText |
| statut | enum |
| payload_brut | json |
| created_at | timestamp |

---

## Table depenses

| Champ | Type |
|---------|---------|
| id | bigint |
| recu_id | foreignId |
| libelle | string |
| quantite | integer |
| prix_unitaire | decimal |
| categorie | enum |

---

# 📂 Structure du projet

```text
app/
├── Enums/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Jobs/
├── Models/
├── Services/

database/
├── migrations/

resources/
├── views/

specs/

AGENTS.md
README.md
```

---

# ⚙️ Installation

## 1. Cloner le projet

```bash
git clone https://github.com/AftahHassan/Assistant-Depenses-.git
```

```bash
cd assistant-depenses
```

---

## 2. Installer les dépendances

```bash
composer install
```

```bash
npm install
```

---

## 3. Configuration

Créer le fichier :

```bash
.env
```

Puis :

```bash
cp .env.example .env
```

Générer la clé :

```bash
php artisan key:generate
```

---

## 4. Configuration de la base de données

```env
DB_CONNECTION=mysql
DB_DATABASE=assistant_depenses
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Configuration de Groq

```env
GROQ_API_KEY=xxxxxxxxxxxxxxxx
```

---

## 6. Migrations

```bash
php artisan migrate
```

---

## 7. Lancer les serveurs

Application :

```bash
php artisan serve
```

Worker :

```bash
php artisan queue:work
```

Frontend :

```bash
npm run dev
```

---

# 📖 Workflow AI-Assisted

Le projet suit la méthodologie OpenSpec.

## Dossier specs

```text
specs/
├── auth
├── recus-crud
├── extraction-ia
├── queue-traitement
```

Chaque fonctionnalité suit :

```text
Proposal
↓
Specification
↓
Tasks
↓
Implementation
```

---

# 🤝 Technologies utilisées

- Laravel
- PHP 8.3+
- MySQL
- Laravel AI SDK
- Groq API
- Queue Workers
- OpenSpec
- Laravel Debugbar
- Tailwind CSS

---

# 📈 Améliorations futures

- Upload d'image de reçu
- OCR automatique
- Dashboard analytique
- Graphiques des dépenses
- Export PDF
- Export Excel
- Notifications en temps réel
- Tests Pest

---

# 👨‍💻 Auteur
  # AFTAH Hassan
Projet réalisé dans le cadre d'une formation Laravel & AI Engineering.

Développé avec Laravel, OpenSpec et Groq AI.