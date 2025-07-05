=== WP UserDisable ===
Contributors: kevinbenabdelhak
Tags: user management, WordPress, admin tools, disable users
Requires at least: 5.0
Tested up to: 6.7.1
Requires PHP: 7.0
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

### WP UserDisable – Désactivez les comptes utilisateurs en un clic

**WP UserDisable** est un plugin WordPress pratique qui permet aux administrateurs de désactiver rapidement les comptes utilisateurs, facilitant ainsi la gestion des utilisateurs et la sécurité du site.

#### Fonctionnalités principales :

1. **Désactivation des utilisateurs en un clic** : Désactivez un utilisateur directement depuis la liste des utilisateurs avec une case à cocher.
2. **Gestion facile des comptes désactivés** : Vérifiez rapidement quel utilisateur est désactivé et réactivez-le en un clic.
3. **Intégration transparente** : S'intègre facilement dans l'interface d'administration de WordPress.
4. **Sécurité renforcée** : Utilise des vérifications de nonce pour garantir que seules les actions validées sont effectuées.

#### Cas d'utilisation :
- **Gestion des comptes utilisateurs** : Désactivez les comptes inactifs ou problématiques pour améliorer la sécurité.
- **Assistance aux utilisateurs** : Permettez aux administrateurs de gérer les utilisateurs sans avoir à se connecter pour résoudre des problèmes.
- **Audit de comptes** : Accédez rapidement à une liste des utilisateurs désactivés pour un audit facile.

== Installation ==

1. **Téléchargez le fichier ZIP du plugin :**
   Rendez-vous sur la page https://kevin-benabdelhak.fr/plugins/wp-user-disable/ et téléchargez le fichier en cliquant sur Code, puis télécharger en zip.

2. **Uploader le fichier ZIP du plugin :**
   - Allez dans le panneau d'administration de WordPress et cliquez sur "Extensions" > "Ajouter".
   - Cliquez sur "Téléverser une extension".
   - Choisissez le fichier ZIP que vous avez téléchargé et cliquez sur "Installer maintenant".

3. **Activer le plugin :**
   Une fois le plugin installé, cliquez sur "Activer".

4. **Utilisation du plugin :**
   - Allez dans la liste des utilisateurs.
   - Utilisez la case à cocher "Désactiver" pour gérer les comptes utilisateurs.
   - Vérifiez les utilisateurs désactivés et réactivez-les si nécessaire.

== FAQ ==

= Est-ce que le plugin affecte les performances de mon site ? =

Non, le plugin est léger et n'affecte pas les performances de votre site. Il est lu en tant qu'admin dans la partie admin (les fonctions sont reliés au bon hook wp), 100% ajax

== MAJ ==

= 1.0 =
* Ajout de la fonctionnalité de désactivation des utilisateurs avec une interface conviviale.
* Possibilité de gérer facilement l'état des comptes utilisateurs.