<? if ($this->uri->segment(3)) $transport_id=$this->uri->segment(3); else $transport_id=0; ?>

<style>
#table td{padding:3px 1px 3px 0px;}
th,td  { max-width:150px !important; overflow:auto;}
</style>
<?
if ($transport_id>0)
{
    $count =0;
    echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Track</div>';
        echo '<div class="panel-body">';
            echo "<table class='table table-hover small' id='table'>";
            echo "<tr>";
                echo "<th></th>"; 
                echo "<th>Зураг</th>"; 
                echo "<th>Бүртгэсэн</th>"; 
                echo "<th>Трак</th>"; 
                echo "<th>Тайлбар</th>"; 
            echo "</tr>";
            $query = $this->db->query("SELECT * FROM branch_inventories WHERE transport='$transport_id'");

            foreach ($query->result() as $row)
            { 
                echo "<tr>";
                    echo "<td>".++$count."</td>"; 
                    echo "<td><img src='../".$row->image."' class='w-100'></td>";
                    echo "<td>".$row->created_date."</td>";
                    echo "<td>".$row->track."</td>";
                    echo "<td>".$row->comment."</td>";
                echo "</tr>";

            } 
            echo "</table>";
        echo '</div>';
    echo '</div>';
}
if ($transport_id==0)
{
        $count =1;
        $query = $this->db->query("SELECT * FROM branch_transport ORDER BY id DESC");
        ?>
        <div class="panel">
            <div class="panel-body">
                <table class='table table-hover'>
                    <tr>
                        <th></th>
                        <th>Үүсгэсэн</th>
                        <th>Жолооч</th>
                        <th>Утас</th>
                        <th>Тайлбар</th>
                        <th>Ачааны тоо</th>
                        <th>Жин</th>
                        <th></th>
                    </tr>
    
                    <?
    
                    $count=1;$total_weight=0;$total_price=0;
    
                    foreach ($query->result() as $row)
                        { 
                            $transport_id=$row->id;
                            $driver=$row->driver;
                            $contact=$row->contact;
                            $comment=$row->comment;
                            $items=$row->items;
                            $sum_weight=$row->sum_weight;
                            $created_date=$row->created_date;
                            ?>
                            <tr>
                                <td><?=$count++;?></td> 
                                <td><?=$created_date;?></td> 
                                <td><?=$driver;?></td> 
                                <td><?=$contact;?></td> 
                                <td><?=$comment;?></td> 
                                <td><?=$items;?></td> 
                                <td><?=$sum_weight;?></td> 
                                <td><?=anchor("agents/track_branch/".$transport_id,"дэлгэрэнгүй");?></td> 
                            </tr>
                            <?            
                        }
                    ?>          
                </table>
            </div>
        </div>
        <?
}
            
?>


<script type="text/javascript" src="<?=base_url();?>assets/js/tooltip.js"></script>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>