const express = require('express');
const httpProxy = require('http-proxy');

// app
const app = express();
const port = 3000;

// proxies
const postProxy = httpProxy.createProxyServer({
  target: 'http://post_service'
});

// routes
app.all('/api/posts/*', (req, res) => {
  postProxy.web(req, res);
});

// start server
app.listen(port, () => {
  console.log(`Gateway listening at http://localhost:${port}`);
});
