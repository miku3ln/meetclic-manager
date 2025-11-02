// Crea stage, layers y transformer. Devuelve una Promise cuando la imagen queda lista.
window.initKonva = function initKonva(imgUrl, realW, realH){
    return new Promise((resolve) => {
        if (window.stage) window.stage.destroy();

        const container = document.getElementById('canvas');
        const CW = container.clientWidth;
        const CH = container.clientHeight;
        const scale = Math.min(CW/realW, CH/realH);

        imgMeta.scale = scale;
        imgMeta.viewW = realW * scale;
        imgMeta.viewH = realH * scale;

        window.stage = new Konva.Stage({ container: 'canvas', width: CW, height: CH });
        window.layerBg = new Konva.Layer();
        window.layerZones = new Konva.Layer();
        window.transformer = new Konva.Transformer({
            padding: 6,
            rotateEnabled: false,
            keepRatio: false,
            centeredScaling: true,
            ignoreStroke: true,
            enabledAnchors: [
                'top-left','top-center','top-right',
                'middle-left','middle-right',
                'bottom-left','bottom-center','bottom-right'
            ],
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
            window.imageNode = new Konva.Image({
                image: imageObj, x: 0, y: 0, width: imgMeta.viewW, height: imgMeta.viewH, listening: false
            });
            layerBg.add(imageNode); layerBg.draw();
            resolve();
        };
        imageObj.src = imgUrl;
    });
};
