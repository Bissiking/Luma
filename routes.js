const config = require('./app/config');
const luma = require('./app/luma');

const setupRoutes = (app) => {
    app.use('/config', config);
    app.use('/app2', luma);
};

module.exports = setupRoutes;
