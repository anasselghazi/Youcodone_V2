 📌 README – Projet Youco’Done (Version Réservation & Paiement)
🧾 Description du projet

Youco’Done est une plateforme web de réservation de tables de restaurants permettant aux clients de planifier, payer et confirmer leurs réservations en ligne, tout en offrant aux restaurateurs et administrateurs des outils de gestion avancés.
Cette version du projet met l’accent sur la gestion des créneaux horaires, les paiements sécurisés, les notifications, ainsi que le suivi administratif.

🎯 Objectifs

Permettre aux clients de réserver une table avec une date et un créneau précis.

Offrir aux restaurateurs une gestion fine des disponibilités.

Sécuriser et confirmer les réservations via paiement en ligne.

Fournir aux administrateurs une vision globale des réservations et paiements.

Respecter strictement le cahier des charges du brief Simplonline.

👥 User Stories principales
Client

Sélectionner une date et un créneau horaire via un calendrier interactif.

Payer un acompte ou la totalité de la réservation (Stripe / PayPal – mode test).

Recevoir un email de confirmation après paiement.

Télécharger une facture PDF ou un QR Code unique contenant les informations de réservation.

Restaurateur

Gérer les disponibilités (horaires, fermetures exceptionnelles, créneaux complets).

Être notifié lors d’une nouvelle réservation (email ou dashboard).

Consulter les réservations confirmées pour organiser le service.

Administrateur

Suivre les paiements, réservations et statistiques globales.

Visualiser les restaurants par ville via Query Builder uniquement.

Accéder à un tableau de bord dynamique (top restaurants, pics horaires, volumes).

⚙️ Fonctionnalités techniques

Authentification sécurisée avec Laravel Breeze ou Jetstream.

Gestion des dates et horaires avec Carbon (validation, chevauchements, dates passées).

Validation backend avancée (email, téléphone, créneaux, paiement).

Intégration Stripe ou PayPal (mode test) avec gestion des erreurs.

Envoi automatique d’email ou génération de PDF (FPDF) après paiement.

Génération d’un QR Code unique après réservation confirmée.

Utilisation de Job Queue pour les tâches asynchrones (QR Code).

Nettoyage automatique des réservations de plus de 30 jours via Job Cron.

Mise en place de tests unitaires (PHPUnit) pour les fonctionnalités critiques.

🛠️ Technologies utilisées

Laravel

MySQL

Carbon

Stripe / PayPal (sandbox)

FPDF

Jobs & Queues

PHPUnit

 