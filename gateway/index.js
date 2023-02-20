const express = require('express');
const httpProxy = require('http-proxy');

// app
const app = express();
const port = 3000;

// proxies
const userProxy = httpProxy.createProxyServer({
  target: 'http://user_service'
});

const postProxy = httpProxy.createProxyServer({
  target: 'http://post_service'
});

// routes
app.all('/api/users/*', (req, res) => {
  userProxy.web(req, res);
});

app.all('/api/posts/*', (req, res) => {
  postProxy.web(req, res);
});

// start server
app.listen(port, () => {
  console.log(`Gateway listening at http://localhost:${port}`);
});
