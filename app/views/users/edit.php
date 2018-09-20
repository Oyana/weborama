<form method="POST" action="<?= routeUrl($user->id . '/profile') ?>">
    <input type="hidden" name="_method" value="put">
    <input type="text" name="name" value="<?= $user->name ?>">
    <input type="text" name="password" value="<?= $user->password ?>">
    <input type="submit">
</form>
