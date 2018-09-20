<small><a href="profile/create">New</a></small>
<br><br>
<?php foreach ($users as $user) { ?>
        <a href="<?= $user->id ?>/profile"><?= $user->name ?></a>
        <small><a href="<?= $user->id ?>/profile/edit">Edit</a></small>
        <form method='post' action="<?= $user->id ?>/profile">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Delete</button>
        </form>
        <br/>
 <?php } ?>
