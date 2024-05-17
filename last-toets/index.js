import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import dotenv from 'dotenv';
import { MongoClient, ServerApiVersion } from 'mongodb';

dotenv.config();
const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static('public'));

const databaseUrl = process.env.CONNECTION_URL;
const client = new MongoClient(databaseUrl, {
  serverApi: {
    version: ServerApiVersion.v1,
    strict: true,
    deprecationErrors: true,
  },
});

async function fetchCheeses() {
  try {
    await client.connect();
    const database = client.db("test");
    const collection = database.collection('cheese');
    const cheeses = await collection.find().toArray();
    return cheeses;
  } finally {
    await client.close();
  }
}

app.get('/cheeses', (req, res) => {
  fetchCheeses().then(cheeses => {
    res.json(cheeses);
  }).catch(error => {
    res.status(500).json({ error: 'Internal Server Error' });
  });
});



async function insertDocument(email, password) {
    try {
        // we verbinden de client met de server
        await client.connect();
        //hier verbinden we met de database, je moet nog wel een naam invullen
        const database = client.db('dashboard');
        //hier verbinden we met de collectie, je moet nog wel een naam invullen
        const collection = database.collection('users');

        //het document wordt opgeslagen met insertOne
        await collection.insertOne({
            email: email,
            password: password
        });
    } finally {
        //we zorgen ervoor dat aan het einde de database verbinding weer wordt gesloten
        await client.close();
    }
}
         
app.post('/add-user', (req, res) => {
    //de email en het password worden uit de body gelezen (let op dat je body-parser gebruikt)
    const email = req.body.email;
    const password = req.body.password;
    //de insertDocument functie wordt aangeroepen en daarna wordt er een JSON object naar de browser gestuurd met success: true
    insertDocument(email, password).then(res.send({ success: true }));
});
                
        

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
