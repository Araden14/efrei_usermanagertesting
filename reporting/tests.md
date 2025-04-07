## addUser()
- **Test Standard**: Vérifie que la méthode ajoute correctement un utilisateur avec le nom "Arnaud" et l'email "arnaud@test.com" dans la base de données.
- **Test de Validation d'Email**: Confirme qu'une exception `InvalidArgumentException` est levée lorsqu'un format d'email invalide ("mailinvalide.fr") est fourni.
- **Résultats Attendus**: L'utilisateur doit être correctement inséré dans la base avec les bonnes informations, et les emails mal formatés doivent être rejetés.

## updateUser()
- **Test Standard**: Vérifie la mise à jour du nom d'un utilisateur existant de "Arnaud" à "Arnaud2" tout en conservant son email.
- **Test d'Exception**: Confirme qu'une `InvalidArgumentException` est levée lors d'une tentative de mise à jour avec un email invalide.
- **Résultats Attendus**: Les modifications doivent être correctement reflétées dans la base de données, et les mises à jour avec des données invalides doivent être rejetées.

## removeUser()
- **Test Standard**: Vérifie que la méthode supprime correctement un utilisateur de la base de données.
- **Test d'Exception**: Confirme qu'une `InvalidArgumentException` est levée lors d'une tentative de suppression d'un ID utilisateur inexistant (999999).
- **Résultats Attendus**: L'utilisateur doit être complètement supprimé de la base, et il doit y avoir une gestion appropriée des IDs invalides.

## getUsers()
- **Test Standard**: Vérifie que la méthode récupère correctement tous les utilisateurs (deux utilisateurs ajoutés dans ce test).
- **Résultats Attendus**: La liste complète des utilisateurs doit être récupérée avec leurs informations correctes (noms "Arnaud" et "Arnaud2").