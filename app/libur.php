<?php
include '../include/koneksi.php';
// memulai session

session_start();
error_reporting(0);
/**
 * Jika Tidak login atau sudah login tapi bukan sebagai admin
 * maka akan dibawa kembali kehalaman login atau menuju halaman yang seharusnya.
 */
if ( !isset($_SESSION['level'])) {

	header('location:../login');
	exit();
}
 ?>
<!DOCTYPE html>
<html>

<?php
include 'include/head.php' 
?>

<body class="theme-indigo">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
	<?php
	include 'include/top_bar.php' 
	?>
    <section>
        <!-- Left Sidebar -->
        <?php
		include 'include/side_bar_i.php' 
		?>
        <!-- #END# Left Sidebar -->
       
    </section>

    <section class="content">
		<?php
		include 'content/content_libur.php' 
		?>    
    </section>

    <?php
		include 'include/script.php' 
		?>
	<script src="../js/notie/notie.js"></script>
<script src="../js/notie/notie-init.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		     notie.alert(1, 'Terimakasih! <?= base64_decode($_GET['sukses']);?>', 2);
});
</script>
<script type="text/javascript">
$(document).ready(function(){
         notie.alert(3, '<?= base64_decode($_GET['error']);?>.', 2);
});
</script>
</body>

</html>