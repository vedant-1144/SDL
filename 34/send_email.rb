require 'net/smtp'

# Configuration
SMTP_SERVER = 'smtp.gmail.com'
SMTP_PORT = 587
SMTP_DOMAIN = 'gmail.com'
SMTP_USER = 'extracc0365@gmail.com'
SMTP_PASSWORD = 'wwwgeflkgtyflyjq'

FROM_EMAIL = SMTP_USER
TO_EMAIL = 'example@gmail.com'

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
  smtp = Net::SMTP.new(SMTP_SERVER, SMTP_PORT)
  smtp.enable_starttls # <- This line is essential for STARTTLS
  smtp.start(SMTP_DOMAIN, SMTP_USER, SMTP_PASSWORD, :plain) do |smtp|
    smtp.send_message message, FROM_EMAIL, TO_EMAIL
  end
  puts "Email sent successfully to #{TO_EMAIL}"
rescue StandardError => e
  puts "Failed to send email: #{e.message}"
end
