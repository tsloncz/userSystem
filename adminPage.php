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
        <h3>Administrator Page</h3>
        Password and Administrator only required for update and add.<br>
        <form method='post' action='admin.php'>
          User id: <input type='text' name='loginId'></input><br>
          Password: <input type='text' name='password'></input><br>
          Administrator: <select name='isAdmin'>
                          <option value='yes'>Yes</option>
                          <option value='no'>No</option>
                        </select>
          <br>
          <select name='method'>
            <option value='viewInfo'>View user's information</option>
            <option value='resetPass'>Reset password</option>
            <option value='deleteUser'>Delete User</option>
            <option value='addUser'>Add User</option>
            <option value='updateUser'>Update User Information</option> 
          </select> 
          <input type='submit'></input>
        </form>
      </body>
</html>
