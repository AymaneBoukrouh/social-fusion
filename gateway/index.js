const express = require('express');
const httpProxy = require('http-proxy');

// app
const app = express();
const port = 3000;

// start server
app.listen(port, () => {
  console.log(`Gateway listening at http://localhost:${port}`);
});
