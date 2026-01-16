<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");

    ?>
    <table class="table">
        <tr>
            <td>№</td>
            <td>ID</td>
            <td>Name</td>
            <td>Surname</td>
            <td>tel</td>
            <td>email</td>
            <td>rd</td>
            <td>address</td>
        </tr>
        <?
                $count =1;
                $sql = "SELECT *FROM customer";
                $result = mysqli_query($conn,$sql);
    
                while ($data = mysqli_fetch_array($result))
                {
                    ?>
                    <tr>
                        <td><?=$count++;?></td>
                        <td><?=$data["customer_id"];?></td>
                        <td><?=$data["name"];?></td>
                        <td><?=$data["surname"];?></td>
                        <td><?=$data["tel"];?></td>
                        <td><?=$data["email"];?></td>
                        <td><?=$data["rd"];?></td>
                        <td><?=$data["address"];?></td>
                    </tr>
                    <?
                }
    
        ?>

    </table>
    

</body>
</html>    