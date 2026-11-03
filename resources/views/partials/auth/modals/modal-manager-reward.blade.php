<style id="modal-manager-reward">
    /* ==========================================
   YAPITA - REWARD MODAL
========================================== */

    .yapita-reward-modal {
        position: relative;
        border: none;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
    }

    .yapita-reward-close {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 10;
        background-color: #ffffff;
        padding: 12px;
        border-radius: 50%;
        opacity: 1;
    }

    .yapita-reward-image-container {
        width: 100%;
        height: 220px;
        background: linear-gradient(
            135deg,
            #eef2ff,
            #ffffff
        );
        overflow: hidden;
    }

    .yapita-reward-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .yapita-reward-modal .modal-body {
        padding: 25px;
    }

    .yapita-reward-badge {
        display: inline-block;
        padding: 9px 18px;
        border-radius: 30px;
        background: #eef2ff;
        color: #2945f5;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .yapita-reward-user {
        font-size: 21px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 12px;
    }

    .yapita-reward-title {
        font-size: 18px;
        font-weight: 700;
        color: #2945f5;
        margin-bottom: 10px;
    }

    .yapita-reward-subtitle {
        font-size: 14px;
        line-height: 1.6;
        color: #6b7280;
        margin-bottom: 22px;
    }

    .yapita-reward-points {
        background: linear-gradient(
            135deg,
            #eef2ff,
            #f8faff
        );
        padding: 22px;
        border-radius: 18px;
        margin-bottom: 24px;
    }

    .yapita-reward-points-label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: #2945f5;
        letter-spacing: 1px;
    }

    .yapita-reward-points-value {
        font-size: 52px;
        font-weight: 900;
        color: #2945f5;
        line-height: 1.2;
    }

    .yapita-reward-points-text {
        font-size: 17px;
        font-weight: 800;
        color: #2945f5;
    }

    .yapita-reward-button {
        width: 100%;
        background: #2945f5;
        color: white;
        padding: 15px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        border: none;
    }

    .yapita-reward-button:hover {
        background: #1935dc;
        color: white;
    }

    @media (max-width: 576px) {

        .yapita-reward-image-container {
            height: 180px;
        }

        .yapita-reward-modal .modal-body {
            padding: 20px;
        }

        .yapita-reward-points-value {
            font-size: 42px;
        }
    }
</style>
