const container = document.querySelector('.container');
const url = 'http://localhost:3000/technieken';
// data fetchen
fetch(url)
  .then(response => response.json())
  .then(data => {
    // een loop om in card te kunnen zien 
    data.forEach(item => {
      const cardHTML = `
        <div class="card">
      
          <img src="${item.image}" alt="${item.name}">
          <h2>${item.name} hi </h2>
          <p>${item.description}</p>
        </div>
      `;
      container.innerHTML += cardHTML;

    });
  })



//   <!DOCTYPE html>
// <html lang="en">

// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <link rel="stylesheet" href="css/style.css">
//     <title>JS Toets periode 3</title>
// </head>

// <body>

//     <main class="main">
//         <h1>Toets JavaScript periode 3</h1>
//         <div class="container">
            
//         </div>
//     </main>
// </body>
// <script src="js/main.js"></script>

// </html>