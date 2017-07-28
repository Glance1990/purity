<?php

define("MIKADO_DB_MODE", 1);
define("MIKADO_WP_MODE", 2);

if (!class_exists("MikadoFE")) {
	class MikadoFE {
		
		public function __construct($db, $settings) 
		{
			$this->gallery = new stdClass();
			$this->settings = $settings;
			foreach($this->settings as $k => $v)
				$this->gallery->$k = $v;
			if(! isset($this->gallery->includeFontawesome))
				$this->gallery->includeFontawesome = 'T';
		
            if(! empty($_GET["debug"]))
            {
                print "<!--\n";	
                print_r($this->gallery);
                print "\n-->\n";
            }

			$this->db = $db;
			$this->wp_images = array();
			$this->images = array();
		}		
				
		public function initByGalleryId($id)
		{
			$this->id = $id;
			$this->gallery = $this->db->getGalleryById($this->id);
			$this->gallery->mode = MIKADO_DB_MODE;
			                
	        $this->images = $this->loadMikadoImages();
	        $ids = array();
	        foreach($this->images as $img)
	        	$ids[] = $img->imageId;
	        	
	        $this->loadWPImages($ids);
		}
        
        public function loadWPImages($ids)
        {
            $args = array(
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'include' => $ids
			);
			
			$this->wp_images = get_posts($args);
			if($this->gallery->lightbox == "attachment-page")
			{
				foreach($this->wp_images as $att)
				{
					$att->url = get_attachment_link($att->ID);
				}
			}
			
			
			if($this->gallery->mode == MIKADO_DB_MODE)
			{
				foreach($this->wp_images as $att)
				{
				
					//$this->images[$att->ID]->imagePath = $att->guid;
					$this->images[$att->ID]->url = $att->url;
				}
			}
        }
		
		public function initByImageIds($ids)
		{
			$this->imageIds = $ids;
			$this->gallery->mode = MIKADO_WP_MODE;
			$this->loadWPImages($ids);
			
            foreach($this->wp_images as $att)
            {            
            	$image = new stdClass();
            	$image->imageId = $att->ID;
            	$image->url = $att->url;
            	$image->Id = $att->ID;
            	$image->imagePath = $att->guid;
            	$image->link = get_post_meta($att->ID, "_mikado_link", true);

            	switch($this->gallery->wp_field_caption)
            	{
            		case 'title':
		            	$image->description = $att->post_title;
		            	break;
		            case 'caption':
		            	$image->description = $att->post_excerpt;
		            	break;
		            case 'description':
		            	$image->description = $att->post_content;
		            	break;
            	}
	            $this->images[$image->imageId] = $image;
	        }
	        
		}				
						
		public function getGallery()
		{
			return $this->gallery;
		}
		
		private function getLightboxClass($image)
		{
			if(! empty($image->link))
				return '';
				
			if(empty($this->gallery->lightbox))
				return '';
				
			return 'mikado-lightbox';
		}
		
		private function getLink($image)
		{
			if(! empty($image->link))
				return "href='" . $image->link . "'";
						
			if(empty($this->gallery->lightbox))
				return '';
							
			if($this->gallery->lightbox == 'attachment-page')
				return "href='" . $image->url . "'";
							
			return "href='" . $image->imagePath . "'";
		}
		
		private function getTarget($image)
		{
			if(! empty($image->target))
				return "target='" . $image->target . "'";
						
			if($this->gallery->blank == 'T')
				return "target='_blank'";
							
			return '';
		}
		
		private function getdef($value, $default)
		{
			if($value == NULL || empty($value))
				return $default;
				
			return $value;
		}
        
        private function toRGB($Hex){
            
            if (substr($Hex,0,1) == "#")
                $Hex = substr($Hex,1);
            
            $R = substr($Hex,0,2);
            $G = substr($Hex,2,2);
            $B = substr($Hex,4,2);

            $R = hexdec($R);
            $G = hexdec($G);
            $B = hexdec($B);

            $RGB['R'] = $R;
            $RGB['G'] = $G;
            $RGB['B'] = $B;
            
            $RGB[0] = $R;
            $RGB[1] = $G;
            $RGB[2] = $B;

            return $RGB;

        }
		
		static public function slugify($text)
		{ 
		  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		  $text = trim($text, '-');
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		  $text = strtolower($text);
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  if (empty($text))
		  {
		    return 'n-a';
		  }

		  return $text;
		}

		static public function getFilters($filters)
		{
			if(empty($filters))
				return "";

			$css = array();
			foreach (explode("|", $filters) as $f) {
				$css[] = "jtg-filter-" . MikadoFE::slugify($f);
			}

			return implode(" ", $css);
		} 

		private function v($name)
		{
			switch($this->mode)
			{
				default:
				case MIKADO_DB_MODE:
					return $this->gallery->$name;
					break;
				case MIKADO_WP_MODE:
					return $this->settings[$name];
			}
		}

		public function render() 
		{
			
			$rid = rand(1, 1000);
			            
            if($this->v('shuffle') == 'T')
            	shuffle($this->images);
    
            $bgCaption = $this->toRGB($this->gallery->captionBackgroundColor);
            $html = "";            

			$html .= "<style>\n";
            $html .= "#jtg-$this->id$rid .item .icon { color:".$this->gallery->captionIconColor." }\n";
			
			if($this->gallery->borderSize)
				$html .= "#jtg-$this->id$rid .item { border: " . $this->gallery->borderSize . "px solid " . $this->gallery->borderColor . "; }\n";

			if($this->gallery->borderRadius)
				$html .= "#jtg-$this->id$rid .item { border-radius: " . $this->gallery->borderRadius . "px; }\n";

			if($this->gallery->shadowSize)
				$html .= "#jtg-$this->id$rid .item { box-shadow: " . $this->gallery->shadowColor ." 0px 0px " . $this->gallery->shadowSize . "px; }\n";
            
            
            $html .= "#jtg-$this->id$rid .item .caption { background-color: ".$this->gallery->captionColor."; }\n";
            $html .= "#jtg-$this->id$rid .item .caption { background-color: rgba($bgCaption[0], $bgCaption[1], $bgCaption[2], ". ($this->gallery->captionOpacity/100) . "); }\n";
            
            $html .= "#jtg-$this->id$rid .item .caption { color: ".$this->gallery->captionColor."; }\n";
            
            $html .= "#jtg-$this->id$rid .items { width:".$this->gallery->width."; height:".$this->gallery->height." }\n";
            
			if(strlen($this->gallery->style))
				$html .= $this->gallery->style;

			$html .= "</style>\n";                 	           

            $html .= "<div class='mikado' id='jtg-$this->id$rid'>\n";
            if(strlen($this->gallery->filters))
            {
            	$filters = explode("|", $this->gallery->filters);
            	$html .= "<div class='filters'>\n";
            	$html .= "\t<a href='#' class='selected'>All</a>\n";
            	foreach($filters as $filter)
            	{
            		$html .= "\t<a href='#jtg-filter-". MikadoFE::slugify($filter) ."'>$filter</a>\n";
            	}
            	$html .= "</div>\n";
            }
            $html .= "<div class='items'>\n";
			foreach($this->images as $image)
			{
				$title = in_array($this->gallery->lightbox, array('prettyphoto', 'fancybox', 'swipebox', 'lightbox2')) ? "title" : "data-title";
				$rel = $this->gallery->lightbox == "prettyphoto" ? "prettyPhoto[jtg-$this->id$rid]" : "jtg-$this->id$rid";
            	$html .= "<div class='item ". MikadoFE::getFilters($image->filters) . " " . (!empty($this->gallery->captionIcon) ? "with-icon" : "") . " " . (!empty($image->description) ? "with-text" : "no-text") . "'>\n";
            	
            	if(! empty($_GET["debug"]))
            	{
            		print "<!--\n";
	            	print_r($image);
	            	print "\n-->\n";
            	}
            	
                $html .= "<a $title='$image->description' ". ($this->gallery->lightbox == "lightbox2" ? "data-lightbox='gallery'" : "") ." rel='$rel' " . $this->getTarget($image) . " class='tile-inner " . ($this->getLightboxClass($image)) . "' " . $this->getLink($image) . ">\n";
				$html .= "<img data-valign='$image->valign' data-halign='$image->halign' class='pic' src='$image->imagePath' />\n";
                if(! empty($image->description) || !empty($this->gallery->captionIcon))
                {
                    $html .= "<span class='caption'>\n";
                    
                    if(! empty($this->gallery->captionIcon))
                        $html .= "<span class='icon fa fa-".$this->gallery->captionIcon."'></span>\n";
                    
                    if(! empty($image->description))
                        $html .= "<span class='text'>".$image->description."</span>\n";
                                
                    $html .= "</span>";
                }
                $html .= "</a>\n";
                $html .= "</div>\n";
			}
            $html .= "</div>\n";
            $html .= "</div>\n";
            
            $html .= "<script type='text/javascript'>\n";
            $html .= "\tjQuery('#jtg-$this->id$rid').tilesGallery2({\n";
            
            if(strlen($this->gallery->script))
            {
            	$html .= "\t\tonComplete: function () { " . stripslashes($this->gallery->script) . "},\n";
            }
            
            $html .= "\t\tmargin: ". $this->gallery->margin .",\n";   
            $html .= "\t\tcaptionEffectDuration: ". $this->gallery->captionEffectDuration .",\n";
            $html .= "\t\tcaptionEffect: '".$this->gallery->captionEffect."',\n";
            $html .= "\t\tcaptionEasing: '".$this->gallery->captionEasing."',\n";
            $html .= "\t\tkeepArea: " . ($this->gallery->keepArea == "T" ? "true" : "false") . ",\n";
			$html .= "\t\tenableTwitter: " . ($this->gallery->enableTwitter == "T" ? "true" : "false") . ",\n";
			$html .= "\t\tenableFacebook: " . ($this->gallery->enableFacebook == "T" ? "true" : "false") . ",\n";
			$html .= "\t\tenablePinterest: " . ($this->gallery->enablePinterest == "T" ? "true" : "false") . ",\n";
			$html .= "\t\tenableGplus: " . ($this->gallery->enableGplus == "T" ? "true" : "false") . ",\n";
			$html .= "\t\tscrollEffect: '"  . ($this->gallery->scrollEffect) . "'\n";
            $html .= "\t});\n";			
            
			$html .= "\tjQuery(function () {\n";
			switch ($this->gallery->lightbox) {
				default:
					break;
				case 'magnific':
					$html .= "\t\tjQuery('#jtg-$this->id$rid').magnificPopup({type:'image', zoom: { enabled: true, duration: 300, easing: 'ease-in-out' }, image: { titleSrc: 'data-title' }, gallery: { enabled: true }, delegate: '.tile:not(.jtg-hidden) .mikado-lightbox ' });\n";
					break;
				case 'prettyphoto':
					$html .= "\t\tjQuery('#jtg-$this->id$rid .tile a.mikado-lightbox').prettyPhoto({social_tools:''});\n";
					break;
				case 'colorbox':
					$html .= "\t\tjQuery('#jtg-$this->id$rid .tile a.mikado-lightbox').colorbox({rel: 'gallery', title: function () { return jQuery(this).data('title'); }});\n";
					break;
				case 'fancybox':
					$html .= "\t\tjQuery('#jtg-$this->id$rid .tile a.mikado-lightbox').fancybox({});\n";
					break;
				case 'swipebox':
					$html .= "\t\tjQuery('#jtg-$this->id$rid .tile a.mikado-lightbox').swipebox({});\n";
					break;
			}

			$html .= "\t});\n";			 
			$html .= "</script>";
			
			if(! empty($_GET["debug"]))
				return $html;

			return str_replace(array("\n", "\t"), "", $html);
		}
		
		public function loadMikadoImages() 
		{
			$images = array();
			foreach($this->db->getImagesByGalleryId($this->id) as $img)
				$images[$img->imageId] = $img;
				
			return $images;
		}			
	}
}
?>