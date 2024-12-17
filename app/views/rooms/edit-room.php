<div class="container mt-5">
    <h2>Edit Room Details</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>
    <form action="/updateroom" method="POST">
        <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
        <div class="form-group">
            <label for="room_no">Room No</label>
            <input type="text" class="form-control" id="room_no" name="room_no" required value="<?= $room['room_number'] ?>">
        </div>
        <div class="form-group">
            <label for="room_type">Room Type</label>
            <input type="text" class="form-control" id="room_type" name="room_type" required value="<?= $room['room_type'] ?>">
        </div>
        <div class="form-group">
            <label for="room_price">Room Price per night</label>
            <input type="number" class="form-control" id="room_price" name="room_price" required value="<?= $room['price_per_night'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit Post</button>
    </form>
</div>