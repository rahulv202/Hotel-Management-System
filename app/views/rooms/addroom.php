<div class="container mt-5">
    <h2>Add New Room</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>
    <form action="/addroom" method="POST">
        <div class="form-group">
            <label for="room_no">Room No</label>
            <input type="text" class="form-control" id="room_no" name="room_no" required>
        </div>
        <div class="form-group">
            <label for="room_type">Room Type</label>
            <input type="text" class="form-control" id="room_type" name="room_type" required>
        </div>
        <div class="form-group">
            <label for="room_price">Room Price per night</label>
            <input type="number" class="form-control" id="room_price" name="room_price" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Post</button>
    </form>
</div>