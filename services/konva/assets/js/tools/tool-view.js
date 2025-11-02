// Toggle de modo Visualizar (solo ejecutar eventos; sin edición)
(function(){
    function setButtonsDisabled(disabled){
        const editSelectors = [
            '[data-tool="select"]','[data-tool="rect"]','[data-tool="circle"]','[data-tool="poly"]',
            '#btnEndPoly','#btnScalePlus','#btnScaleMinus','#btnEditVertices','#btnDelete'
        ];
        $(editSelectors.join(',')).prop('disabled', disabled);
    }

    window.setViewMode = function setViewMode(on){
        window.isViewMode = !!on;

        // botón UI
        $('#btnView')
            .toggleClass('active', on)
            .text(on ? 'Visualizar (ON)' : 'Visualizar');

        // deshabilitar edición
        setButtonsDisabled(on);

        // ocultar selección y edición de vértices
        if (window.transformer){
            transformer.nodes([]);
            transformer.visible(!on);
        }
        if (typeof window.stopVertexEdit === 'function') window.stopVertexEdit();

        // shapes: bloquear/permitir drag
        if (window.layerZones){
            layerZones.find('.zone').forEach(n => n.draggable(!on));
            layerZones.batchDraw();
        }
    };

    // click del botón
    $('#btnView').on('click', () => setViewMode(!window.isViewMode));
})();
