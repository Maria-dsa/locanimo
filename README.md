# locanimo

### CONCEPT

Application de location d'animaux entre particuliers. 

Un propriétaire peut "prêter" son animal de compagnie à une personne, famille aimante qui n'en a pas et qui aimerait profiter de la compagnie d'un animal pour quelques jours. 
Pour cela, après avoir créé son compte, il crée la fiche d'identité de l'animal, les dates de disponibilité et le prix par jour.
Cela crée une annonce visible par tous les utilisateurs.
Le propriétaire à la possibilité de créer, modifier ou supprimer une annonce. 

Le visiteur peut voir toutes les annonces. 
S'il veut faire une demande de "réservation" d'un animal, il doit se connecter (créer son compte le cas échéant).
En tant que client, après avoir sélectionné un animal, il doit préciser la date de réservation souhaitée en fonction des disponibilités. 

En envoyant sa demande de réservation, celle-ci s'affiche sur l'interface du propriétaire. 
Le propriétaire a la possibilité d'accepter ou de rejeter la demande de réservation. 
Le client et le propriétaire peuvent visualiser le statut de la demande. 

Si elle est acceptée par le propriétaire, on peut imaginer dans des features ultérieures, un système de facturation et de paiement. 

Pour cela, différents statuts permettent de gérer la demande de réservation : 

- pending : lorsque le client envoie sa demande 
- accepted : à la main du propriétaire
- rejected : à la main du propriétaire
- canceled by the owner : à la main du propriétaire
- canceled by the customer : à la main du client
- Done : une fois la prestation réalisée (on pourrait imaginer que ce statut se mette à jour après le paiement et la date de réalisation, dans une feature ultérieure)


Dans le modèle de données, le User peut être Owner et/ou Customer. 
Une table speecies est prévue pour gérer plusieurs espèces animales. 


On pourrait prévoir dans des features ultérieures, les fonctionnalités suivantes : 
- laisser des commentaires sur le propriétaire le client
- afficher la liste géolocalisée des animaux disponibles en fonction de l'adresse du client lorsqu'il est connecté
- faire une recherche par dates disponibles

### MODELE DE DONNEES
![locanimo_DB](https://user-images.githubusercontent.com/93591663/215838760-1973859c-2520-4061-a156-8f695d529f58.png)

### BACKLOG
https://github.com/users/Maria-dsa/projects/1
![image](https://user-images.githubusercontent.com/93591663/215843194-2b35db51-dd27-4a29-b234-e4554b6cb2e0.png)

