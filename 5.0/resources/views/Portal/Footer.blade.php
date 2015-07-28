<footer class="site-footer">
    <div class="text-center">
        &copy; <?php echo date('Y').' '.$_siteName; ?>
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<script type="text/javascript">
    var errorInputs = <?php echo json_encode($errorFields); ?>;
</script>
