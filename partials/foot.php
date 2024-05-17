        </main>
        <!-- site-wrapper -->
        <?php echo '<script src="//' . $config['assets'] . 'js/jquery.min.js?version=' . $config['version'] . '"></script>'; ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <?php echo '<script src="//' . $config['assets'] . 'js/main.js' . '"></script>'; ?>
        <?php if (isset($footerIncludes)) echo $footerIncludes ?>
    </body>

</html>