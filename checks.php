<html>
    <head>
        <style>
            #scores {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #scores td, #scores th {
                border: 0px solid #ddd;
                padding: 6px;
            }

            #scores tr:nth-child(even){
                background-color: #f2f2f2;
            }

            #scores tr:hover {
                background-color: #ddd;
            }

            #scores th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #04AA6D;
                color: white;
        </style>
    </head>
    <body>
    
    <?php
    
require_once("conf/database.php");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn,"SELECT url_id, score FROM scores WHERE url_id IN (SELECT DISTINCT url_id FROM urls WHERE status = 1) ORDER BY id DESC LIMIT 12;");

echo '<table id="scores" border="1"><tr><th width="50%">url</th><th width="50%">last score</th></tr>';

while($row = mysqli_fetch_array($result))
{
    $url_id = $row['url_id'];
    $url_score = $row['score'];
    $result2 = mysqli_query($conn,"SELECT url FROM urls WHERE id = '".$url_id."' ;");
    $row2 = $result2->fetch_row();
    $value = $row2[0] ?? false;

    echo "<tr>";
    echo "<td>" . $value . "</td>";
    echo "<td>" . $url_score . "</td>";
    echo "</tr>";

}
echo "</table>";

mysqli_close($conn);
?>


    </body>
</html>


