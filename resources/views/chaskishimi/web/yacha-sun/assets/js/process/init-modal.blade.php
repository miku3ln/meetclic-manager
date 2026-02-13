<script id="modal">

    function openDynamicModal({
                                  id = "dynamicModal",
                                  fullscreen = true,
                                  options = { backdrop: "static", keyboard: false },
                                  template,
                                  onShow,
                                  onShown,
                                  onHide,
                                  onHidden,
                                  onHidePrevented
                              } = {}) {
        const modalEl = document.getElementById(id);
        const dialogEl = modalEl.querySelector(".modal-dialog");
        const contentEl = modalEl.querySelector(".modal-content");

        dialogEl.className = "modal-dialog";
        if (fullscreen) dialogEl.classList.add("modal-fullscreen");

        // bind events (una sola vez por apertura)
        const once = (name, fn) => fn && modalEl.addEventListener(name, fn, { once: true });

        once("show.bs.modal", (ev) => {
            if (template) contentEl.innerHTML = template();
            onShow && onShow({ modalEl, dialogEl, contentEl }, ev);
        });

        once("shown.bs.modal", (ev) => onShown && onShown({ modalEl, dialogEl, contentEl }, ev));

        modalEl.addEventListener("hide.bs.modal", (ev) => {
            if (onHide) onHide({ modalEl, dialogEl, contentEl }, ev);
        }, { once: true });

        once("hidden.bs.modal", (ev) => onHidden && onHidden({ modalEl, dialogEl, contentEl }, ev));
        once("hidePrevented.bs.modal", (ev) =>
            onHidePrevented && onHidePrevented({ modalEl, dialogEl, contentEl }, ev)
        );

        // ✅ guarda la instancia y devuélvela
        const instance = bootstrap.Modal.getOrCreateInstance(modalEl, options);
        instance.show();

        return {
            id,
            modalEl,
            instance,
            close: () => instance.hide(),
            setSaving: (isSaving) => { modalEl.dataset.saving = isSaving ? "1" : "0"; }
        };
    }

    var modalEl;
    var configModal = {
        modalEl: null,
        modal: null,
        configuration:null,
    };

    function initModalEvents(params) {
        modalEl = document.getElementById('dynamicModal')

        const modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        modalEl.addEventListener('show.bs.modal', (event) => {
            const content = modalEl.querySelector('.modal-content')

            content.innerHTML = `
    <div class="modal-header">
      <h5 class="modal-title">Modal dinámico</h5>
      <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
      <div id="dynamicBody">
        Cargando contenido…
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-secondary" data-bs-dismiss="modal">
        Cerrar
      </button>
    </div>
  `
        });

        modalEl.addEventListener('shown.bs.modal', () => {
            document.getElementById('dynamicBody').innerHTML = `
    <p>Contenido cargado por evento</p>
  `
        });
        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.querySelector('.modal-content').innerHTML = ''
        });
        configModal.modalEl = modalEl;
        configModal.modal = modal;

    }

</script>
