<script src="assets/js/modals.js" type="text/javascript" defer></script>
<link rel="stylesheet" href="assets/css/modals.css">

<div class="modals" id="modals-cnt">

    <div class="modal" id="edit-modal"> <!-- Edit Modal -->
        <div class="top">
            <img src="components/avatar.php?color=ffffff" class="logo">
            <div class="text">
                <p class="title">Modifica la tua barca</p>
                <p class="description">Aggiorna le informazioni della tua imbarcazione</p>
            </div>
            <p class="close" onclick="closeModal()">&#x2715;</p>
        </div>
        <div class="middle">
            <div class="inputbox text">
                <p>Nome barca</p>
                <div class="input">
                    <img src="components/avatar.php?color=989898">
                    <input type="text" placeholder="Inserire nome barca" id="edit-name">
                </div>
            </div>
            <div class="inputbox image">
                <p>Foto della barca</p>
                <div class="input" id="edit-img_container">
                    <input type="file" id="edit-img_input">
                    <div class="request">
                        <img src="assets/images/ui/addimage.svg">
                        <p>Clicca per caricare</p>
                    </div>
                    <img class="upload" id="edit-img">
                </div>
            </div>

            <div class="inputbox locations">
                <div class="box">
                    <p>Partenza</p>
                    <div class="multiple">
                        <div class="input">
                            <i class="fa fa-map-marker"></i>
                            <input type="text" placeholder="Partenza" id="edit-start_city">
                        </div>
                        <div class="input cap">
                            <input type="text" minlength="5" maxlength="5" placeholder="CAP" id="edit-start_cap">
                        </div>
                    </div>
                </div>

                <div class="box">
                    <p>Destinazione</p>
                    <div class="input">
                        <i class='fa fa-angle-double-right'></i>
                        <input type="text" placeholder="Destinazione" id="edit-destination">
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="buttons">
                <button class="confirm">Modifica</button>
                <button class="cancel">Annulla</button>
            </div>
        </div>
    </div>

</div>