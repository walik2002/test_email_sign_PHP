<?php
class Signature {
  private $name;
  private $phone1;
  private $phone2;
  private $email1;
  private $email2;
  private $color;

  public function __construct($name, $phone1, $phone2, $email1, $email2, $color) {
    $this->name = $name;
    $this->phone1 = $phone1;
    $this->phone2 = $phone2;
    $this->email1 = $email1;
    $this->email2 = $email2;
    $this->color = $color;
  }

  public function generate() {
    $signature = "
      <hr>
      <p style='color: $this->color;'><strong>Best regards,</strong></p>
      <p style='color: $this->color;'>$this->name</p>
      <p style='color: $this->color;'>Phone:</p>
      <ul style='color: $this->color;'>
        <li><a href='tel:$this->phone2'>$this->phone1</a></li>
        <li><a href='tel:$this->phone2'>$this->phone1</a></li>
      </ul>
      <p style='color: $this->color;'>Email:</p>
      <ul style='color: $this->color;'>
        <li><a href='mailto:$this->email1'>$this->email1</a></li>
        <li><a href='mailto:$this->email2'>$this->email2</a></li>
      </ul>
    ";

    return $signature;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $phone1 = $_POST['phone1'];
  $phone2 = $_POST['phone2'];
  $email1 = $_POST['email1'];
  $email2 = $_POST['email2'];
  $to = $_POST['emailTo'];
  $message = $_POST['message'];

  // Create first signature object
  $signature1 = new Signature($name, $phone1, $phone2, $email1, $email2, 'red');

  // Create second signature object
  $signature2 = new Signature($name, $phone1, $phone2, $email1, $email2, 'green');

  // Compose email message with signatures
  $subject = 'Example Email';
  $headers = array(
    'From: sender@example.com',
    'Content-Type: text/html; charset=UTF-8',
  );
  $message = '<p>'.$message.'</p>';
  $message .= $signature1->generate() . $signature2->generate();

  // Send email with signatures
  $sent = mail($to, $subject, $message, implode("\r\n", $headers));

  // Check if email was sent successfully
  if ($sent) {
    echo 'Email sent successfully.';
  } else {
    echo 'Error sending email.';
  }
}
?>
