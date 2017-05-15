<?php

class GMWDControllerMaps_gmwd extends GMWDController{
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	private $map;
	private $shortcode_id = null;
	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function display_pois(){
		$this->view->display_pois();
		
	}  
	public function remove($table_name = ""){
		global $wpdb;
		$ids = isset($_POST["ids"]) ? $_POST["ids"] :(isset($_POST["id"]) ? array($_POST["id"]) :  array());	
		if(empty($ids) === false){
			foreach($ids as $id){	
				$where = array("map_id" => (int)$id);
				$where_format = array('%d');
				$wpdb->delete(  $wpdb->prefix ."gmwd_markers", $where, $where_format);
				$wpdb->delete(  $wpdb->prefix ."gmwd_polygons", $where, $where_format);
				$wpdb->delete(  $wpdb->prefix ."gmwd_polylines", $where, $where_format);
			}			
		}
		parent::remove($table_name);		
	}
	

    public function download_markers(){
        update_option('gmwd_download_markers',1);
        $marker_categories = array("clothtexture", "coloring",  "modern", "papertexture", "retro", "standart", "woodtexture");
        foreach($marker_categories as $marker_category){
            if($marker_category == "standart"){
                $count = 52;
            }
            else{
                $count = 13;
            }
            for($i=1; $i<=$count; $i++){
                $file256_name = $marker_category."/".$marker_category."_".$i.".png";
                $file64_name = $marker_category."/".$marker_category."_".$i."_64.png";
                
                $file256 = file_get_contents("http://devops.web-dorado.info/anna/markers/".$file256_name);
                $file64 = file_get_contents("http://devops.web-dorado.info/anna/markers/".$file64_name);
                
                file_put_contents(GMWD_DIR.'/images/markers/'.$file256_name, $file256);
                file_put_contents(GMWD_DIR.'/images/markers/'.$file64_name, $file64);
            }
             
        }    
    }
   
    public function map_data(){
        $map_model = GMWDHelper::get_model("maps");
        $id = (int)$_POST["map"];
        if($id){
            $row = $map_model->get_row($id);
            echo json_encode($row);
            die();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
    protected function cancel(){
		GMWDHelper::gmwd_redirect("admin.php?page=maps_gmwd");		
	}
 	protected function save(){		
		$this->store_data();	
		GMWDHelper::message(__("Item Succesfully Saved.","gmwd"),'updated');
		$this->display();			
	}


	public function apply(){	
		$this->store_data();	
		GMWDHelper::gmwd_redirect("admin.php?page=maps_gmwd&task=edit&id=".$this->map."&message_id=1&active_main_tab=".GMWDHelper::get('active_main_tab')."&active_settings_tab=".GMWDHelper::get('active_settings_tab')."&active_poi_tab=".GMWDHelper::get('active_poi_tab'));		
		GMWDHelper::message(__("Item Succesfully Saved.","gmwd"),'updated');
		//$this->view->edit($this->map);
		
	}
    public function for_preview(){      
        $response = array();
        $url = admin_url( 'index.php?page=gmwd_preview');
        $url = add_query_arg(array("map_id"=> $this->map), $url);
        $response["url"] = $url;
        $response["map_id"] = $this->map;
        echo json_encode($response);
        die();
        
    }
   	protected function save2copy(){
        $this->store_data();
    	GMWDHelper::message(__("Item Succesfully Saved.","gmwd"),'updated');
		$this->display();
    } 
    
    protected function dublicate($table_name = ""){  
        global $wpdb;
		$ids = array();
		if(isset($_POST["ids"])){
			$ids = $_POST["ids"] ;			
		}
        if(empty($ids) === false){
			$map_columns = GMWDModel::get_columns("gmwd_maps");
			$map_column_types = GMWDModel::column_types("gmwd_maps");
			
			$pois = array("markers", "polygons", "polylines");
			foreach($ids as $id){
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "gmwd_maps  WHERE id = '%d'", (int)$id ));
				$data = array();
				$format = array();
				foreach($map_columns as $column_name){
					$data[$column_name] = esc_html(stripslashes($row->$column_name));
					$format[] = $map_column_types[$column_name];		
				}
				$data["id"] = "";
				$max_shortcode_id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "gmwd_shortcodes"); 
				$data["shortcode_id"] = $max_shortcode_id + 1;

				
				$wpdb->insert( $wpdb->prefix . "gmwd_maps", $data, $format );
				$last_map_id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "gmwd_maps");
				
				$this->shortcode_id = $max_shortcode_id + 1;
				$this->map = $last_map_id;
				$this->store_shortcode();
				
				foreach($pois as $poi){
					$columns = GMWDModel::get_columns("gmwd_".$poi);
					unset($columns[0]);
					$inserted_columns = $columns;
					$inserted_columns[array_search("map_id",$inserted_columns)] = $last_map_id;
					$columns = implode(",", $columns);
					$inserted_columns = implode(",", $inserted_columns);
					$rows_poi = $wpdb->query("INSERT INTO  " . $wpdb->prefix . "gmwd_".$poi." (".$columns.")
					SELECT ".$inserted_columns." FROM " . $wpdb->prefix . "gmwd_".$poi." WHERE map_id = '". (int)$id."'");

				}
			}
			GMWDHelper::message(__("Item Succesfully Duplicated.","gmwd"),'updated');
		}
		else{
			GMWDHelper::message(__("You Must Select At Least One Item.","gmwd"),'updated');
		}
		
        $view = $this->view;
		$view->display();         
    }
    
    private function store_data(){
		$this->store_map_data();
        if($this->shortcode_id){
            $this->store_shortcode();
        }
        $markers_count = GMWDHelper::get("markers_count");
        
        $data_markers = array();
        for($i=0; $i<$markers_count; $i++){
            $data_markers = array_merge($data_markers,json_decode(htmlspecialchars_decode(stripslashes(GMWDHelper::get("main_markers".$i)))));
        }
		$data_polygons = json_decode(htmlspecialchars_decode(stripslashes(GMWDHelper::get("polygons"))));
		$data_polylines = json_decode(htmlspecialchars_decode(stripslashes(GMWDHelper::get("polylines"))));

		$this->store_poi_data("markers", $data_markers);
		$this->store_poi_data("polygons", $data_polygons);
		$this->store_poi_data("polylines", $data_polylines);
		
	}
	private function store_map_data(){
		global $wpdb;
		
		$columns = GMWDModel::get_columns("gmwd_maps");
		$column_types = GMWDModel::column_types("gmwd_maps");

		$data = array();
		$format = array();
		foreach($columns as $column_name){
			$data[$column_name] = esc_html(stripslashes(GMWDHelper::get($column_name)));
			$format[] = $column_types[$column_name];		
		}	
        $data["theme_id"] = 1;
        $data["circle_line_width"] = 2;
        $data["circle_line_color"] = '000';
        $data["circle_line_opacity"] = 0.6;
        $data["circle_fill_color"] = "7FDF16";
        $data["circle_fill_opacity"] = 0.3;
        $data["directions_window_width"] = 100;
        $data["directions_window_width_unit"] = "%";
        
		if( GMWDHelper::get("id") == NULL || $this->task == "save2copy"){	
            $max_shortcode_id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "gmwd_shortcodes");  
			$data["published"] = 1;
			$data["shortcode_id"] = $max_shortcode_id + 1;
			$data["id"] = "";
		
			$wpdb->insert( $wpdb->prefix . "gmwd_maps", $data, $format );
			//$wpdb->print_error(); exit;
			$id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "gmwd_maps");
                  
            $this->shortcode_id = $max_shortcode_id + 1;
		}
		else{
			$data["published"] = esc_html(GMWDHelper::get("published"));
			$where = array("id"=>(int)GMWDHelper::get("id"));
			$where_format = array('%d');
			$wpdb->update( $wpdb->prefix . "gmwd_maps", $data, $where, $format, $where_format );
			$id = GMWDHelper::get("id");
		}		
		$this->map = $id;
       
        
	}

	private function store_poi_data($poi, $data_pois){		
		global $wpdb;
		$data_types = GMWDModel::column_types("gmwd_".$poi);

		foreach($data_pois as $_data){
				
			$data = array();
			$format = array();
			foreach($_data as $key => $value){	
                if($key == "title" || $key == "address"){
                    $value = str_replace("@@@",'&quot;',$value);
                }             
				$data[$key] = sanitize_text_field(esc_html(stripslashes($value)));
				$format[] = $data_types[$key];
			}

			//rewrite map id
			$data["map_id"] = $this->map;
			if($poi == "markers" && strpos($_data->custom_marker_url,"data:image/png;") !== false){
				$filename = 'marker_'.time().'.png';
				$data["custom_marker_url"] = GMWD_URL.'/images/markers/custom/customcreated/'.$filename;
			}
			
			if( $_data->id == "" || $this->task == "save2copy" ){		
				//$data["published"] = 1;			
				$data["id"] = "";			
				$wpdb->insert( $wpdb->prefix . "gmwd_".$poi, $data, $format );			   			
			}
			else{
				//$data["published"] = esc_html($_data->published);
				$where = array("id"=>$_data->id);
				$where_format = array('%d');
				$wpdb->update( $wpdb->prefix . "gmwd_".$poi, $data, $where, $format, $where_format );
			}
							
			if($poi == "markers" && strpos($_data->custom_marker_url,"data:image/png;") !== false){
				$uri =  substr($_data->custom_marker_url, strpos($_data->custom_marker_url,",")+1);			
				file_put_contents(GMWD_DIR.'/images/markers/custom/customcreated/'.$filename,  base64_decode($uri));
			}
			
		}
	
	}	
	
	private function store_shortcode(){
        global $wpdb;
        $data = array();
        $data["tag_text"] = 'id='.$this->shortcode_id.' map='.$this->map;
        $format = array('%s');
        $wpdb->insert( $wpdb->prefix . "gmwd_shortcodes", $data, $format );
    
    }
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}