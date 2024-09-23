</main>
<footer id="site-footer"> 
    <div class="footer-content">
        <hr class="custom-line">
        <nav class="footer-navigation">
            <ul class="footer-menu">
                <li><a href="<?php echo esc_url(home_url('/mentions-legales')); ?>">MENTIONS LÉGALES</a></li>
                <li><a href="<?php echo esc_url(get_privacy_policy_url()); ?>">VIE PRIVÉE</a></li>
                <li><a href="">TOUT DROITS RÉSERVÉS</a></li>
            </ul>
        </nav>
    </div>
    <?php get_template_part ('template-parts/contact');?>
</footer>
<?php get_template_part ('template-parts/lightbox');?>
<?php wp_footer() ?>
</body>
</html>