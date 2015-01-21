<html>

<head>
    <title>Users</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <ul>
        <?php
        $users = \User\Admin::all();

        foreach ($users as $user) :
            ?>
            <li> <?= $user->name(); ?> <i class="fa fa-times-circle" onclick="delete_user(<?= $user->user_id ?>);"></i></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" name="" action="<?= \Net\Request::rootUrl() ?>/user/create">
        <input type="text" name="user_name" value="">
        <input type="submit">
    </form>
</div>
</body>
<script>
    function delete_user(id) {
        document.location = '<?= \Net\Request::rootUrl() ?>/user/' + id + '/delete';
    }
</script>
</html>
