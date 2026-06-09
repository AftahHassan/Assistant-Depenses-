# Spec — Feature Auth

## Version
v1.0 — 2026-06-09

## User Stories couvertes
- US1 : Inscription / Connexion / Déconnexion

## Proposal
Brahim doit avoir un compte pour que ses reçus lui soient
rattachés et non visibles par d'autres utilisateurs.

## Specs techniques
- Routes : POST /register, POST /login, POST /logout
- Middleware auth sur toutes les routes reçus et dépenses
- Après login → redirection vers /recus
- Après logout → redirection vers /login
- Validation : email unique, password min 8 chars

## Tasks
- [ ] Laravel Breeze installé
- [ ] php artisan migrate exécuté
- [ ] Middleware auth sur le groupe de routes protégées

## Critères d'acceptation
- Un utilisateur non connecté est redirigé vers /login
- Après inscription, l'utilisateur est connecté automatiquement
- Déconnexion supprime la session et redirige vers /login