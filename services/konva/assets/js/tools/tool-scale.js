// Botones expandir / reducir
$('#btnScalePlus').on('click', () => { if (!window.isViewMode) scaleSelected(1.15); });
$('#btnScaleMinus').on('click', () => { if (!window.isViewMode) scaleSelected(0.87); });

window.scaleSelected = function scaleSelected(factor){
    if (window.isViewMode) return;
    const nodes = transformer.nodes();
    if (!nodes.length) return;

    nodes.forEach(n => {
        const prev = { sx: n.scaleX(), sy: n.scaleY() };
        const next = { sx: prev.sx * factor, sy: prev.sy * factor };
        n.scale(next);

        // recentrar para rects para sensación de "expandir"
        if (n.width && n.height) {
            const wOld = n.width() * prev.sx, hOld = n.height() * prev.sy;
            const wNew = n.width() * next.sx, hNew = n.height() * next.sy;
            n.x(n.x() - (wNew - wOld)/2);
            n.y(n.y() - (hNew - hOld)/2);
        }
    });

    layerZones.batchDraw();
};
