<div class="container mt-5">
    <?php //print_r($user_data); 
    ?>
    <h1 class="mb-4">Welcome, <?= htmlspecialchars(
                                    ($_SESSION['role'] == 'Admin') ? $user_data[0]['username'] : $user_data[0]['name']
                                )
                                ?></h1>
    <p><strong>Email:</strong> <?= htmlspecialchars($user_data[0]['email']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['role']) ?></p>
    <?php if ($_SESSION['role'] == 'Staff') : ?>
        <p><strong>Sub Role:</strong> <?= htmlspecialchars($user_data[0]['role']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user_data[0]['phone']) ?></p>
    <?php endif; ?>

    <?php if ($_SESSION['role'] == 'Admin') : ?>
        <p><a href="/user-list" class="btn btn-info">User List Panel</a></p>
    <?php endif; ?>

    <a href="/<?php echo htmlspecialchars(strtolower($_SESSION['role'])); ?>/logout" class="btn btn-danger">Logout</a>

</div>