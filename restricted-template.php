<?php
   /*
   Template Name: Restricted Access
   */
?>

<?php get_header();?>

<?php 
    $access_granted = (current_user_can('level_0')); 
    $content_template = get_post_meta($post->ID, 'content_template', true);

?>
<section class="section">
    <div class="container fullwidth-content">
        <!-- max w 920px-->
        <div class="row ">
            <!-- BEGIN PAGE TITLE -->
            <div class="col">
                <div id="page-title" class="">
                    <div class="title">
                        <!-- your title page -->

                        <?php if (!$access_granted){ ?>
                        <h1>Требуется вход</h1>
                        <?php } else { ?>
                        <h1><?php the_title();?></h1>
                        <?php }?>
                    </div>
                    <?php $data = get_post_meta($post->ID, '_short_desc', true ); ?>
                    <?php if ($data && $access_granted) : ?>
                    <div class="desc">
                        <!-- description about your page -->
                        <?php echo $data;?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!-- END OF PAGE TITLE -->
        <!-- BEGIN CONTENT -->
        <div class="row ">
            <div id="content-inner-full" class="">
                <?php if (!$access_granted){ ?>
                <!-- NO ACCESS -->
                <h3>Вход</h3>
                <form action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <p><label for="log">Имя</label></p>
                            </td>
                            <td>
                                <input type="text" name="log" id="log"
                                    value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="14" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><label for="pwd">Пароль</label></p>
                            </td>
                            <td><input type="password" name="pwd" id="pwd" size="14" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <label for="rememberme">
                                    <input name="rememberme" id="rememberme" type="checkbox" checked="checked"
                                        value="forever" /> Запомнить меня</label>
                                <input type="hidden" name="redirect_to"
                                    value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" value="Войти" name="submit" class="button cyan"
                                    style="margin-left:10px; padding-bottom:10px; width:120px;">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <p style="margin-left:10px; margin-top:10px;"><a
                                        href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Восстановить
                                        пароль</a></p>
                            </td>
                        </tr>
                    </table>
                </form>

                <!-- ACCES GRANTED -->
                <?php } else { ?>
                <?php if ($content_template) { ?>
                <div class="maincontent">
                    <?php 
                        try {
                            include (TEMPLATEPATH.'/restricted_content/'.$content_template.'');
                        } catch (Throwable $e) {
                            echo "Captured Throwable: ";
                        }
                    ?>
                </div>


                <?php } else { ?>
                <?php if (have_posts()) { ?>
                <?php while (have_posts()) : the_post();?>
                <div class="maincontent">
                    <?php the_content();?>
                </div>
                <?php endwhile;?>
                <?php } ?>
                <?php get_sidebar();?>
                <?php }?>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<!-- END OF CONTENT -->
<?php get_footer();?>