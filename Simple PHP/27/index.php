<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Books Catalog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .book {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .book h2 {
            margin: 0 0 10px 0;
        }
        .book p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Books Catalog</h1>
    <div id="books-container">
        Loading books...
    </div>

    <script>
        async function loadBooks() {
            const container = document.getElementById('books-container');
            try {
                const response = await fetch('get_books.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const books = await response.json();
                if (books.length === 0) {
                    container.innerHTML = '<p>No books found.</p>';
                    return;
                }
                container.innerHTML = '';
                books.forEach(book => {
                    const bookDiv = document.createElement('div');
                    bookDiv.className = 'book';
                    bookDiv.innerHTML = `
                        <h2>${book.title}</h2>
                        <p><strong>Author:</strong> ${book.author}</p>
                        <p><strong>Published Year:</strong> ${book.published_year || 'N/A'}</p>
                        <p>${book.description || ''}</p>
                    `;
                    container.appendChild(bookDiv);
                });
            } catch (error) {
                container.innerHTML = '<p>Error loading books.</p>';
                console.error('Error fetching books:', error);
            }
        }

        window.onload = loadBooks;
    </script>
</body>
</html>
