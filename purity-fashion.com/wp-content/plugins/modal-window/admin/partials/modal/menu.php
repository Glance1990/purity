<?php
global $wpdb;
$table_modal = $wpdb->prefix . "modalsimple";
$info = (isset($_REQUEST["info"])) ? $_REQUEST["info"] : '';
if ($info == "saved") {
    echo "<div class='updated' id='message'><p><strong>".__("Record Added", "wow-marketings")."</strong>.</p></div>";
}
if ($info == "update") {
    echo "<div class='updated' id='message'><p><strong>".__("Record Updated", "wow-marketings")."</strong>.</p></div>";
}
if ($info == "del") {
    $delid = $_GET["did"];
    $wpdb->query("delete from " . $table_modal . " where id=" . $delid);
    echo "<div class='updated' id='message'><p><strong>".__("Record Deleted", "wow-marketings").".</strong>.</p></div>";
}
$resultat = $wpdb->get_results("SELECT * FROM " . $table_modal . " order by id asc");
$count = count($resultat);
?>
<div class="wow">
<h1><?php esc_attr_e("Modal Window", "wow-modal-windows") ?></h1>
<ul class="wow-admin-menu">
<li><a href='admin.php?page=wow-modalsimple'><?php esc_attr_e("List", "wow-marketings") ?></a></li>
<li>
	<?php if($count<3){?>
	<a href='admin.php?page=wow-modalsimple&wow=add' ><?php esc_attr_e("Add new", "wow-marketings") ?></a>
	<?php } ?>
	</li>
<li><a href='admin.php?page=wow-modalsimple&wow=discount'><b><?php esc_attr_e("Pro version", "wow-marketings") ?></b></a></li>
<li><a href='admin.php?page=wow-modalsimple&wow=items'><b><?php esc_attr_e("Free Plugins", "wow-marketings") ?></b></a></li>

</ul>
<div class="wow_admin_signup">
<div class="wow-admin-col">
<div class="wow-admin-col-6">
<h2>MAKE MONEY WITH US:</h2>
<a href="https://wow-estore.com/en/affiliates/" target="_blank"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/hero.png" /></a>
<!--End mc_embed_signup-->

</div>
<div class="wow-admin-col-6">
<h2>KEEP UP WITH THE INDUSTRY:</h2>
<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fwowaffect%2F&tabs&width=500&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=365329313856232" width="500" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
</div>
</div>

</div>