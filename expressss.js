const express = require('express');
const app = express();
const path = require('path');

// Serve the index.html file from the root directory
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

app.use((req, res, next) => {
    console.log(`Request received from: ${req.ip}, URL: ${req.url}`);
    next();
  });
  

const port = 3001;
app.listen(port, '0.0.0.0', () => {
  console.log(`Server is running on http://0.0.0.0:${port}`);
});

module.exports = app;
