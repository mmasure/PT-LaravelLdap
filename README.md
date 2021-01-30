##Commandes à faire :
* docker-compose build
* docker-compose up
* docker-compose exec php php artisan migrate

##Utilisateur LDAP test : 
Le mot de passe est commun à tous : `password`

Utilisateur OpenLDAP mis en place :
* spock
* jtk
* scotty

Utilisateur LDAP externe :
* tesla, galieleo, newton | [lien des users test](url_du_lien "https://www.forumsys.com/tutorials/integration-how-to/ldap/online-ldap-test-server/")


##Les URLs :
* [App laravel](url_du_lien "http://localhost:8080/")
* [App OpenLDAP admin](url_du_lien "http://localhost:8081/")

###Commentaires :
* le OpenLDAP est FONCTIONNEL !
* tester le ldap externe, il faut décommenté dans le .env ligne 48 à 57

##Améliorations :
 * Multi-authentification mixte. J'ai mis en place le vuejs et LoginController pour diriger la demande d'authentification soit vers les utilisateurs 
 OpenLDAP ou les utilisateurs normaux. Il reste à avoir pourquoi lors de la redirection de validation quand on se connecte en utilisateur classique
 l'app redirige vers le formulaire.
 * Configuration du build prod ou dev depuis un fichier d'environnement