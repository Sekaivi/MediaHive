<<<<<<< HEAD
// profile pic

<img src="<?= $source ?? '' ?>" alt="profile picture of <?= htmlspecialchars($_SESSION['username']) ?>"/>

<h1><?= htmlspecialchars($user['username']) ?></h1>

<p><?= htmlspecialchars($user['bio']) ?></p>



// interests
-> displaying sources drop down elles apparaissent toutes (tableau) et puis voilà c'est à Florian d'ajuster
max 6 choisies


// bookmarks
tous les bookmarks actuels :D

edit -> page profile mais avec un autre type de requete... ?
=======
// profile pic

<img src="<?= $source ?>" alt="profile picture of <?= $_SESSION['username'] ?>"/>

// username

// bio

// interests
-> displaying sources drop down elles apparaissent toutes (tableau) et puis voilà c'est à Florian d'ajuster
max 6 choisies


// bookmarks
tous les bookmarks actuels :D

edit -> page profile mais avec un autre type de requete... ?
>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
form qui va mettre à jour le tout