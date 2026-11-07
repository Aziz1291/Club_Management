<?php if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === basename(__FILE__)) { require_once __DIR__ . '/../auth.php'; require_login(); header('Location: index.php'); exit; } ?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 order-last order-md-first">
                <div class="copyright text-center text-md-start">
                    <p>
                        <strong>ClubManager</strong> &copy; <?= date('Y') ?> &bull; Academic club management demo
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="terms d-flex justify-content-center justify-content-md-end">
                    
                    
                    <a href="/public/privacy.php">Privacy &amp; cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

</main>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>

