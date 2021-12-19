<style>
ol.sortable,ol.sortable ol {
    list-style-type: none; margin-bottom: 10px; 
}

.sortable li div {
    border: 1px solid #d4d4d4;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    cursor: move;
    border-color: #D4D4D4 #D4D4D4 #BCBCBC;
    margin-bottom: 3px;
    padding: 3px;
}
.menuDiv {
    background: #EBEBEB;
}
.right{ float: right; }
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/darkness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery.mjs.nestedSortable.js"></script>
<div class="maincontentarea">
    <div class="pageconent">
        <h1>Employe Ordering</h1> <?php

        $userid =  $this->session->userdata('id');
        $queryceo = $this->db->query("SELECT * FROM user_master WHERE CEO = 1 AND company = ".$userid);
        $ceo = $queryceo->row();
        if($ceo){ ?>
            <ol class="sortable ceouser"><li><div class="menuDiv"><b><?=$ceo->first_name.' '.$ceo->last_name;?></b><br><span><?=$ceo->designation;?></span></div></li></ol><?php
        } ?>

        <div class="otheremployee"><?php

            
            $username =  get_userinfo($userid, 'user_name', 'id');
            $username = $username['user_name'];   
            
            $querycnt = $this->db->query("SELECT id FROM user_master WHERE company = ".$userid);
            $cnt = $querycnt->num_rows();

            $query1 = $this->db->query("SELECT um.id, um.first_name, um.last_name FROM user_master as um 
                                                JOIN employee_short as es ON um.id = es.item_id 
                                               WHERE um.status = 1 AND um.ceo != 1 AND um.company = ".$userid." AND es.parent_id = 0 
                                            ORDER BY es.id ASC");
            if($query1->num_rows()){
                category_tree(0);
            }else{
                $query = $this->db->query("SELECT um.id, um.first_name, um.last_name, um.designation FROM user_master as um 
                                               LEFT JOIN employee_short as es ON um.id = es.item_id 
                                                   WHERE um.status = 1 AND um.ceo != 1 AND um.company = ".$userid." ORDER BY es.id ASC"); ?>
                <ol class="sortable movesortble"><?php
                    if($query->num_rows()){ $i = 1;
                        foreach ($query->result() as $res) { ?>
                            <li id="menuItem_<?=$res->id;?>" data-id="<?=$res->id;?>"><div class="menuDiv"><b><?=$res->first_name.' '.$res->last_name;?></b> <br /><span><?=$res->designation;?></span></div></li><?php
                            $i++;
                        }
                    } ?>
                </ol><?php
            } ?>
        </div><?php

        if($cnt){ ?>
            <div class="right">
                <input class="addbtn adduser" style="border: 0px;cursor: pointer;" id="toArray" name="toArray" type="submit" value="View Org Chart">
            </div><?php
        } ?>
    </div>
</div>
<script>
    $().ready(function(){
        var ns = $('ol.movesortble').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 5,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false,
            change: function(){
                console.log('Relocated item');
            }
        });

        $('#toArray').click(function(e){
            arraied = $('ol.movesortble').nestedSortable('toArray', {startDepthCount: 0});
            arraieddmp = dump(arraied); 
            /*(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
            $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;*/
            
            /*if(arraieddmp == <?=$cnt;?>){
                $('#response').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> Please select CEO. </div>');
            }else{ */
                $.ajax({
                    type: "POST",
                    url: "<?=base_url();?>/employee/save_sorting", 
                    data: {data: arraied},
                    dataType: "text",  
                    cache:false,
                    success: 
                      function(data){
                        //alert(data);  //as a debugging message.

                        window.open(
                          '<?=base_url();?><?=$username;?>',
                          '_blank' // <- This is what makes it open in a new window.
                        );
                      }
                });
            //}
        });
    });         

    function dump(arr,level) {
        var dumped_text = "";
        if(!level) level = 0;

        //The padding given at the beginning of the line.
        var level_padding = "";
        for(var j=0;j<level+1;j++) level_padding += "    ";
        var z = 0;
        if(typeof(arr) == 'object') { //Array/Hashes/Objects
            for(var item in arr) {
                var value = arr[item];

                if(typeof(value) == 'object') { //If it is an array,
                    dumped_text += level_padding + "'" + item + "' ...\n";
                    dumped_text += dump(value,level+1);
                } else {
                    dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                }
                if (value != null){ 
                    if(typeof value.depth  !== "undefined") z += value.depth; 
                }
            }
        } else { //Strings/Chars/Numbers etc.
            dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
        }
        return z;
    }
</script>