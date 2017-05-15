<?php

class GMWDModel {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	protected $per_page = 10;


	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	public function __construct() {
		$user = get_current_user_id();
		$screen = get_current_screen();
		if($screen){
			$option = $screen->get_option('per_page', 'option');
			
			$this->per_page = get_user_meta($user, $option, true);
			
			if ( empty ( $this->per_page) || $this->per_page < 1 ) {
			  $this->per_page = $screen->get_option( 'per_page', 'default' );

			}
		}
		
	}   
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function per_page(){
		return $this->per_page;

	}
	
	public function get_row_by_id($id , $table_name = ""){
		global $wpdb;
		if($table_name == ""){
			$page = GMWDHelper::get('page') ? GMWDHelper::get('page') : "maps_gmwd";
			$page = explode("_",$page);
			$table_name =  "gmwd_".$page[0];		
			
		}

		if($id){
			$query = "SELECT * FROM ". $wpdb->prefix . $table_name ." WHERE id='%d'";			
			$row = $wpdb->get_row($wpdb->prepare($query, $id));
		}
		else{					
			$columns = self::get_columns($table_name);			
			$row = new stdClass();
			foreach($columns as $column){
				$row->$column = "";
			}
		}

		return $row;
	}
	
	public static function get_columns($table_name){
		global $wpdb;
		$query = "SHOW COLUMNS  FROM " . $wpdb->prefix . $table_name ;			
		$columns = $wpdb->get_col( $query , 0 );
		return 	$columns;	
	}

	public static function column_types($table_name){
		global $wpdb;		
		$query = "SHOW COLUMNS  FROM " . $wpdb->prefix . $table_name ;					
		$columns_data_types = $wpdb->get_results( $query );

	
		$data_types = array();
		foreach($columns_data_types as  $column){
            if(strpos($column->Type, "int") !== false || strpos($column->Type, "tinyint") !== false){
                $data_types[$column->Field] = '%d';
            }
            else if(strpos($column->Type, "varchar") !== false || strpos($column->Type, "text") !== false || strpos($column->Type, "longtext") !== false || strpos($column->Type, "date") !== false || strpos($column->Type, "datetime") !== false){
                $data_types[$column->Field] = '%s';
            }            

		}
			
		return 	$data_types;		
	
	}
	


	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}