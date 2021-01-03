<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fist of all load a lib and paass two peramitar plz keep in mind dont change a peramitar ,
 * after a loading a lib confge a email credential  in application/config/email.php ,
 * if u want to attch a somthig to email just add a key 'attach' in data array or simply u can call
 * setAttachment() method and pass array or sling to file path...
 */

class Custome_email {
    protected $CI;
    protected $to;
    protected $from;

    public $skip;
    public $emailKey;
    public $emailBody ; // Define a email body
    public $subject ; // Define a email body\

    public function __construct(array $param=NULL)
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('email',$this->CI->config->load('email', TRUE));
        $this->to = (isset($param['to'])) ? $param['to'] : '';
        $this->from = (isset($param['from']))  ? $param['from'] : '';
    }

    public function sendEmail()
    {
         $this->CI->email->set_newline("\r\n");
         $this->CI->email->from($this->from,$this->subject);
         $this->CI->email->to($this->to);
         $this->CI->email->subject($this->subject);
         $this->CI->email->message($this->emailBody);
         if ($this->CI->email->send()) {
            return TRUE;
			$this->CI->email->clear(TRUE);
         }else {
            show_error( $this->CI->email->print_debugger());
         }
    }

   /**
    * set a email templet form datavase and set an email body
    * @return this
   **/
   public function setMessag($messageId)
   {
        $email =  $this->CI->db->get_where('email_template',["id" => $messageId ,'is_active' => 1 ])->row()->email_template_description;
        $this->emailBody = $email;
        $this->getEmailkey();
        return $this;
   }

   protected function getEmailkey()
   {
        preg_match_all("/%.*?%/",$this->emailBody, $matches);
        $this->emailKey = array_values(array_unique($matches[0]));
        return $this;
   }

   public function composeEmail($data)
   {
         foreach($data as $key => $value)
         {
            $_key = '%'.$key.'%';
            if ($key == 'attach')
            {
               $this->setAttachment($value);
            }
            if (in_array($_key,$this->emailKey))
            {
               if(!empty($this->skip) && array_key_exists($key,$this->skip) && $value=="") /* if set a skip than remove */
               {
                  $this->emailBody = preg_replace('~<'.$key.'>(.*?)</'.$key.'>~is', '', $this->emailBody); // replase tag
               }else{
                  $this->emailBody = str_replace($_key,$value,$this->emailBody) ;
               }
               $this->emailBody  = $this->strip_single_tag($this->emailBody,$key); // Remove tag
            }
        }
      return $this;
   }
   /**
    * @param type var subject  Set a email subkect;
    * @return return $this
    */
   public function setSubject($subject)
   {
      $this->subject = $subject;
      return $this;
   }

   /**
    * set setAttachment in a email
    * allowed only array or sting
    * @return return this
    */
   public function setAttachment($attachment)
   {
      if (is_array($attachment)) {
         foreach ($attachment as $key => $value) {
            $this->CI->email->attach($value);
         }
      }else {
         $this->CI->email->attach($attachment);
      }
      return $this;
   }

   public function setFrom($value)
   {
      $this->from = $value;
      return $this;
   }

   public function setTo($value)
   {
      $this->to = $value;
      return $this;
   }

   public function setSkip($key)
   {
        $this->skip[$key] = $key ;
        return $this;
   }

   public function strip_single_tag($string, $tag){
      $string = preg_replace('/<'.$tag.'(\s*|\s(.|\s)[^>]*)>/i', "", $string);
   	$string = preg_replace('/<\s*\/\s*'.$tag.'(\s*|\s(.|\s)[^>]*)>/i', "", $string);
   	return $string;
   }
    // public function __get($name){
    //     return $this->$name;
    // }

    // public function __set($name, $value){
    //     $this->$name = $value;
    // }
}

/* End of file Custome_email.php */
/* Location: ./application/controllers/Custome_email.php */
