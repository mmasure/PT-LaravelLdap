#Commandes à faire :
* docker-compose build
* docker-compose up
* docker-compose exec -it php php artisan migrate

#Les URLs :
* [App laravel](url_du_lien "http://localhost:8080/")
* [App OpenLDAP admin](url_du_lien "http://localhost:8081/")

##Commentaires :
* le OpenLDAP mis en place ne fonctionne pas
* tester le ldap externe, il faut décommenté dans le .env ligne 48 à 57
* utilisateur test : tesla, galieleo, newton | mot de pass: password | [lien des users test](url_du_lien "https://www.forumsys.com/tutorials/integration-how-to/ldap/online-ldap-test-server/")
* bitnami/openldap : impossible d'utiliser les users mis en variable d'environement. Changement d'image vers osixia/openldap. J'ai laissé ce que j'avais fait
* Création via le phpldapadmin puis test de connection avec la commande "php artisan ldap:test" authorise la connexion mais pas l'authentification laravel. Si vous testez, n'oubliez pas de décommenter le code .env du openLDAP externe
 
#Amélioration :
 * Authentification ne fonctionne pas le OpenLDAP interne : 
    * Hypothèse : user mal configuré avec le domain sur le OpenLDAP qui ne permet pas l'authentification sur laravel
    * Actions : 
      * se former sur LDAP pour mieux comprendre la configuration
      * utiliser un fichier d'import d'utilisateur plus propre que l'import bitnami/openLdap

#Fichier laravel modifié pour la mise en place
Le Laravel est basique avec une simple mise en place de l'auth avec le quickstart. J'ai préféré me focus 
la mise en place du LDAP avec une architecture docker pour démontrer mon potentiel dans une domaine dont je débute.
Les modifications apporté à se projet est l'ajout bien entendu du package **directorytree/ldaprecord-laravel**

Pour le mettre en place, c'est dans le fichier config/auth.php (ligne 74) ainsi que la mise en place de traits dans app/models/users
qui permettent la connection avec un service OpenLDAP.

Il a fallu faire quelque modification pour l'utilisation du username car par défaut, laravel s'authentifie par email et non
un username.