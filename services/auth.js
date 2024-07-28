const validStreamKeys = new Set([
    'test01',
    'test02',
    // Ajoutez d'autres clés valides ici
  ]);
  
  function validateStreamKey(streamKey) {
    return validStreamKeys.has(streamKey);
  }
  
  module.exports = {
    validateStreamKey
  };
  