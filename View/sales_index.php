<?php
include("../Model/query.php");
include("../Model/db_connection.php");

$products = makeQuerry("SELECT * FROM Customers", $db);

include('index.php');

for ($i=0; $i<count($products); $i++):

?>
<div>
<table>

            <tr>

                <td><?php echo $products[$i][0]?></td>
                <td><?php echo $products[$i][1]?></td>
                <td>
                    <a href="customersUpdate.php?cid=<?php echo $customers[$i][0]; ?>">Update</a>
                    <a href="customersDelete.php?cid=<?php echo $customers[$i][0]; ?>">Delete</a>
                </td>

            </tr>

            <?php endfor;?>

        </table>

    </div>

