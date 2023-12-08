<footer class="bg-light  mt-2">
    <div class="container">
        <hr class="my-2">
        <p class="text-center text-muted mb-0">&copy; <?php echo date("Y"); ?> Lab Management System. All rights reserved.</p>
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
