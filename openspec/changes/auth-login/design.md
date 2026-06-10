## Context

L'application Assistant Dépenses utilise Laravel 13 avec Blade + Tailwind CSS. Aucun système d'authentification n'existe actuellement. Les utilisateurs doivent pouvoir s'inscrire, se connecter, et gérer leur compte avant d'accéder aux fonctionnalités de gestion des dépenses.

## Goals / Non-Goals

**Goals:**
- Mettre en place un système d'authentification complet (inscription, connexion, déconnexion, reset password, vérification email)
- Utiliser les composants natifs Laravel (Laravel Breeze avec Blade + Tailwind)
- Protéger les routes avec le middleware `auth` et `verified`
- Fournir des vues Blade responsives avec Tailwind CSS
- Tests Pest pour chaque flow

**Non-Goals:**
- Ne pas implémenter OAuth / socialite (sera une feature ultérieure)
- Ne pas gérer les rôles / permissions (hors scope)
- Ne pas modifier le système de sessions existant

## Decisions

| Decision | Choix | Raison |
|---|---|---|
| Starter kit | Laravel Breeze (Blade + Tailwind) | Fournit scaffold complet : controllers, vues, routes, tests - correspond au stack technique existant |
| Vues | Blade + Tailwind | Stack existant (cf. AGENTS.md) |
| Email | MAIL_MAILER=log en dev | Pas de service SMTP en dev, consultable via logs |
| Routes | Breeze génère les routes standard | Respecte les conventions Laravel, facile à surcharger si besoin |
| Tests | Pest | Framework de test existant (cf. AGENTS.md et composer.json) |

## Risks / Trade-offs

- [Risque] Breeze installe npm packages (flowbite, alpinejs) → vérifier compatibilité avec Vite existant
- [Risque] Le middleware `verified` bloque les nouvelles routes avant vérification email → mitigation : configurer `EmailVerificationPromptController`
- [Trade-off] Breeze est opiné mais correspond au besoin ; si on voulait plus de contrôle, on ferait du manual scaffolding
