window.createRectAt = function createRectAt(x,y, w=120, h=80){
    const node = new Konva.Rect({
        x: x-30, y: y-20, width: w, height: h,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rect'), zoneLabel: `Rect ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'rect'
    });
    makeDraggable(node); transformer.nodes([node]); bindNodeEvents(node);
    return node;
};

window.createCircleAt = function createCircleAt(x,y, r=50){
    const node = new Konva.Circle({
        x, y, radius: r,
        fill: 'rgba(16,185,129,0.15)', stroke: '#10b981', strokeWidth: 1,
        name: 'zone', zoneId: nextId('circle'), zoneLabel: `Circle ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'circle'
    });
    makeDraggable(node); transformer.nodes([node]); bindNodeEvents(node);
    return node;
};

window.createSquareAt = function createSquareAt(x,y, size=90){
    const node = new Konva.Rect({
        x, y, width: size, height: size,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('square'), zoneLabel: `Square ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'rect'
    });
    makeDraggable(node); bindNodeEvents(node); return node;
};

window.createRectangleAt = function createRectangleAt(x,y, w=130, h=70){
    const node = new Konva.Rect({
        x, y, width: w, height: h,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rectangle'), zoneLabel: `Rectangle ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'rect'
    });
    makeDraggable(node); bindNodeEvents(node); return node;
};

window.createRhombusAt = function createRhombusAt(x,y, size=100){
    const node = new Konva.Rect({
        x, y, width: size, height: size, rotation: 45,
        offset: { x: size/2, y: size/2 },
        fill: 'rgba(139,92,246,0.15)', stroke: '#7c3aed', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rhombus'), zoneLabel: `Rhombus ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'polygon'
    });
    makeDraggable(node); bindNodeEvents(node); return node;
};

window.createHexagonAt = function createHexagonAt(x,y, radius=60){
    const node = new Konva.RegularPolygon({
        x, y, sides: 6, radius,
        fill: 'rgba(234,179,8,0.15)', stroke: '#ca8a04', strokeWidth: 1,
        name: 'zone', zoneId: nextId('hexagon'), zoneLabel: `Hexagon ${autoId}`, zoneDesc: '', zoneEvents:{}, type: 'polygon'
    });
    makeDraggable(node); bindNodeEvents(node); return node;
};
