// Enlaza/desenlaza eventos de usuario a un nodo.
// Soportados: click, dblclick, over (mouseenter)
(function(){
    function execUserCode(code, node, e){
        try {
            const ctx = { node, stage, layerZones, transformer, e, Konva, $ };
            // sandbox simple: el código se ejecuta con acceso a ctx (node, stage, etc.)
            const fn = new Function('ctx', 'with(ctx){' + code + '}');
            fn(ctx);
        } catch (err) {
            console.error('Error en evento del usuario:', err);
            alert('Error en evento: ' + (err && err.message ? err.message : err));
        }
    }

    window.bindNodeEvents = function bindNodeEvents(node, events){
        const cfg = events || node.getAttr('zoneEvents') || {};
        // Limpia handlers anteriores de este "namespace"
        node.off('.userfn');

        if (cfg.click) {
            node.on('click.userfn', (e) => execUserCode(cfg.click, node, e));
        }
        if (cfg.dblclick) {
            node.on('dblclick.userfn', (e) => execUserCode(cfg.dblclick, node, e));
        }
        if (cfg.over) {
            node.on('mouseenter.userfn', (e) => execUserCode(cfg.over, node, e));
        }
    };
})();
