<?php


function mikado_install_db() 
{
  global $wpdb;			  

  $MikadoGalleries = $wpdb->MikadoGalleries;
  $MikadoImages = $wpdb->MikadoGalleriesImages;
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		
  $sql = "CREATE TABLE $MikadoGalleries (
	 	Id INT NOT NULL AUTO_INCREMENT, 
		name VARCHAR( 30 ) NOT NULL, 
		slug VARCHAR( 30 ) NOT NULL, 
		description VARCHAR( 500 ) NULL,
        filters VARCHAR( 1500 ) NULL,
        width VARCHAR ( 10 ) DEFAULT \"100%\" NOT NULL,
        height VARCHAR ( 10 ) DEFAULT \"500px\" NOT NULL,
        margin INT NOT NULL, 
        blank ENUM('T','F') DEFAULT \"F\" NOT NULL, 
        lightbox VARCHAR( 50 ) DEFAULT \"magnific\" NOT NULL,
        captionEffect VARCHAR(20) DEFAULT \"fade\" NOT NULL,        
        scrollEffect VARCHAR(50) DEFAULT \"slide\" NOT NULL,
        wp_field_caption VARCHAR(50) NULL DEFAULT \"description\",
        captionIcon VARCHAR(50) NULL,
        captionIconColor VARCHAR(7) DEFAULT \"#FFFFFF\" NOT NULL,
        captionColor VARCHAR(7) DEFAULT \"#FFFFFF\" NOT NULL,
        captionBackgroundColor VARCHAR(7) DEFAULT \"#000000\" NOT NULL,
        captionOpacity INT DEFAULT 80 NOT NULL,
        captionEffectDuration INT DEFAULT 250 NOT NULL,
        captionEasing VARCHAR(50) DEFAULT \"swing\" NOT NULL,
        shuffle ENUM('T','F') NOT NULL,   
        keepArea ENUM('T','F') DEFAULT \"F\" NOT NULL,
        enableTwitter ENUM('T','F') NOT NULL, 
        enableFacebook ENUM('T','F') NOT NULL, 
        enableGplus ENUM('T','F') NOT NULL, 
        enablePinterest ENUM('T','F') NOT NULL, 
        includeFontawesome ENUM('T','F') DEFAULT \"T\" NOT NULL, 
        borderSize INT DEFAULT 0 NOT NULL,
        borderColor VARCHAR(7) DEFAULT \"#ffffff\" NOT NULL,
        shadowSize INT DEFAULT 0 NOT NULL,
        shadowColor VARCHAR(7) DEFAULT \"#000000\" NOT NULL,
        backgroundColor VARCHAR(7) DEFAULT \"#ffffff\" NOT NULL,
        borderRadius INT DEFAULT 0 NOT NULL, 
        style VARCHAR( 1000 ) NULL,
        script VARCHAR( 1000 ) NULL,
        UNIQUE KEY id (id)
  ) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;";
	
  dbDelta( $sql );

  $sql = "CREATE TABLE $MikadoImages (
		Id INT NOT NULL AUTO_INCREMENT, 
		gid INT NOT NULL, 
		imageId INT NOT NULL, 
		imagePath LONGTEXT NOT NULL, 
		link LONGTEXT NULL,
		target VARCHAR(50) NULL,
		filters VARCHAR( 1500 ) NULL,
		description LONGTEXT NULL, 
		sortOrder INT NOT NULL,  
		valign VARCHAR(50) DEFAULT \"middle\" NOT NULL,
		halign VARCHAR(50) DEFAULT \"center\" NOT NULL,
		UNIQUE KEY id (Id) 
	) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";

	dbDelta( $sql );

}
