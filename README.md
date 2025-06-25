# 💻 ReservationPC - Gestion des Réservations de Matériel Informatique

> Application web dédiée à la gestion optimisée des réservations de PC portables dans un établissement scolaire

[![Status](https://img.shields.io/badge/Status-Production-green)]()
[![Version](https://img.shields.io/badge/Version-1.0.0-blue)]()
[![License](https://img.shields.io/badge/License-MIT-yellow)]()

## 📋 Description

ReservationPC est une solution complète de gestion des réservations de matériel informatique conçue spécifiquement pour les établissements scolaires. L'application centralise et automatise l'ensemble du processus de réservation, depuis la demande initiale jusqu'à l'attribution personnalisée des équipements.

### 🎯 Objectifs principaux

- **Optimiser** l'utilisation du parc informatique
- **Automatiser** les processus de réservation et d'attribution
- **Faciliter** la communication entre enseignants et administrateurs
- **Assurer** un suivi en temps réel du matériel

## ✨ Fonctionnalités

### 🔐 Interface Administrateur
- **Tableau de bord** complet avec vue d'ensemble des entités
- **Validation/Refus** des réservations avec notifications automatiques
- **Attribution automatique** des PC selon la disponibilité
- **Import/Export CSV** pour la gestion en masse
- **Suivi temps réel** de l'état du matériel

### 📝 Système de Réservation
- **Interface intuitive** de création de réservations
- **Sélection flexible** des classes et élèves
- **Planification** avec gestion des conflits
- **Vérification automatique** de disponibilité

### 📧 Notifications Automatisées
- **Emails personnalisés** de validation avec détails complets
- **Notifications de refus** avec motifs explicites
- **Instructions de récupération** avec localisation précise

## 🖼️ Aperçu de l'Interface

### Formulaire de Réservation
Interface permettant aux enseignants de soumettre leurs demandes avec tous les détails nécessaires.

![Formulaire de réservation](https://kennan.alwaysdata.net/Portfolio/screens/formulaire_de_reservation.png)

### Suivi des Réservations (Vue Utilisateur)
Les utilisateurs peuvent suivre l'état de leurs demandes en temps réel.

![Suivi utilisateur](https://kennan.alwaysdata.net/Portfolio/screens/reservations_en_attentes_user.png)

### Gestion Administrative
Interface dédiée aux administrateurs pour traiter et valider les demandes.

![Gestion admin](https://kennan.alwaysdata.net/Portfolio/screens/reservations_en_attentes_admin.png)

### Interfaces CRUD
Modules d'administration permettant l'ajout manuel ou l'import CSV des données avec export possible.

![Accueil Backoffice](https://kennan.alwaysdata.net/Portfolio/screens/backoffice_accueil.png)
![Gestion des élèves](https://kennan.alwaysdata.net/Portfolio/screens/backoffice_crud.png)

### Système de Notifications

**Confirmation par email** lors de la validation :
![Email validation](https://kennan.alwaysdata.net/Portfolio/screens/mail_reservation_validee.png)

**Gestion des refus** avec motif personnalisé :
![Motif refus](https://kennan.alwaysdata.net/Portfolio/screens/motif_refus_reservation.png)

**Notification de refus** détaillée :
![Email refus](https://kennan.alwaysdata.net/Portfolio/screens/mail_refus_reservation.png)

## 🛠️ Technologies Utilisées

- **Framework** : Laravel 12
- **Interface dynamique** : Livewire
- **Base de données** : MySQL
- **Serveur** : Apache/Nginx
- **Notifications** : Système d'emails intégré
- **Import/Export** : Traitement CSV

## 🚀 Installation

### Prérequis
- PHP 8.1+
- Composer
- MySQL 5.7+
- Serveur web (Apache/Nginx)

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/ken2005/reservationpc.git
cd reservationpc
```

2. **Installation des dépendances**
```bash
composer install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
```bash
# Configurer .env avec vos paramètres MySQL
php artisan migrate
php artisan db:seed
```

5. **Configuration email**
```bash
# Configurer les paramètres SMTP dans .env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## 💡 Utilisation

### Pour les Enseignants
1. Accéder au formulaire de réservation
2. Sélectionner la classe et les élèves
3. Choisir les créneaux souhaités
4. Soumettre la demande

### Pour les Administrateurs
1. Consulter le tableau de bord
2. Traiter les demandes en attente
3. Valider ou refuser avec motif
4. Gérer l'import/export des données

## 📊 Exemple d'Attribution

```
Réservation validée pour Terminal B (3 élèves)
Date : 29/06/2025 - 14h00 à 17h00
Salle : 101

Attributions automatiques :
├── PEGUY-PRET-A-01 → Thomas Alice
├── PEGUY-PRET-A-02 → Moreau Julie
└── PEGUY-PRET-A-03 → Simon Louis

Localisation : Local près du bureau ESCPA (3ème étage)
```

## 🔒 Sécurité

- **Authentification** par profils utilisateur
- **Droits d'accès** différenciés (Admin/Enseignant)
- **Validation manuelle** pour contrôle qualité
- **Traçabilité complète** de toutes les opérations
- **Sauvegarde automatique** des données

## 🚧 Roadmap

- [ ] **Mobile App** avec notifications push
- [ ] **Code-barres/QR Code** pour l'inventaire
- [ ] **Dashboard analytique** avec statistiques
- [ ] **API REST** pour intégration système
- [ ] **Interface multilingue** étendue

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à proposer des améliorations ou signaler des problèmes.

## 👤 Auteur

**Kennan Elmeski**

---

⭐ **N'hésitez pas à donner une étoile si ce projet vous a été utile !**
