const express = require('express');
const os = require('os');

const app = express();
const port = 3000;

app.get('/system-info', (req, res) => {
  const cpuUsage = os.loadavg()[0].toFixed(2);
  const totalMemory = os.totalmem();
  const freeMemory = os.freemem();
  const usedMemory = totalMemory - freeMemory;

  res.json({
    cpuUsage: cpuUsage,
    totalMemory: totalMemory,
    usedMemory: usedMemory,
    freeMemory: freeMemory,
  });
});

app.listen(port, () => {
  console.log(`Serveur API en cours d'exécution sur http://localhost:${port}`);
});
