</main>

<footer class="bg-light p-3 mt-4">
    <div class="container">
        <!-- Your footer content goes here -->
        <p class="text-muted">&copy; <?php echo date("Y"); ?> Your Website Name. All rights reserved.</p>
    </div>
</footer>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add your custom JavaScript links or other footer elements here -->

</body>
</html>

<?php
// Close your database connection
if (isset($conn)) {
    $conn->close();
}
?>

