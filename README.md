# ApiFetch:

   # Fonctionnalités:
          -Upload d'un fichier au format csv
          -extraction des Ids/Emails du fichier
          -Consommation de l'API à partir des informations récupérées dans le fichier
          -Sauvegarde de nouveaux utilisateurs à partir des données de l'API
          -Assignation d'utilisateur(s) à un cours/training Opigno LMS

# Structure:
#  /Controller:
       -ApiFetchResultController: Affiche les données récupérées via consommation de l'API
       -TestAssignController: Test assignation utilisateur(s)
#  /Form:
       -api_fetch_form: Formulaire pour upload du fichier csv
#  /Services:
       -ApiFetchAssign: Permet l'assignation à un cours
       -ApiFetchClient: Permet d'interroger l'API 
       -ApiFetchCsv: Upload et extrait les données d'un fichier csv
       -ApiFetchStudent: Sauvegarde un nouvel utilisateur en base de données
#  /templates:
       -api-fetch-result: template pour affichage des données de l'API
#  Conf:
      -api_fetch.info.yml
      -api_fetch_module: Assignation du template au controller
      -api_fetch.routing.yml
      -api_fetch.services.yml: Déclaration des service (cf Drupal Dependency Injection/Container: https://www.drupal.org/docs/8/api/services-and-dependency-injection/services-and-dependency-injection-in-drupal-8)
