// Edición de vértices para Konva.Line (polígono libre)
let vertexLayer = null;
let vertexHandles = [];
let editingVertices = false;

$('#btnEditVertices').on('click', () => { if (!window.isViewMode) toggleVertexEdit(); });

function toggleVertexEdit(){
    if (window.isViewMode) return;  // guard

    const node = transformer.nodes()[0];
    if (!node || node.getClassName() !== 'Line') {
        alert('Selecciona un polígono libre para editar vértices');
        return;
    }
    editingVertices = !editingVertices;
    if (editingVertices) startVertexEdit(node); else stopVertexEdit();
}

function startVertexEdit(line){
    stopVertexEdit(); // limpia si había
    vertexLayer = new Konva.Layer();
    stage.add(vertexLayer);

    const pts = line.points(); // [x0,y0, x1,y1, ...]
    vertexHandles = [];

    for (let i = 0; i < pts.length; i += 2) {
        const hx = pts[i], hy = pts[i+1];
        const handle = new Konva.Circle({
            x: hx, y: hy, radius: 6,
            fill: '#3b82f6', stroke: '#1d4ed8', strokeWidth: 1,
            draggable: true
        });
        handle.on('dragmove', () => {
            const p = line.points();
            p[i] = handle.x();
            p[i+1] = handle.y();
            line.points(p);
            line.getLayer().batchDraw();
        });
        vertexLayer.add(handle);
        vertexHandles.push(handle);
    }
    vertexLayer.draw();
}

function stopVertexEdit(){
    if (vertexLayer) { vertexLayer.destroy(); vertexLayer = null; }
    vertexHandles = [];
    editingVertices = false;
}
