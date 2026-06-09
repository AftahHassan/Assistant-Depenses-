# AGENTS.md — Assistant Dépenses

## Contexte du projet
Application Laravel qui extrait des dépenses structurées depuis
des reçus fournisseurs en texte libre, via l'IA (Groq).

## Stack technique
- PHP 8.3 / Laravel 13
- Base de données : MySQL
- Queue driver : database
- SDK IA : laravel/ai (provider Groq, modèle llama-3.1-8b-instant)
- Tests : Pest
- Frontend : Blade + Tailwind CSS

## Conventions de code
- Toujours valider avec un Form Request avant tout appel IA
- L'appel IA se fait UNIQUEMENT dans le Job, jamais dans le Controller
- Utiliser les Eloquent Casts pour les enums et le payload JSON
- Eager loading obligatoire sur toutes les relations (zéro N+1)
- Nommer les branches : feature/nom-feature

## Conventions de commits
Format : type: description courte [AI: ce que l'agent a fait]
Exemples :
  feat: ajout formulaire soumission reçu [AI: blade généré avec Claude]
  fix: correction cast enum catégorie [AI: debug assisté par Claude]
  test: extraction IA avec fake SDK [AI: test écrit avec Claude]

## Décisions d'architecture importantes
1. Queue obligatoire : l'appel Groq est lent (~3-8s), la page
   ne doit jamais se figer. Le Controller dispatche le Job et
   répond immédiatement avec statut "En attente".
2. Structured output : on ne parse pas du JSON libre. Le SDK
   laravel/ai garantit que Groq respecte le schéma PHP défini.
3. Form Request avant IA : valider le texte AVANT de consommer
   un appel API Groq (économie de tokens et d'argent).

## Contrat JSON attendu de l'IA
{
  "articles": [
    {
      "libellé": "string",
      "quantité": "integer",
      "prix_unitaire": "number",
      "catégorie": "alimentaire|boissons|hygiène|entretien|autre"
    }
  ],
  "total_estimé": "number",
  "devise": "string"
}

## Workflow avec l'agent (OpenCode recommandé)
1. Toujours démarrer en mode Plan : décrire la feature, laisser
   l'agent proposer l'architecture avant d'écrire du code.
2. Passer en mode Build uniquement après validation du plan.
3. Relire et comprendre tout ce que l'agent génère avant de commit.