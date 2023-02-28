# Documentation

Après avoir pris connaissance des instructions, j'ai élaboré mon approche en suivant les différentes étapes citées ci-dessous.

J'ai démarré par la commande, qui pourra être exécutée sur le serveur avec une tâche CRON.
Partant du principe DRY pour la commande et le web, un service (ApodService) et un manager (ApodManager) ont été créé.

## Service

L'ApodService contient deux méthodes :

 - fetchPictureOfTheDay
 - getPictureOfTheDay

### fetchPictureOfTheDay

Cette méthode réalise la requête vers l'API avec le composant HTTP CLIENT.
La réponse, au format JSON, est désérialisée avec le composant Serializer vers un objet `ApodDTO`.

### getPictureOfTheDay

Cette méthode appelle `fetchPictureOfTheDay`, qui est englobée dans un bloc try/catch.
S'il y a une erreur avec la requête, la dernière image enregistrée sera retournée.
S'il ne s'agit pas d'une image, là encore on retourne la dernière image en base de données.
Sinon, on fait appel à la méthode `savePictureOfTheDay` de l'ApodManager.

## Manager

### savePictureOfTheDay

La méthode prend en entrée un objet de type `ApodDTO`.
Si en base de données une entrée existe avec la même date, l'image n'est pas enregistrée et on retourne celle déjà existante.
Sinon, on crée la nouvelle image en appelant la méthode static `fromDTO` et on l'enregistre avant de la retourner.

J'utilise ici une classe `ApodDTO` afin que la réponse de l'API (une fois désérialisée vers cette classe) soit plus facile à utiliser à travers l'application.

### getLastRecord

Pour récupérer la dernière image en base de données lorsque c'est nécessaire, cela passe par la méthode `findOneBy` de `ApodRepository` en lui fournissant en second
argument un order by ID descendant.

## Authentification

Pour gérer l'accès à la page `/apod` , qui permet de visualiser l'image du jour, la librairie `knpuniversity/oauth2-client-bundle` a été utilisée.
La documentation de cette librairie étant très bien faite, l'implémenter dans l'application s'est avéré rapide.
L'accès à cette page est géré dans le fichier `security.yaml`. L'utilisateur doit être connecté et avoir le rôle `ROLE_USER`.
Ce rôle est assigné quoi qu'il en soit à l'utilisateur dans le getter `getRoles` de l'entité `User`. Sinon, il est redirigé vers la page de login Google.

## Affichage

L'affichage est fait avec le moteur de template Twig.
Le controller `HomeController` s'occupe de l'affichage de la page d'accueil ainsi que de la page qui affiche l'image du jour en injectant `ApodService`.

## Doctrine

Une base de données MySQL a ici été utilisée. Quelques commandes utiles :

- `php bin/console doctrine:database:create`
- `php bin/console doctrine:migrations:diff`
- `php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\VersionXXXXXX'`

Un fichier de migration est déjà disponible pour la création des tables User et Apod.
