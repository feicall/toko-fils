# TOKO & FILS — Site vitrine

![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-Dependencies-885630?style=for-the-badge&logo=composer&logoColor=white)

**Une présence digitale professionnelle pour une entreprise spécialisée dans la vitrerie, la miroiterie et les travaux d'aluminium.**

TOKO & FILS est un site web vitrine conçu pour présenter les prestations de l'entreprise, valoriser ses réalisations et faciliter les échanges avec ses clients.

---

## Présentation du projet

TOKO & FILS est une entreprise de vitrerie et de miroiterie implantée à **Parakou, au Bénin**.

Ce projet a pour objectif de renforcer sa visibilité sur Internet à travers une plateforme accessible, responsive et orientée vers la présentation de ses services.

Le site permet aux visiteurs de découvrir l'entreprise, de consulter ses domaines d'intervention, de parcourir ses réalisations et de transmettre directement leurs demandes grâce à un formulaire de contact.

**Objectifs principaux :**

- Développer la présence numérique de l'entreprise.
- Présenter les services et les compétences de manière professionnelle.
- Mettre en valeur les réalisations à travers une galerie multimédia.
- Faciliter la prise de contact et les demandes de renseignements.
- Centraliser les messages reçus dans une interface d'administration.

## Fonctionnalités

### 1. Site vitrine

- Page d'accueil avec présentation de l'entreprise.
- Section À propos présentant le responsable et ses coordonnées.
- Présentation des différentes prestations.
- Galerie de projets avec images et vidéos.
- Affichage des témoignages clients.
- Navigation adaptée aux appareils mobiles.
- Informations de contact et liens vers les réseaux sociaux.

### 2. Présentation des services

Le site met notamment en avant les prestations suivantes :

| Service | Description |
|---|---|
| Travaux d'aluminium | Conception et pose de châssis, baies vitrées et vérandas |
| Miroiterie | Réalisation de miroirs sur mesure et vitrines |
| Naco | Conception et installation de systèmes Naco |
| Pose | Installation de vitres, portes et cloisons vitrées |
| Châssis | Fabrication et installation de châssis sur mesure |
| Entretien | Prestations d'entretien général |

### 3. Formulaire de contact

Le formulaire permet aux visiteurs de transmettre leurs demandes en renseignant :

- Leur nom.
- Leur adresse e-mail.
- Leur message.

Le traitement PHP prévoit :

- La vérification des champs obligatoires.
- La validation du format de l'adresse e-mail.
- L'enregistrement du message dans une base de données MySQL.
- L'envoi d'une notification par e-mail avec PHPMailer.

### 4. Interface d'administration

Une interface dédiée à la gestion des messages est présente dans le projet.

Les fonctionnalités prévues dans le code comprennent :

- Consultation des messages reçus.
- Affichage du nom, de l'adresse e-mail, du contenu et de la date.
- Suppression d'un message.
- Préparation et envoi d'une réponse par e-mail.
- Déconnexion de l'espace d'administration.

**Attention :** l'authentification actuellement présente dans `dashboard.php` doit être corrigée et sécurisée avant toute utilisation en production. Les identifiants ne doivent pas être conservés en clair dans le code source.

---

## Technologies utilisées

### Frontend

- **HTML5** — Structure des pages.
- **CSS3** — Mise en forme et personnalisation graphique.
- **JavaScript** — Interactions et traitement des actions côté navigateur.
- **Bootstrap 5** — Mise en page responsive et composants d'interface.
- **Bootstrap Icons** — Icônes.
- **Font Awesome** — Icônes complémentaires.

### Backend

- **PHP** — Traitement des formulaires et logique serveur.
- **MySQL** — Stockage des messages.
- **PDO** — Connexion et interactions avec la base de données.
- **PHPMailer 6.10** — Envoi des e-mails via SMTP.
- **Composer** — Gestion des dépendances PHP.

### Bibliothèques complémentaires

Le projet utilise également plusieurs bibliothèques pour enrichir l'expérience utilisateur :

- AOS — Animations au défilement.
- Swiper — Carrousels et témoignages.
- GLightbox — Prévisualisation des médias.
- Isotope Layout — Organisation et filtrage de la galerie.
- PureCounter — Animation des compteurs.

---

## Architecture du projet

```text
toko-fils/
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── img/
│   └── vendor/
│
├── index.html
├── contact.html
├── auth.html
│
├── connexion.php
├── contact.php
├── dashboard.php
├── dashboard.html
├── send_reply.php
│
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

### Rôle des principaux fichiers

| Fichier | Responsabilité |
|---|---|
| `index.html` | Page d'accueil et présentation des services |
| `contact.html` | Page de contact et formulaire |
| `auth.html` | Interface de connexion à l'administration |
| `connexion.php` | Connexion à la base de données MySQL |
| `contact.php` | Traitement et enregistrement des messages, notification par e-mail |
| `dashboard.php` | Gestion des messages reçus |
| `dashboard.html` | Interface HTML de tableau de bord |
| `send_reply.php` | Traitement des réponses par e-mail |
| `composer.json` | Déclaration des dépendances PHP |
| `.gitignore` | Exclusion des fichiers sensibles et dépendances générées |

---

## Installation et configuration

### Prérequis

Avant de démarrer le projet, assurez-vous de disposer des outils suivants :

- PHP avec les extensions PDO MySQL et OpenSSL.
- MySQL Server.
- Composer.
- Un serveur web compatible PHP (Apache, Nginx ou serveur PHP intégré).

### 1. Cloner le dépôt

```bash
git clone https://github.com/feicall/toko-fils.git
```

Accéder au répertoire :

```bash
cd toko-fils
```

### 2. Installer les dépendances

Exécuter :

```bash
composer install
```

Cette commande installe notamment PHPMailer et génère le dossier `vendor/` nécessaire au chargement automatique des dépendances.

### 3. Configurer la base de données

Créer une base de données MySQL :

```sql
CREATE DATABASE mailing
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Créer ensuite la table utilisée par le formulaire de contact :

```sql
USE mailing;

CREATE TABLE t_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    sms TEXT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

Cette structure correspond aux champs utilisés dans les requêtes du projet.

### 4. Configurer la connexion MySQL

Le fichier `connexion.php` contient actuellement les paramètres de connexion à la base de données.

Ils doivent correspondre à votre environnement local :

```php
<?php

try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=mailing;charset=utf8mb4",
        "root",
        ""
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Impossible de se connecter à la base de données.");
}
```

**Important :** cet exemple utilise les identifiants MySQL locaux habituels. En production, créez un utilisateur MySQL dédié et conservez ses identifiants hors du dépôt Git.

### 5. Configurer l'envoi des e-mails

Le projet utilise PHPMailer avec le serveur SMTP de Gmail.

Créer un fichier `.env` à la racine du projet :

```env
SMTP_USERNAME=adresse@gmail.com
SMTP_PASSWORD=mot_de_passe_application
```

Remplacez les valeurs par vos propres paramètres SMTP.

Pour Gmail, utilisez un mot de passe d'application lorsque cette fonctionnalité est disponible. Ne publiez jamais ce fichier sur GitHub.

Le dépôt contient déjà des règles `.gitignore` destinées à exclure les fichiers `.env`.

---

## Lancement du projet

Pour démarrer rapidement le site en environnement local, exécutez depuis la racine du projet :

```bash
php -S localhost:8000
```

Ouvrez ensuite votre navigateur à l'adresse :

```text
http://localhost:8000
```

Les principales pages sont accessibles à travers :

| Page | Adresse |
|---|---|
| Accueil | `http://localhost:8000/index.html` |
| Contact | `http://localhost:8000/contact.html` |
| Connexion | `http://localhost:8000/auth.html` |

Le serveur PHP intégré est destiné au développement local. Pour une mise en production, utilisez un hébergement compatible PHP et configurez correctement le serveur web.

---

## Sécurité et recommandations techniques

Certaines améliorations sont nécessaires avant une mise en production.

- Remplacer les identifiants codés en dur par une configuration sécurisée.
- Corriger la logique d'authentification de l'espace d'administration.
- Mettre en place un contrôle de session sur toutes les pages administratives.
- Utiliser des mots de passe hachés avec `password_hash()` et `password_verify()`.
- Ajouter une protection CSRF aux formulaires sensibles.
- Vérifier et sécuriser les actions de suppression.
- Configurer les paramètres SMTP et MySQL à partir de variables d'environnement.
- Utiliser HTTPS sur le serveur de production.
- Éviter de retourner les messages d'erreur internes et les informations sensibles aux visiteurs.

Ces éléments constituent des recommandations d'amélioration et ne doivent pas être considérés comme des fonctionnalités déjà garanties par la version actuelle du projet.

---

## Informations sur le projet

| Élément | Information |
|---|---|
| Nom | TOKO & FILS |
| Type | Site web vitrine |
| Domaine | Vitrerie, miroiterie et aluminium |
| Localisation | Parakou, Bénin |
| Backend | PHP |
| Base de données | MySQL |
| Gestion des dépendances | Composer |
| Bibliothèque e-mail | PHPMailer |
| Dépôt | [GitHub — toko-fils](https://github.com/feicall/toko-fils) |

## Auteur et développement

Projet développé par **Feicall**.

- GitHub : [@feicall](https://github.com/feicall)
- Dépôt du projet : [toko-fils](https://github.com/feicall/toko-fils)

---

## Licence

Le projet utilise notamment le template **UpConstruction** de BootstrapMade. Avant toute redistribution ou exploitation commerciale du code et des ressources graphiques, vérifiez les conditions de licence applicables au template et à ses composants.

---

**TOKO & FILS — La qualité du travail, la précision des finitions et le savoir-faire au service de vos espaces.**
