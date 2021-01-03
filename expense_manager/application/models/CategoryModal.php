<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function categories($user_id)
    {
        $this->db->select(array(COL_ID, COL_CAT_NAME, COL_CAT_DESCRIPTION, COL_IMG_URL));
        $result_categories = $this->db->get(TBL_CATEGORY);
        $category_list = $result_categories->result_array();
        
        $new_category_list = array();

        $user_category_list = $this->user_category($user_id);

        if (!empty($user_category_list)) {
            foreach ($user_category_list as $user_category) {
                foreach ($category_list as $key => $value) {
                    // $category = $category_list[$i];
                    if(strcmp($user_category[COL_CAT_ID], $value[COL_ID])==0){
                        $value["is_selected"] = 1;
                        array_push($new_category_list, $value);
                        unset($category_list[$key]);
                    }
                }
            }
        }

        array_values($category_list);

        foreach($category_list as $category){
            // foreach ($new_category_list as $new_category) {
                // if(strcmp($new_category[COL_ID], $category[COL_ID])!==0){
                    $category["is_selected"] = 0;
                    array_push($new_category_list, $category);
                // }
            // }
        }
        // echo "newCategoryList";
        // print_r($new_category_list);
        // echo "categoryList";
        // print_r($category_list);
        return $new_category_list;
    }

    function add_user_category($post_data)
    {
        $user_id = $post_data[COL_USER_ID];
        $categories = $post_data["categories"];

        $user_categories = $this->user_category($user_id);

        foreach ($user_categories as $user_cat_key => $user_cat_value) {
            foreach($categories as $cat_key => $cat_value){
                if(strcmp($user_cat_value[COL_CAT_ID], $cat_value[COL_CAT_ID])==0){
                    unset($categories[$cat_key]);
                    unset($user_categories[$user_cat_key]);
                }
            }
        }
        
        foreach ($categories as $key => $value) {
            $cat_id = $value[COL_CAT_ID];
            $remaining_limit = $value[COL_REMAINING_LIMIT];
            $monthly_limit = $value[COL_MONTHLY_LIMIT];

            $data = array(COL_USER_ID => $user_id, 
            COL_CAT_ID => $cat_id, 
            COL_REMAINING_LIMIT => $remaining_limit, 
            COL_MONTHLY_LIMIT => $monthly_limit);

            $this->db->insert(TBL_USER_CATEGORY, $data);
        }

        foreach ($user_categories as $key => $value) {
            $this->db->where(COL_CAT_ID, $value[COL_CAT_ID]);
            $this->db->delete(TBL_USER_CATEGORY);
        }
        return $this->get_user_category_data($user_id);
    }

    function get_user_category_data($user_id)
    {
        $user_categories = $this->user_category($user_id);

        $user_categories_data = array();

        foreach($user_categories  as $user_category) {
            $user_category_array = array();

            $user_category_array[COL_ID] = $user_category[COL_ID];
            $user_category_array[COL_USER_ID] = $user_category[COL_USER_ID];
            $user_category_array[COL_CAT_ID] = $user_category[COL_CAT_ID];
            $user_category_array[COL_REMAINING_LIMIT] = $user_category[COL_REMAINING_LIMIT];
            $user_category_array[COL_MONTHLY_LIMIT] = $user_category[COL_MONTHLY_LIMIT];

            $this->db->where(COL_ID, $user_category[COL_CAT_ID]);
            $result_category = $this->db->get(TBL_CATEGORY);
            $categories = $result_category->result_array();
            
            $user_category_array[COL_CAT_NAME] = $categories[0][COL_CAT_NAME];
            $user_category_array[COL_CAT_DESCRIPTION] = $categories[0][COL_CAT_DESCRIPTION];
            $user_category_array[COL_IMG_URL] = $categories[0][COL_IMG_URL];

            array_push($user_categories_data, $user_category_array);
        }

        return $user_categories_data; 
    }

    function user_category($user_id) {
        $this->db->where(COL_USER_ID, $user_id);
        $result_user_categories = $this->db->get(TBL_USER_CATEGORY);
        return $result_user_categories->result_array();
    }

    function delete_user_category($user_id) {
        $this->db->where(COL_USER_ID, $user_id);
        return $this->db->delete(TBL_USER_CATEGORY);
    }

}

/* End of file Application_model.php */

