<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="post" action="send.php">
  <label for="name">ФИО:</label>
  <input type="text" id="name" name="name" required><br>

  <label for="phone1">Телефон 1:</label>
  <input type="tel" id="phone1" name="phone1" required><br>

  <label for="phone2">Телефон 2:</label>
  <input type="tel" id="phone2" name="phone2" required><br>

  <label for="email1">Email 1:</label>
  <input type="email" id="email1" name="email1" required><br>

  <label for="email2">Email 2:</label>
  <input type="email" id="email2" name="email2" required><br>


  <label for="email2">Email To:</label>
  <input type="email" id="emailTo" name="emailTo" required><br>

  <label for="message">Message:</label>
  <textarea name="message" id="message" cols="30" rows="10"></textarea> <br>



  <button type="submit">Send</button>
</form>
</body>
</html>