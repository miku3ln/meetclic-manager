let currentTool = 'select';
let stage, layerBg, layerZones, transformer;
let imageNode = null;
let imgMeta = { url: null, naturalW: 0, naturalH: 0, viewW: 0, viewH: 0, scale: 1 };
let polyDrawing = null; // Konva.Line en modo polígono
let autoId = 0;
