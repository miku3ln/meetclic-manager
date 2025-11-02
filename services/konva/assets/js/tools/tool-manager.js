// Cambiar herramienta
$(document).on('click', '.toolbar button[data-tool]', function(){
    $('.toolbar button[data-tool]').removeClass('active');
    $(this).addClass('active');
    window.currentTool = $(this).data('tool');
    if (currentTool !== 'poly' && window.polyDrawing) endPolygon();
});

// Drawing polígono libre
window.addPolyPoint = function addPolyPoint(evt){
    if (window.isViewMode) return;   // guard
    if (!window.polyDrawing) {
        window.polyDrawing = new Konva.Line({
            points: [evt.offsetX, evt.offsetY],
            stroke: '#8b5cf6', strokeWidth: 1, closed: false,
            fill: 'rgba(139,92,246,0.15)', name: 'zone',
            zoneId: nextId('poly'), zoneLabel: `Poly ${autoId}`, type: 'polygon'
        });
        makeDraggable(polyDrawing);
    } else {
        const pts = polyDrawing.points().concat([evt.offsetX, evt.offsetY]);
        polyDrawing.points(pts);
        layerZones.draw();
    }
};

window.endPolygon = function endPolygon(){
    if (window.isViewMode) return;   // guard

    if (!window.polyDrawing) return;
    const pts = polyDrawing.points();
    if (pts.length >= 6) { polyDrawing.closed(true); }
    transformer.nodes([polyDrawing]);
    layerZones.draw();
    showClickInfo(polyDrawing);
    window.polyDrawing = null;
};
