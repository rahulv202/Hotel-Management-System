<div class="container mt-5">
    <h1 class="mb-4">All Room List Panel</h1>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Room No</th>
                <th>Room Type</th>
                <th>Room Price per Night</th>
                <th>Room Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            ?>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= htmlspecialchars($room['room_number']) ?></td>
                    <td><?= htmlspecialchars($room['room_type']) ?></td>
                    <td><?= htmlspecialchars($room['price_per_night']) ?></td>
                    <td><?= htmlspecialchars($room['status']) ?></td>
                    <td>
                        <?php if ($_SESSION['role'] == 'Admin') : ?>
                            <a href="/edit-room/<?= $room['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/delete-room/<?= $room['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        <?php endif; ?>
                        <?php if ($_SESSION['role'] == 'Staff') : ?>
                            <a href="/available-room/<?= $room['id'] ?>" class="btn btn-primary btn-sm">Room available</a>
                            <a href="/booked-room/<?= $room['id'] ?>" class="btn btn-danger btn-sm">Room booked</a>
                            <a href="/maintenance-room/<?= $room['id'] ?>" class="btn btn-warning btn-sm">Room maintenance</a>
                        <?php endif; ?>
                        <?php if ($_SESSION['role'] == 'Guest') : ?>
                            <a href="/guest-booked-room/<?= $room['id'] ?>" class="btn btn-danger btn-sm">Room booked</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/dashboard" class="btn btn-primary">Back to Dashboard</a>
</div>