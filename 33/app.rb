require 'sinatra'

get '/' do
  <<-HTML
  <html>
    <head><title>Reverse Name</title></head>
    <body>
      <h2>Enter Your Name</h2>
      <form action="/reverse" method="post">
        First Name: <input type="text" name="first"><br><br>
        Last Name: <input type="text" name="last"><br><br>
        <input type="submit" value="Submit">
      </form>
    </body>
  </html>
  HTML
end

post '/reverse' do
  first = params[:first]
  last = params[:last]
  "<h2>Reversed Name:</h2><p>#{last} #{first}</p>"
end
