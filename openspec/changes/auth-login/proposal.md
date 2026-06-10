## Why

L'application n'a aucun système d'authentification. Les utilisateurs ne peuvent pas s'inscrire, se connecter, ou gérer leur session. Un système d'auth complet est nécessaire pour sécuriser l'accès aux fonctionnalités de gestion des dépenses.

## What Changes

- Nouveau système d'inscription avec email et mot de passe
- Page de connexion / déconnexion
- Réinitialisation de mot de passe (forgot/reset)
- Vérification d'email obligatoire
- Middleware d'authentification sur les routes protégées
- Layout Blade avec navigation connecté / non connecté
- Tests Pest pour toutes les flows d'authentification

## Capabilities

### New Capabilities
- `user-registration`: Inscription utilisateur avec nom, email, mot de passe, confirmation
- `user-login`: Authentification par email/mot de passe, avec remember me
- `user-logout`: Déconnexion et destruction de session
- `password-reset`: Demande et réinitialisation de mot de passe par email
- `email-verification`: Vérification d'email après inscription, avec renvoi

### Modified Capabilities

<!-- Aucune capability existante modifiée -->

## Impact

- `app/Http/Controllers/Auth/` : nouveaux contrôleurs (Register, Login, Logout, ForgotPassword, ResetPassword, VerifyEmail)
- `app/Http/Requests/Auth/` : Form Requests pour validation
- `resources/views/auth/` : vues Blade (login, register, forgot-password, reset-password, verify-email)
- `resources/views/layouts/` : layout avec navigation conditionnelle
- `routes/web.php` : nouvelles routes d'authentification
- `app/Providers/` : configuration des guards et providers (via Laravel Breeze ou manuel)
- Composer : ajout de `laravel/fortify` ou `laravel/breeze` (ou implémentation manuelle)
- Tests : Pest tests pour l'authentification
