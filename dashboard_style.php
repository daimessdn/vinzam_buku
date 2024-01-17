<style>
    body {
        background-color: #F5F3FF;
    }

    nav {
        background-color: #EDE9FE !important;
    }

    /* popup */
    .popup {
        position: fixed;
        background-color: #00000088;

        z-index: 100;

        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;

        opacity: 0;

        display: none;
        align-items: flex-end;
        justify-content: center;

        transition: all .3s ease;
    }

    .popup-shown {
        display: flex !important;
        opacity: 1 !important;

    }

    .popup-content {
        background-color: #F5F3FF;
        border-radius: .5rem .5rem 0 0;

        transform: translateY(10rem);

        transition: all .3s ease;
        transition-delay: .1s;
    }

    .popup-shown .popup-content {
        transform: translateY(0);
    }

    button {
        transition: all .3s ease;
    }
</style>