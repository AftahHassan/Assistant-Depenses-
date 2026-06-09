# Spec — Feature Extraction IA

## Version
v1.0 — 2026-06-09

## User Stories couvertes
- US6 : Extraction structurée
- US7 : Suivi du traitement

## Proposal
L'appel IA est lent. La page ne doit jamais se figer.
Le structured output garantit des données toujours typées,
sans json_decode fragile.

## Décisions d'architecture
1. Queue async : Controller dispatche le Job et répond
   immédiatement. Le worker traite en arrière-plan.
2. Structured output via laravel/ai : schéma PHP transmis
   à Groq qui garantit la conformité du JSON retourné.
3. Tout échec → statut echoue sur le Recu.

## Flow du Job
1. Récupérer le Recu par ID
2. Appeler laravel/ai avec texte_brut + schéma ReponseIA
3. Boucler sur articles → créer une Depense par article
4. Mettre statut → traite
5. Exception → statut echoue

## Critères d'acceptation
- Statut passe de en_attente à traite après succès
- Chaque article crée une ligne Depense en base
- En cas d'erreur API → statut echoue affiché clairement
- Le payload_brut de la réponse est conservé sur le Recu