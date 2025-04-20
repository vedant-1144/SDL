require 'net/smtp'

# Configuration - update these with your SMTP server details and credentials
SMTP_SERVER = 'smtp.example.com'
SMTP_PORT = 587
SMTP_DOMAIN = 'example.com'
SMTP_USER = 'your_email@example.com'
SMTP_PASSWORD = 'your_password'

FROM_EMAIL = SMTP_USER
TO_EMAIL = 'recipient@example.com'  # Change to the recipient's email address

SUBJECT = 'Test Email from Ruby Script'
BODY = <<~EOF
  Hello,

  This is a test email sent from a Ruby script using net/smtp.

  Regards,
  Your Ruby Script
EOF

message = <<~MESSAGE_END
  From: Ruby Script <#{FROM_EMAIL}>
  To: User <#{TO_EMAIL}>
  Subject: #{SUBJECT}

  #{BODY}
MESSAGE_END

begin
  Net::SMTP.start(SMTP_SERVER, SMTP_PORT, SMTP_DOMAIN, SMTP_USER, SMTP_PASSWORD, :plain) do |smtp|
    smtp.send_message message, FROM_EMAIL, TO_EMAIL
  end
  puts "Email sent successfully to #{TO_EMAIL}"
rescue StandardError => e
  puts "Failed to send email: #{e.message}"
end
