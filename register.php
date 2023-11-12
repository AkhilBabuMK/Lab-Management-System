<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>User Registration</h2>

    <form method="post" action="registration.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>

        <div class="form-group">
            <label for="contactnumber">Contact Number:</label>
            <input type="text" class="form-control" name="contactnumber" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include('footer.php'); ?>

