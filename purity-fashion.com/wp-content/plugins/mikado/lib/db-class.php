<?php
class MikadoDB {
    
    private static $pInstance;
    
    private function __construct() {}
    
    public static function getInstance() {
        if(!self::$pInstance) {
            self::$pInstance = new MikadoDB();
        }
        
        return self::$pInstance;
    }
    
    public function query() {
        return "Test";  
    }
    
    public function addGallery($data) {
        global $wpdb;   
        $galleryAdded = $wpdb->insert( $wpdb->MikadoGalleries, $data);
        print $wpdb->last_error;
        return $galleryAdded;
    }
    
    public function getNewGalleryId() {
        global $wpdb;
        return $wpdb->insert_id;
    }
    
    public function deleteGallery($gid) {
        global $wpdb;
        $wpdb->query( "DELETE FROM $wpdb->MikadoGalleriesImages WHERE gid = '$gid'" );
        $wpdb->query( "DELETE FROM $wpdb->MikadoGalleries WHERE Id = '$gid'" );
    }
    
    public function editGallery($gid, $data) {
        global $wpdb;
        $imageEdited = $wpdb->update( $wpdb->MikadoGalleries, $data, array( 'Id' => $gid ) );
        
        return $imageEdited;
    }
    
    public function getGalleryById($id) {
        global $wpdb;
        $query = "SELECT * FROM $wpdb->MikadoGalleries WHERE Id = '$id'";
        $gallery = $wpdb->get_row($query);
        return $gallery;
    }
    
    public function getGalleries() {
        global $wpdb;
        $query = "SELECT Id, name, slug, description FROM $wpdb->MikadoGalleries";
        $galleryResults = $wpdb->get_results( $query );
        return $galleryResults;
    }
    
    public function addImage($gid, $image) {
        global $wpdb;       
        $imageAdded = $wpdb->insert( $wpdb->MikadoGalleriesImages, array( 'gid' => $gid, 'imagePath' => $image, 'title' => "", 'description' => "", 'sortOrder' => 0 ) );
print $wpdb->last_error;
        return $imageAdded;
    }

    public function addImages($gid, $images) {
        global $wpdb;       

        foreach ($images as $image) {
            if(! isset($image->description))
                $image->description = "";
            if(! isset($image->filters))
                $image->filters = "";

            $imageAdded = $wpdb->insert( $wpdb->MikadoGalleriesImages, 
                array( 'gid' => $gid, 'imagePath' => $image->imagePath, 
                         'description' => $image->description, 
                    'imageId' => $image->imageId, 'sortOrder' => 0, 'filters' => $image->filters ) );
            $id = $wpdb->insert_id;
            $wpdb->update($wpdb->MikadoGalleriesImages, array('sortOrder' => $id), array('id' => $id));
        }

        return true;
    }
    
    public function addFullImage($data) {
        global $wpdb;       
        $imageAdded = $wpdb->insert( $wpdb->MikadoGalleriesImages, $data );
        return $imageAdded;
    }
    
    public function deleteImage($id) {
        global $wpdb;
        $query = "DELETE FROM $wpdb->MikadoGalleriesImages WHERE Id = '$id'";
        if($wpdb->query($query) === FALSE) {
            return false;
        }
        else {
            return true;
        }
    }
    
    public function editImage($id, $data) {
        global $wpdb;
        $imageEdited = $wpdb->update( $wpdb->MikadoGalleriesImages, $data, array( 'Id' => $id ) );
        //exit( var_dump( $wpdb->last_query ) );
        return $imageEdited;
    }

    public function sortImages($ids) {
        global $wpdb;
        $index = 1;
        foreach($ids as $id) 
        {
            $data = array('sortOrder' => $index++);
            $wpdb->update( $wpdb->MikadoGalleriesImages, $data, array( 'Id' => $id ) );
        }
        return true;
    }
    
    public function getImagesByGalleryId($gid) {
        global $wpdb;
        $query = "SELECT * FROM $wpdb->MikadoGalleriesImages WHERE gid = $gid ORDER BY sortOrder ASC";
        $imageResults = $wpdb->get_results( $query );
        return $imageResults;
    }
    
    public function getGalleryByGalleryId($gid) {
        global $wpdb;
        $query = "SELECT $wpdb->MikadoGalleries.*, $wpdb->MikadoGalleriesImages.* FROM $wpdb->MikadoGalleries INNER JOIN $wpdb->MikadoGalleriesImages ON ($wpdb->MikadoGalleries.Id = $wpdb->MikadoGalleriesImages.gid) WHERE $wpdb->MikadoGalleries.Id = '$gid' ORDER BY sortOrder ASC";           
        $gallery = $wpdb->get_results( $query );        
        return $gallery;
    }
}
?>