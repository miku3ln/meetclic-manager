// Hace un nodo arrastrable, seleccionable y con cursor correcto
window.makeDraggable = function makeDraggable(node){
    node.strokeScaleEnabled(true);  // el stroke escala con la figura
    node.draggable(true);

    node.on('dragmove', ()=> layerZones.batchDraw());
    node.on('transform', ()=> layerZones.batchDraw());

    node.on('click', () => {
        if (currentTool === 'select') {
            transformer.nodes([node]); layerZones.draw();
            if (window.showClickInfo) window.showClickInfo(node);
        }
    });

    // Clic derecho -> abrir diálogo de metadatos
    node.on('contextmenu', (e) => {
        e.evt.preventDefault();
        if (window.openMetaDialog) window.openMetaDialog(node);
    });

    node.on('mouseenter', ()=> { document.body.style.cursor = 'pointer'; });
    node.on('mouseleave', ()=> { document.body.style.cursor = 'default'; });

    layerZones.add(node); layerZones.draw();
    return node;
};
