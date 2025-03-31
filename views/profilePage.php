<?php $title = $profile ?>

<img src="<?= $source ?? '' ?>" alt="profile picture of <?= htmlspecialchars($_SESSION['username']) ?>"/>

<h1><?= htmlspecialchars($user['username']) ?></h1>

<p><?= htmlspecialchars($user['bio']) ?></p>

<p>Feed list</p>
<ul>
    <?php foreach($rssFeeds as $feed): ?>
        <li><?= htmlspecialchars($feed['feedName']) ?></li>
    <?php endforeach; ?>
</ul>

<p>Your preferences:</p>
<ul>
    <?php foreach($preferences as $feed): ?>
        <li><?= htmlspecialchars($feed['feedName']) ?></li>
    <?php endforeach; ?>
</ul>



// interests
-> displaying sources drop down elles apparaissent toutes (tableau) et puis voilà c'est à Florian d'ajuster
max 6 choisies


// bookmarks
tous les bookmarks actuels :D

edit -> page profile mais avec un autre type de requete... ?
form qui va mettre à jour le tout