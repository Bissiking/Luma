const fs = require('fs');
const path = require('path');

function createMediaRoot(directory) {
  if (!fs.existsSync(directory)) {
    fs.mkdirSync(directory, { recursive: true });
    console.log(`Created directory: ${directory}`);
  } else {
    console.log(`Directory already exists: ${directory}`);
  }
}

module.exports = createMediaRoot;
