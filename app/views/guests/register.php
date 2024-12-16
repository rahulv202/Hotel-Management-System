<div class="container">
    <h1 class="mt-5">Admin Register</h1>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>
    <form method="POST" action="/register" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" class="form-control" id="role" name="role" placeholder="Role" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <p class="mt-3"><a href="/login">Login</a></p>
    </form>
</div>