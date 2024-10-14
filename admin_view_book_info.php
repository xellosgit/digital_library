<?php
    session_start();
    include "database.php";
    if(!isset($_SESSION["AID"]))
    {
        header("location:admin_login.php");
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Digital library</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css">
        <link rel="icon" type="image/x-icon" href="/upload/favicon.ico">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <img src="upload\book1.png" alt="books">
                <h1>Електронна бібліотека</h1>
            </div>
            <div id="wrapper">    
                <h3 id="heading">Інформація про книгу</h3>
                    <?php
                    $sql="SELECT * FROM BOOK WHERE BID=".$_GET["id"];
                    $res=$db->query($sql);
                    if($res->num_rows>0)
                    {
                        $row=$res->fetch_assoc();
                        echo '<center>';
                        echo "<img src= '{$row["BCOVER"]}' alt='cover' width='40%'>";
                        echo '</center>';
                        echo "<table>";
                        echo "
                            <tr>
                                <th>Назва книги</th>
                                <td>{$row["BTITLE"]}</td>
                            </tr>
                            <tr>
                                <th>Автор книги</th>
                                <td>{$row["AUTHOR"]}</td>
                            </tr>
                            <tr>
                                <th>Мова книги</th>
                                <td>{$row["LANGUAGE"]}</td>
                            </tr>
                            <tr>
                                <th>Кількість сторінок</th>
                                <td>{$row["PAGES"]}</td>
                            </tr>   
                            <tr>
                                <th>Рік видання</th>
                                <td>{$row["YEAR"]}</td>
                            </tr>     
                            <tr>
                                <th>Ключові слова</th>
                                <td>{$row["KEYWORDS"]}</td>
                            </tr>
                            <tr>
                                <th>Опис</th>
                                <td>{$row["DESCRIPTION"]}</td>
                            </tr>  
                        ";
                        echo "</table>";
                        echo '<center>';
                        echo "<br>";
                        echo "<a href='{$row["FILE"]}' target='_blank'><img src='/upload/openBook.png' alt='hone.png'> Переглянути книгу</a>";
                        echo '</center>';
                    }
                    else
                    {
                        echo "<p class='error'>Книг не знайдено</p>";
                    }
                    ?>
                    <p>Коментарі користувачів:</p>
                <?php 
                    $sql="SELECT user.NAME, comment.COMM, comment.LOGS 
                    FROM `comment` 
                    INNER JOIN user 
                    ON comment.UID=user.ID 
                    WHERE comment.BID={$_GET["id"]} 
                    ORDER BY comment.CID DESC";
                    $res=$db->query($sql);
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        {
                            echo "<p><br>
                            <strong>{$row["NAME"]} : </strong>
                                {$row["COMM"]}
                            <i>{$row["LOGS"]}</i>
                            </p>";
                        }
                    }
                    else
                    {
                        echo "<p class='error'>Поки немає коментарів...</p>";
                    }
                ?>
            </div>
            <div id="inbar"> 
                <?php
                    include "admin_sidebar.php";
                ?>
            </div>
            <div id="footer">
                <p>Copyright &copy; Віктор Печорських. 2022. Усі права захищені. </p>
            </div>
        </div>
    </body>
</html>