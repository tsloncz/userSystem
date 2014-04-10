<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            echo "<h3>Add User Page</h3>";
            echo "Enter loginId: <input type='text'></input><br>";
            echo "Enter password: <input type='text'></input><br>";
            echo "Enter first name: <input type='text'></input><br>";
            echo "Enter last name: <input type='text'></input><br>";
            echo "Is administrator: <input type='radio' name='yes'>Yes "
            . " <input type='radio' name='no'>No<br>";
            echo "<select>
                    <option value='add'>View user's information</option>
                    <option value='resetPass'>Reset password</option>
                    <option value='deleteUser'>Delete User</option>
                    <option value='addUser'>Add User</option>
                    <option value='updateUser'>Update User Information</option> 
                </select> ";
            echo " <input type='submit'></input>";
        ?>
    </body>
</html>
