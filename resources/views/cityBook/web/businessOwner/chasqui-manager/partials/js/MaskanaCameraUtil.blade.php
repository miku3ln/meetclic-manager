<script>

    class MaskanaCameraUtil {

        static stream = null;
        static capturedFile = null;

        static init() {
            $('#btn-capture-camera').on('click', async () => {
                await this.startCamera();
            });

            $('#btn-take-photo').on('click', () => {
                this.captureImage();
            });

            $('#btn-close-camera').on('click', () => {
                this.stopCamera();
            });

            $(window).on('pagehide', () => {
                this.stopCamera();
            });
        }

        static async startCamera() {
            try {
                if (!navigator.mediaDevices?.getUserMedia) {
                    throw new Error('Cámara no disponible. Utiliza HTTPS o localhost.');
                }

                this.stopCamera();

                this.stream = await navigator.mediaDevices.getUserMedia({
                    audio: false,
                    video: {
                        facingMode: { ideal: 'environment' }
                    }
                });

                const video = document.getElementById('camera-preview');

                video.srcObject = this.stream;

                $('#camera-container').removeClass('d-none');

                await video.play();

                $(document).trigger('maskana:camera:started');

            } catch (error) {
                console.error('Error al iniciar cámara:', error);

                $(document).trigger('maskana:camera:error', [{
                    message: error.message,
                    error
                }]);
            }
        }

        static captureImage() {
            const video = document.getElementById('camera-preview');

            if (!this.stream || !video.videoWidth || !video.videoHeight) {
                return;
            }

            const canvas = document.createElement('canvas');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const context = canvas.getContext('2d');

            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                if (!blob) return;

                this.capturedFile = new File(
                    [blob],
                    `maskana-${Date.now()}.jpg`,
                    { type: 'image/jpeg' }
                );

                const image = document.getElementById('camera-image-result');

                image.src = URL.createObjectURL(blob);
                image.hidden = false;

                $(document).trigger('maskana:camera:captured', [{
                    file: this.capturedFile,
                    blob,
                    width: canvas.width,
                    height: canvas.height
                }]);

                this.stopCamera();

            }, 'image/jpeg', 0.85);
        }

        static stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }

            const video = document.getElementById('camera-preview');

            if (video) {
                video.pause();
                video.srcObject = null;
            }

            $('#camera-container').addClass('d-none');

            $(document).trigger('maskana:camera:stopped');
        }
    }

    // INICIALIZACIÓN
    $(document).ready(() => {
        MaskanaCameraUtil.init();
    });

</script>
