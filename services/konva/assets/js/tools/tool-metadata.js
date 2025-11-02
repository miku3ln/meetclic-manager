// Manejo del diálogo de metadatos (título + descripción + eliminar + eventos)
let metaTarget = null;
const dlg = document.getElementById('metaDialog');
const $title = $('#metaTitle');
const $desc = $('#metaDesc');

const $evClickChk = $('#evClickChk');
const $evDblClickChk = $('#evDblClickChk');
const $evOverChk = $('#evOverChk');
const $evClickCode = $('#evClickCode');
const $evDblClickCode = $('#evDblClickCode');
const $evOverCode = $('#evOverCode');

function toggleTextarea($chk, $ta){
    const on = $chk.is(':checked');
    $ta.prop('disabled', !on).toggleClass('disabled', !on);
}

$evClickChk.on('change', () => toggleTextarea($evClickChk, $evClickCode));
$evDblClickChk.on('change', () => toggleTextarea($evDblClickChk, $evDblClickCode));
$evOverChk.on('change', () => toggleTextarea($evOverChk, $evOverCode));

window.openMetaDialog = function openMetaDialog(node){
    if (window.isViewMode) return;   // guard

    metaTarget = node;
    // Datos básicos
    $title.val(node.getAttr('zoneLabel') || '');
    $desc.val(node.getAttr('zoneDesc') || '');

    // Eventos
    const ev = node.getAttr('zoneEvents') || {};
    $evClickChk.prop('checked', !!ev.click);   $evClickCode.val(ev.click || '');
    $evDblClickChk.prop('checked', !!ev.dblclick); $evDblClickCode.val(ev.dblclick || '');
    $evOverChk.prop('checked', !!ev.over);     $evOverCode.val(ev.over || '');

    // habilitar/deshabilitar textareas
    toggleTextarea($evClickChk, $evClickCode);
    toggleTextarea($evDblClickChk, $evDblClickCode);
    toggleTextarea($evOverChk, $evOverCode);

    if (typeof dlg.showModal === 'function') dlg.showModal();
    else dlg.setAttribute('open',''); // fallback simple
};

// Guardar cambios
$('#metaSave').on('click', (e) => {
    e.preventDefault();
    if (!metaTarget) return;

    // título/descr
    metaTarget.setAttr('zoneLabel', ($title.val() || '').trim());
    metaTarget.setAttr('zoneDesc', ($desc.val() || '').trim());

    // eventos
    const ev = {};
    if ($evClickChk.is(':checked'))   ev.click = $evClickCode.val();
    if ($evDblClickChk.is(':checked')) ev.dblclick = $evDblClickCode.val();
    if ($evOverChk.is(':checked'))    ev.over = $evOverCode.val();

    metaTarget.setAttr('zoneEvents', ev);
    bindNodeEvents(metaTarget, ev);   // enlaza handlers

    layerZones.batchDraw();
    if (transformer.nodes()[0] === metaTarget && window.showClickInfo) {
        window.showClickInfo(metaTarget);
    }
    dlg.close();
    metaTarget = null;
});

// Cancelar
$('#metaCancel').on('click', (e) => {
    e.preventDefault();
    dlg.close();
    metaTarget = null;
});

// Eliminar zona
$('#metaDelete').on('click', (e) => {
    e.preventDefault();
    if (!metaTarget) return;

    const name = metaTarget.getAttr('zoneLabel') || metaTarget.getAttr('zoneId') || 'zona';
    if (!window.confirm(`¿Eliminar definitivamente "${name}"?`)) return;

    metaTarget.destroy();
    transformer.nodes([]);
    layerZones.batchDraw();
    $('#clickInfo').text('—');
    dlg.close();
    metaTarget = null;
});
