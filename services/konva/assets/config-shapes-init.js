
function nextId(prefix){ autoId++; return `${prefix}_${autoId}`; }

// Herramientas
$(document).on('click', '.toolbar button[data-tool]', function(){
    $('.toolbar button[data-tool]').removeClass('active');
    $(this).addClass('active');
    currentTool = $(this).data('tool');
    if (currentTool !== 'poly' && polyDrawing) endPolygon();
});

// Cargar imagen local con FileReader (sin backend)
$('#btnLoad').on('click', () => {
    const file = $('#imgFile')[0].files?.[0];
    if(!file) return alert('Selecciona una imagen.');
    const reader = new FileReader();
    reader.onload = e => {
        const url = e.target.result;
        const img = new Image();
        img.onload = function(){
            imgMeta.url = url;
            imgMeta.naturalW = img.width;
            imgMeta.naturalH = img.height;
            initKonva(url, img.width, img.height);
            $('#imgInfo').text(`Imagen: ${img.width}×${img.height}`);
            $('#tools').css('display','flex');
        };
        img.src = url;
    };
    reader.readAsDataURL(file);
});

function initKonva(imgUrl, realW, realH){
    if (stage) stage.destroy();

    const container = document.getElementById('canvas');
    const CW = container.clientWidth;
    const CH = container.clientHeight;
    const scale = Math.min(CW/realW, CH/realH);
    imgMeta.scale = scale;
    imgMeta.viewW = realW*scale;
    imgMeta.viewH = realH*scale;

    stage = new Konva.Stage({ container: 'canvas', width: CW, height: CH });
    layerBg   = new Konva.Layer();
    layerZones= new Konva.Layer();
    transformer = new Konva.Transformer({
        padding: 6,
        rotateEnabled: false,        // ponlo true si quieres rotación global
        keepRatio: false,            // true para círculos/cuadrados si deseas proporción fija
        centeredScaling: true,       // ESCALAR desde el centro (sensación de “expandir”)
        ignoreStroke: true,
        enabledAnchors: [
            'top-left','top-center','top-right',
            'middle-left','middle-right',
            'bottom-left','bottom-center','bottom-right'
        ],
        // Evita colapsar o invertir
        boundBoxFunc: (oldBox, newBox) => {
            const MIN = 16;
            if (Math.abs(newBox.width) < MIN || Math.abs(newBox.height) < MIN) return oldBox;
            return newBox;
        }
    });
    stage.add(layerBg);
    stage.add(layerZones);
    layerZones.add(transformer);

    const imageObj = new Image();
    imageObj.onload = function(){
        imageNode = new Konva.Image({ image: imageObj, x: 0, y: 0, width: imgMeta.viewW, height: imgMeta.viewH, listening: false });
        layerBg.add(imageNode); layerBg.draw();
        // Precargar 15 figuras
        addPresetShapes();
    };
    imageObj.src = imgUrl;

    stage.on('click', (e)=>{
        if (e.target === stage || e.target === imageNode) {
            transformer.nodes([]); layerZones.draw();
            if (currentTool === 'poly') addPolyPoint(e.evt);
            return;
        }
        if (currentTool === 'select') {
            const tgt = e.target;
            transformer.nodes([tgt]);
            layerZones.draw();
            showClickInfo(tgt);
        } else if (currentTool === 'rect') {
            const node = createRectAt(e.evt.offsetX, e.evt.offsetY);
            showClickInfo(node);
        } else if (currentTool === 'circle') {
            const node = createCircleAt(e.evt.offsetX, e.evt.offsetY);
            showClickInfo(node);
        } else if (currentTool === 'poly') {
            addPolyPoint(e.evt);
        }
    });

    $('#btnEndPoly').off('click').on('click', endPolygon);
    stage.on('dblclick', endPolygon);

    $('#btnDelete').off('click').on('click', () => {
        transformer.nodes().forEach(n => n.destroy());
        transformer.nodes([]); layerZones.draw();
        $('#clickInfo').text('—');
    });

    $('#btnGenerate').off('click').on('click', generateJSON);
}

function makeDraggable(node) {
    node.draggable(true);
    node.on('dragmove', ()=> layerZones.batchDraw());
    node.on('transform', ()=> layerZones.batchDraw());
    node.on('click', () => {
        if (currentTool==='select') {
            transformer.nodes([node]); layerZones.draw();
            showClickInfo(node);
        }
    });
    node.on('mouseenter', ()=> { document.body.style.cursor = 'pointer'; });
    node.on('mouseleave', ()=> { document.body.style.cursor = 'default'; });
    layerZones.add(node); layerZones.draw();
    return node;
}

// Creadores
function createRectAt(x,y, w=120, h=80){
    const rect = new Konva.Rect({
        x: x-30, y: y-20, width: w, height: h,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rect'), zoneLabel: `Rect ${autoId}`, type: 'rect'
    });
    makeDraggable(rect); transformer.nodes([rect]);
    return rect;
}

function createCircleAt(x,y, r=50){
    const circle = new Konva.Circle({
        x, y, radius: r,
        fill: 'rgba(16,185,129,0.15)', stroke: '#10b981', strokeWidth: 1,
        name: 'zone', zoneId: nextId('circle'), zoneLabel: `Circle ${autoId}`, type: 'circle'
    });
    makeDraggable(circle); transformer.nodes([circle]);
    return circle;
}

function createSquareAt(x,y, size=90){
    const rect = new Konva.Rect({
        x, y, width: size, height: size,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('square'), zoneLabel: `Square ${autoId}`, type: 'rect'
    });
    return makeDraggable(rect);
}

function createRectangleAt(x,y, w=130, h=70){
    const rect = new Konva.Rect({
        x, y, width: w, height: h,
        fill: 'rgba(59,130,246,0.15)', stroke: '#2563eb', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rectangle'), zoneLabel: `Rectangle ${autoId}`, type: 'rect'
    });
    return makeDraggable(rect);
}

function createRhombusAt(x,y, size=100){
    const rh = new Konva.Rect({
        x, y, width: size, height: size, rotation: 45,
        offset: { x: size/2, y: size/2 },
        fill: 'rgba(139,92,246,0.15)', stroke: '#7c3aed', strokeWidth: 1,
        name: 'zone', zoneId: nextId('rhombus'), zoneLabel: `Rhombus ${autoId}`, type: 'polygon'
    });
    return makeDraggable(rh);
}

function createHexagonAt(x,y, radius=60){
    const hex = new Konva.RegularPolygon({
        x, y, sides: 6, radius,
        fill: 'rgba(234,179,8,0.15)', stroke: '#ca8a04', strokeWidth: 1,
        name: 'zone', zoneId: nextId('hexagon'), zoneLabel: `Hexagon ${autoId}`, type: 'polygon'
    });
    return makeDraggable(hex);
}

// Polígono libre
function addPolyPoint(evt){
    if (!polyDrawing) {
        polyDrawing = new Konva.Line({
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
}
function endPolygon(){
    if (!polyDrawing) return;
    const pts = polyDrawing.points();
    if (pts.length >= 6) { polyDrawing.closed(true); }
    transformer.nodes([polyDrawing]);
    layerZones.draw();
    showClickInfo(polyDrawing);
    polyDrawing = null;
}

// Info de clic (ubicación y sección)
function showClickInfo(node){
    const cls = node.getClassName();
    const common = {
        id: node.getAttr('zoneId'),
        label: node.getAttr('zoneLabel'),
        type: node.getAttr('type') || cls
    };
    let detail = {};
    if (cls === 'Rect') {
        detail = {
            x: round(node.x()), y: round(node.y()),
            width: round(node.width()*node.scaleX()), height: round(node.height()*node.scaleY()),
            rotation: round(node.rotation()||0)
        };
    } else if (cls === 'Circle') {
        detail = {
            x: round(node.x()), y: round(node.y()),
            radius: round(node.radius()*((node.scaleX()+node.scaleY())/2))
        };
    } else if (cls === 'RegularPolygon') {
        detail = {
            x: round(node.x()), y: round(node.y()),
            sides: node.sides(), radius: round(node.radius()*((node.scaleX()+node.scaleY())/2))
        };
    } else if (cls === 'Line') {
        detail = {
            points: node.points().map(n => round(n)),
            closed: !!node.closed()
        };
    }
    const out = { section: common, geom: detail };
    $('#clickInfo').text(JSON.stringify(out, null, 2));
}

// Generar JSON de layout (cómo se guardaría)
function generateJSON(){
    const shapes = layerZones.find('.zone').map(n => {
        const cls = n.getClassName();
        const base = { id: n.getAttr('zoneId'), label: n.getAttr('zoneLabel'), kind: n.getAttr('type') || cls };
        if (cls === 'Rect') {
            return { ...base,
                geom: { type:'rect', x:r(n.x()), y:r(n.y()), width:r(n.width()*n.scaleX()), height:r(n.height()*n.scaleY()), rotation:r(n.rotation()||0) }
            };
        }
        if (cls === 'Circle') {
            return { ...base,
                geom: { type:'circle', x:r(n.x()), y:r(n.y()), radius:r(n.radius()*((n.scaleX()+n.scaleY())/2)) }
            };
        }
        if (cls === 'RegularPolygon') {
            return { ...base,
                geom: { type:'regularPolygon', x:r(n.x()), y:r(n.y()), sides:n.sides(), radius:r(n.radius()*((n.scaleX()+n.scaleY())/2)) }
            };
        }
        if (cls === 'Line') {
            return { ...base,
                geom: { type:'polygon', points:n.points().map(p=>r(p)), closed: !!n.closed() }
            };
        }
    });

    const payload = {
        image: {
            url: imgMeta.url,
            naturalWidth: imgMeta.naturalW,
            naturalHeight: imgMeta.naturalH,
            viewWidth: imgMeta.viewW,
            viewHeight: imgMeta.viewH,
            scale: imgMeta.scale
        },
        shapes
    };
    const jsonStr = JSON.stringify(payload, null, 2);
    $('#jsonOut').val(jsonStr);
    // también a consola por si quieres copiar desde ahí:
    console.log('JSON layout:', payload);
}

function r(n){ return Math.round(n*100)/100; }
function round(n){ return Math.round(n*100)/100; }

// Precargar 15 figuras (se colocan sobre la imagen escalada)
function addPresetShapes(){
    // 3 círculos
    createCircleAt(120, 110, 45);
    createCircleAt(220, 110, 45);
    createCircleAt(320, 110, 45);
    // 3 cuadrados
    createSquareAt(430, 70, 90);
    createSquareAt(540, 70, 90);
    createSquareAt(650, 70, 90);
    // 3 rectángulos
    createRectangleAt(90, 230, 140, 70);
    createRectangleAt(260, 230, 140, 70);
    createRectangleAt(430, 230, 140, 70);
    // 3 rombos
    createRhombusAt(650, 230, 110);
    createRhombusAt(760, 230, 110);
    createRhombusAt(870, 230, 110);
    // 3 hexágonos
    createHexagonAt(150, 360, 55);
    createHexagonAt(260, 360, 55);
    createHexagonAt(370, 360, 55);
}