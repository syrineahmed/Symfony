<?php

$con = mysqli_connect("localhost","root","","projet_pi");
if(!$con){
    echo "Connection Failed".mysqli_connect_error();
if (isset($_POST['input'])){
    $input= $_POST['input'];
    $query= "SELECT * FROM projet_pi WHERE nom_service LIKE '{$input}%'";
    $result=mysqli_query($con,$query);
    if (mysqli_num_rows($result)>0){?>

        <table class="table table-bordered table-striped mt-4">
            <thead>
            <tr>
                <th>Id_Service</th>
                <th>Nom_Service</th>
                <th>Description</th>
                <th>Tarification</th>
                <th>Ref_Service</th>
                <th>Disponibilité</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row=mysqli_fetch_assoc($result)){
                $id=$row['id'];
                $nomcategorie=$row['nom_service'];
                $description=$row['description'];
                $tarification=$row['tarification'];
                $refServices=$row['ref_service'];
                $disponibilite=$row['disponibilite'];
                $date=$row['date_aj'];
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $nomcategorie; ?></td>
                    <td><?php echo $description; ?></td>
                    <td><?php echo $tarification; ?></td>
                    <td><?php echo $refServices; ?></td>
                    <td><?php echo $disponibilite; ?></td>
                    <td><?php echo $date; ?></td>
                </tr>
                <?php

            }
            ?>
            ?>
            </tbody>

        </table>
        <?php
    }else{
        echo "<h6 class='text-danger text0-center mt-3'>No Data Found</h6>";

    }
}
}
?>