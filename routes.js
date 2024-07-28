const config = require('./app/config');
const luma = require('./app/luma');
const nino = require('./app/nino');

const setupRoutes = (app) => {
    app.use('/config', config);
    app.use('/app2', luma);
    app.use('/nino', nino);
};

module.exports = setupRoutes;
