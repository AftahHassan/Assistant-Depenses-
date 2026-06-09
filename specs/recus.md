# Spec — Feature Reçus CRUD

## Version
v1.0 — 2026-06-09

## User Stories couvertes
- US2 : Liste des reçus
- US3 : Soumettre un reçu
- US4 : Voir le détail d'un reçu
- US5 : Supprimer un reçu

## Proposal
Permettre à Brahim de soumettre, consulter et supprimer
ses reçus avec leur statut de traitement.

## Specs techniques
- Model Recu : user_id, texte_brut, statut (enum), payload_brut (json)
- Model Depense : recu_id, libelle, quantite, prix_unitaire, categorie (enum)
- Relation : Recu hasMany Depense
- Eager loading : Recu::with('depenses') sur toutes les queries
- StoreRecuRequest : texte required, min:10, max:5000

## Enums PHP
- StatutEnum : en_attente, traite, echoue
- CategorieEnum : alimentaire, boissons, hygiene, entretien, autre

## Routes
GET    /recus          → liste
POST   /recus          → soumission
GET    /recus/{id}     → détail
DELETE /recus/{id}     → suppression

## Critères d'acceptation
- Liste affiche statut formaté + nombre de dépenses
- Après soumission → message immédiat "En cours de traitement"
- Suppression efface aussi toutes les Depenses associées
- Zéro N+1 vérifié avec Debugbar