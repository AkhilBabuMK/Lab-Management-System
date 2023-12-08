<footer class="bg-light  mt-2">
    <div class="container">
        <hr class="my-2">
        <p class="text-center text-muted mb-0">&copy; <?php echo date("Y"); ?> Lab Management System. All rights reserved.</p>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>

<?php
// Close your database connection
if (isset($conn)) {
    $conn->close();
}
?>
