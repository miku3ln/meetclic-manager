// Info al hacer click
window.showClickInfo = function showClickInfo(node){
    const cls = node.getClassName();
    const common = {
        id: node.getAttr('zoneId'),
        label: node.getAttr('zoneLabel') || '',
        description: node.getAttr('zoneDesc') || '',
        type: node.getAttr('type') || cls,
        events: node.getAttr('zoneEvents') || {},
    };
    let detail = {};
    if (cls === 'Rect') {
        detail = {
            x: r(node.x()), y: r(node.y()),
            width: r(node.width() * node.scaleX()),
            height: r(node.height() * node.scaleY()),
            rotation: r(node.rotation() || 0)
        };
    } else if (cls === 'Circle') {
        detail = {
            x: r(node.x()), y: r(node.y()),
            radius: r(node.radius() * ((node.scaleX()+node.scaleY())/2))
        };
    } else if (cls === 'RegularPolygon') {
        detail = {
            x: r(node.x()), y: r(node.y()),
            sides: node.sides(), radius: r(node.radius() * ((node.scaleX()+node.scaleY())/2))
        };
    } else if (cls === 'Line') {
        detail = {
            points: node.points().map(n => r(n)),
            closed: !!node.closed()
        };
    }
    const out = { section: common, geom: detail };
    $('#clickInfo').text(JSON.stringify(out, null, 2));
};

// Serializa todo el layout a JSON y lo muestra
window.generateJSON = function generateJSON(){
    const shapes = layerZones.find('.zone').map(n => {
        const cls = n.getClassName();
        const base = {
            id: n.getAttr('zoneId'),
            label: n.getAttr('zoneLabel') || '',
            description: n.getAttr('zoneDesc') || '',
            kind: n.getAttr('type') || cls,
            events: n.getAttr('zoneEvents') || {},
        };
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
    $('#jsonOut').val(JSON.stringify(payload, null, 2));
    console.log('JSON layout:', payload);
};
