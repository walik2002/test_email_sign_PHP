<?php
class Signature {
  public function __construct(
    private string $name,
    private string $phone1,
    private string $phone2,
    private string $email1,
    private string $email2,
    private string $color
  ) {}

  function formatPhoneNumber(string $phone): string {
    $digits = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric characters
    $digits = substr($digits, -9); // Extract last 9 digits
  
    $formatted = '+375 ';
    $formatted .= substr($digits, 0, 2) . ' '; // Add first two digits with a space
    $formatted .= substr($digits, 2, 3) . '-'; // Add next three digits with a dash
    $formatted .= substr($digits, 5, 2) . '-'; // Add next two digits with a dash
    $formatted .= substr($digits, 7); // Add last two digits
  
    return $formatted;
  }

  public function generate(): string {
    $phone1Formatted = $this->formatPhoneNumber($this->phone1);
    $phone2Formatted = $this->formatPhoneNumber($this->phone2);

    $signature = "
      <hr>
      <p style='color: $this->color;'><strong>С уважением,</strong></p>
      <p style='color: $this->color;'>$this->name</p>
      <p style='color: $this->color;'>Телефон:</p>
      <ul style='color: $this->color;'>
        <li><a href='tel:$phone1Formatted'>$phone1Formatted</a></li>
        <li><a href='tel:$phone2Formatted'>$phone2Formatted</a></li>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $phone1 = $_POST['phone1'] ?? '';
  $phone2 = $_POST['phone2'] ?? '';
  $email1 = $_POST['email1'] ?? '';
  $email2 = $_POST['email2'] ?? '';
  $to = $_POST['emailTo'] ?? '';
  $message = $_POST['message'] ?? '';


  
  if (!is_string($name)) {
    throw new InvalidArgumentException('Name must be a string.');
  }
  if (!is_string($phone1) || !is_string($phone2)) {
    throw new InvalidArgumentException('Phone numbers must be strings.');
  }
  if (!is_numeric(preg_replace('/[^0-9]/', '', $phone1)) || !is_numeric(preg_replace('/[^0-9]/', '', $phone2))) {
    throw new InvalidArgumentException('Phone numbers must contain only digits.');
  }
  if (!is_string($email1) || !is_string($email2)) {
    throw new InvalidArgumentException('Email addresses must be strings.');
  }

  // Validate email addresses
  if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
    throw new InvalidArgumentException('Invalid email address: ' . $email1);
  }
  if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
    throw new InvalidArgumentException('Invalid email address: ' . $email2);
  }
  if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
    throw new InvalidArgumentException('Invalid email address: ' . $to);
  }
  // Create first signature object
  $signature1 = new Signature($name, $phone1, $phone2, $email1, $email2, 'red');

  // Create second signature object
  $signature2 = new Signature($name, $phone1, $phone2, $email1, $email2, 'green');

  // Compose email message with signatures
  $subject = 'Example Email';
  $headers = [
    'From: sender@example.com',
    'Content-Type: text/html; charset=UTF-8',
  ];
  $message = '<p>' . htmlspecialchars($message) . '</p>'; // Escape HTML characters in message
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
