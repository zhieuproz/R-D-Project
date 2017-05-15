<?php

class GMWDController {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	public $page;
	public $task;
	public $model;
	public $view;

	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	public function __construct() {

		$page = GMWDHelper::get('page') ? GMWDHelper::get('page') : "maps_gmwd";
		
		$this->page = $page;

		$task = GMWDHelper::get('task') ? GMWDHelper::get('task') : "display";
		$this->task = $task; 

		$model_class = 'GMWDModel' . ucfirst($this->page);
		$view_class = 'GMWDView' . ucfirst($this->page);

		require_once GMWD_DIR . "/admin/models/".$model_class.".php";
		$this->model = new $model_class();

		require_once GMWD_DIR . "/admin/views/".$view_class.".php";
		$this->view = new $view_class($this->model);

	}

	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function execute() {
    
		$task = $this->task; 
        if(method_exists($this, $task)){
            if($task != "display" && $task != "edit" && $task != "select_icon"){                          
                check_admin_referer('nonce_gmwd', 'nonce_gmwd');
            }   
            $this->$task();
        }
        else{
            _e("Not found","bwg_back");
        }
    }
    public function save_api_key(){
        global $wpdb;
        $data = array();
        $data["value"] = esc_html(GMWDHelper::get("gmwd_api_key_general"));
        $where = array("name"=>"map_api_key");
        $where_format = $format = array('%s');
        $wpdb->update( $wpdb->prefix . "gmwd_options", $data, $where, $format, $where_format );
        GMWDHelper::gmwd_redirect("admin.php?page=".GMWDHelper::get("page"));
    
    } 
	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	protected function display() {
		$view = $this->view;
		$view->display();	
	}

	protected function edit(){
		$view = $this->view;
		$id = (int)GMWDHelper::get('id'); 
		$view->edit($id); 
	}
	protected function explore(){
		$view = $this->view;
		$view->explore(); 
	}	

	protected function save(){
		
	}
	
	protected function apply(){

	}
	

	protected function remove($table_name = ""){
		global $wpdb;
		$ids = isset($_POST["ids"]) ? $_POST["ids"] :(isset($_POST["id"]) ? array($_POST["id"]) :  array());
		if($table_name == ""){
			$page = $this->page ? $this->page : "maps_gmwd";
			$page = explode("_",$page);
			$table_name = $wpdb->prefix . "gmwd_".$page[0];		
			
		}
   
		if(empty($ids) === false){

			foreach($ids as $id){	
				$where = array("id" => (int)$id);
				$where_format = array('%d');
				$wpdb->delete(  $table_name, $where, $where_format);
			}
			GMWDHelper::message(__("Item(s) Succesfully Removed.","gmwd"),'updated');			
		}
		else{
			GMWDHelper::message(__("You must select at least one item.","gmwd"),'error');
		}
        if(GMWDHelper::get("ajax") != 1){
            $this->display();
        }		

	}
	
	
	protected function cancel(){
		GMWDHelper::gmwd_redirect("admin.php?page=".$this->page);		
	}
	
	protected function publish($table_name = ""){
		global $wpdb;
		if(isset($_POST["ids"])){
			$ids = $_POST["ids"] ;			
		}
		elseif(isset($_POST["current_id"])){
			$ids = array($_POST["current_id"]) ;
		}
		else{
			$ids = array();
		}
		if(empty($ids) === false && isset($_POST["publish_unpublish"])){
			$data = array("published" => (int)$_POST["publish_unpublish"]);
			$where_format = array('%d');
			$format = array('%d');
									

			if($table_name == ""){
				$page = $this->page ? $this->page : "maps_gmwd";
				$page = explode("_",$page);
				$table_name = $wpdb->prefix . "gmwd_".$page[0];		
				
			}
			
			foreach ($ids as $id){
				$where = array("id"=>(int)$id);			
				$wpdb->update($table_name, $data, $where, $format, $where_format );
				
			}
		}
        if(GMWDHelper::get("ajax") != 1){
            $publish_unpublish = $_POST["publish_unpublish"] == 1 ? __("Published","gmwd") : __("Unpublished","gmwd");
            GMWDHelper::message(__("Item(s) Succesfully ","gmwd").$publish_unpublish.".",'updated');
            $this->display();
        }		
	}
    

    protected function dublicate($table_name_widthout_prefix = ""){
        global $wpdb;
		if(isset($_POST["ids"])){
			$ids = $_POST["ids"] ;			
		}
       
        if($table_name_widthout_prefix == ""){
			$page = explode("_",$this->page);
			$table_name_widthout_prefix =  "gmwd_".$page[0];												
		}
         
        $table_name = $wpdb->prefix . $table_name_widthout_prefix;	
        $columns = GMWDModel::get_columns($table_name_widthout_prefix);
		$column_types = GMWDModel::column_types($table_name_widthout_prefix);
        if(empty($ids) === false){
            foreach($ids as $id){
                $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE id = '%d'", $id ));
                $data = array();
                $format = array();
                foreach($columns as $column_name){
                    $data[$column_name] = esc_html(stripslashes($row->$column_name));
                    $format[] = $column_types[$column_name];		
                }
                $data["id"] = "";
                switch($this->page){
                    case "themes_gmwd":
                       $data["default"] = 0; 
                       break; 
                }
                
                $wpdb->insert( $table_name, $data, $format );
                
            }
        }
        $view = $this->view;
        GMWDHelper::message(__("Item Succesfully Duplicated.","gmwd"),'updated');
		$view->display(); 
    
    }


	
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}