<div class="container mt-5">
    <h1 class="mb-4">Manage Room List Panel</h1>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Room No</th>
                <th>Room Type</th>
                <th>Room Price per Night</th>
                <th>Room Status</th>
                <th>check_in_date</th>
                <th>check_out_date</th>
                <th>total_amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            ?>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['room_number']) ?></td>
                    <td><?= htmlspecialchars($reservation['room_type']) ?></td>
                    <td><?= htmlspecialchars($reservation['price_per_night']) ?></td>
                    <td><?= htmlspecialchars($reservation['status']) ?></td>
                    <td><?= htmlspecialchars($reservation['check_in_date']) ?></td>
                    <td><?= htmlspecialchars($reservation['check_out_date']) ?></td>
                    <td><?= htmlspecialchars($reservation['total_amount']) ?></td>
                    <td>
                        <?php //if ($_SESSION['role'] == 'Guest') : 
                        ?>
                        <a href="/check-in-room/<?= $reservation['id'] ?>/<?= intval($reservation['price_per_night']) ?>" class="btn btn-danger btn-sm">check in Room</a>
                        <a href="/check-out-room/<?= $reservation['id'] ?>/<?= intval($reservation['price_per_night']) ?>/<?= $reservation['room_id'] ?>" class="btn btn-success btn-sm">check out Room</a>
                        <?php //endif; 
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/dashboard" class="btn btn-primary">Back to Dashboard</a>
</div>