// Crea 15 figuras de ejemplo
window.addPresetShapes = function addPresetShapes(){
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
};
