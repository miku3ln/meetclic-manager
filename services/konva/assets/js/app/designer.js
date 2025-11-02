// Cargar imagen local (sin backend)
$('#btnLoad').on('click', () => {
    const file = $('#imgFile')[0].files?.[0];
    if(!file) return alert('Selecciona una imagen.');
    const reader = new FileReader();
    reader.onload = e => {
        const url = e.target.result;
        const img = new Image();
        img.onload = async function(){
            imgMeta.url = url;
            imgMeta.naturalW = img.width;
            imgMeta.naturalH = img.height;

            await initKonva(url, img.width, img.height);
            $('#imgInfo').text(`Imagen: ${img.width}×${img.height}`);
            $('#tools').css('display','flex');

            // Precargar 15 figuras
            addPresetShapes();

            // Eventos del stage
            bindStageEvents();
        };
        img.src = url;
    };
    reader.readAsDataURL(file);
});

// Eventos del stage de dibujo/selección
function bindStageEvents(){
    // limpiar bindings previos
    stage.off('click');
    stage.off('dblclick');

    stage.on('click', (e)=>{
        if (e.target === stage || e.target === imageNode) {
            transformer.nodes([]); layerZones.draw();
            if (currentTool === 'poly') addPolyPoint(e.evt);
            return;
        }
        if (currentTool === 'select') {
            const tgt = e.target;
            transformer.nodes([tgt]); layerZones.draw();
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

    stage.on('dblclick', endPolygon);
}

// Botones varios
$('#btnEndPoly').on('click', endPolygon);
$('#btnDelete').on('click', () => {
    transformer.nodes().forEach(n => n.destroy());
    transformer.nodes([]); layerZones.draw();
    $('#clickInfo').text('—');
});
$('#btnGenerate').on('click', generateJSON);
