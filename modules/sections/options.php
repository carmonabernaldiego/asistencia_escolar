<?php
	include_once 'security.php';
?>
<div class="form-options">
    <div class="options">
        <form action="#" method="POST">
            <button class="btn icon" name="btn" value="form_add" type="submit">add</button>
        </form>
        <form action="#" method="POST">
            <button class="btn disabled icon" name="btn" value="form_coding" type="submit" disabled>code</button>
        </form>
        <form action="#" method="POST">
            <button class="btn disabled icon" name="btn" value="form_printer" type="submit" disabled>print</button>
        </form>
        <button id="btnSearchMobile" class="btn search-mobile btnsearch icon">search</button>
        <form action="/">
            <button class="btn btnexit icon" type="submit">exit_to_app</button>
        </form>
    </div>
    <div class="search">
        <form name="form-search" action="#" method="POST">
            <p>
                <input type="text" class="text" id="txtSearch" name="search" placeholder="Buscar...">
                <button class="btn-search icon" type="submit">search</button>
            </p>
        </form>
    </div>
</div>
<script>
$(function() {
    var botonMostrar = $("#btnSearchMobile"),
        formSearch = $(".search");

    botonMostrar.on("click", function() {
        if (formSearch.is(':hidden')) {
            formSearch.show('slow');
            document.getElementById("txtSearch").focus();
        } else {
            formSearch.hide('slow');
        }
    });
});
</script>