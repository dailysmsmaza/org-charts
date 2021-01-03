<?

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_function_model extends MY_Model {

    private $_table;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param This is Function is allow only assoc_array() as peramitar ,
     * @param if $multipal = FALSE return a row object
     * @param if result
     * @note Dont change Key keep in mind
     * @return array() row() object
     * @author ajay
     * @use EX :--
     *
     * array('table' => 'Table_name','where' => array("is_active" => 1//Condection array),'limit' => 3,'order_by_' => array('order_field' => 'authentication_banner','order_field_type' => 'DESC'));
     *
     * */
    public function getResult(array $array, $result = TRUE, $multipal = TRUE) {
        if (!is_array($array)) {
            show_error('This method accept only <b>array</b>', "405", '405 Method Not Allowed');
            return FALSE;
        }
        extract($array);
        if (isset($table)) {
            $this->_table = $table;
        }
        if (isset($join_table)) {
            $this->db->join($join_table, $join_on, 'inner');
        }
        if (isset($field)) {
            $this->db->select($field, FALSE);
        }
        if (isset($limit)) {
            $this->db->limit($limit);
        }
        if (isset($order_by)) {
            if (count($array) !== count($array, COUNT_RECURSIVE)) {
                $this->db->order_by($order_by['order_field'], $order_by['order_field_type']);
            } else {
                foreach ($order_by as $key => $order_by_value) {
                    $this->db->order_by($order_by_value['order_field'], $order_by_value['order_field_type']);
                }
            }
        }
        if (isset($where)) {
            $query = $this->db->get_where($this->_table, $where);
        } else {
            $query = $this->db->get($this->_table);
        }
        if ($query->num_rows() > 0) {
            if ($multipal === TRUE) {
                if ($result === TRUE) {
                    return $query->result();
                } else {
                    return $query->result_array();
                }
            } else {
                return $query->row();
            }
        } else {
            return FALSE;
        }
    }

    // this is to get filed value in database
    function CountByTable($table, $where = array()) {
        (!empty($where)) ? $this->db->where($table) : '';
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function total_count_byid($table, $id, $field) {
        $this->db->where($field, $id)->get($table);
        $total_sold = $this->db->count_all_results();
        if ($total_sold > 0) {
            return $total_sold;
        }
        return 0;
    }

    function closetags($html) {
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    function get_inner_banner($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('inner_banner');
        return ($query->num_rows() > 0) ? $query->row() : '';
    }

//    this code Instagram api
    public function fetchImage() {
        $instagram_data = file_get_contents("https://api.instagram.com/v1/users/" . USER_ID . "/media/recent/?access_token=" . ACCESS_TOKEN . "&count=8");

        $x_instagram_data = json_decode($instagram_data);

        return $x_instagram_data;
    }

}

?>