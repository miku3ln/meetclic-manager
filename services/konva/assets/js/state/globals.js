// Variables globales (accesibles desde todos los archivos)
window.currentTool = 'select';

window.stage = null;
window.layerBg = null;
window.layerZones = null;
window.transformer = null;

window.imageNode = null;
window.imgMeta = { url: null, naturalW: 0, naturalH: 0, viewW: 0, viewH: 0, scale: 1 };

window.polyDrawing = null; // Konva.Line cuando estás dibujando un polígono libre
window.autoId = 0;
window.isViewMode = false;