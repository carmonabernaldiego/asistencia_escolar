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
        <button id="searchMobile" class="btn search-mobile btnsearch icon">search</button>
        <form action="/">
            <button class="btn btnexit icon" type="submit">exit_to_app</button>
        </form>
    </div>
    <div class="search">
        <form name="form-search" action="#" method="POST">
            <p>
                <input type="text" class="text" name="search" placeholder="Buscar...">
                <button class="btn-search icon" type="submit">search</button>
            </p>
        </form>
    </div>
</div>
<script>
var btnSearchMobile = document.getElementById('searchMobile');

var tl2 = gsap.timeline({
    defaults: {
        ease: "power2.inOut"
    }
})

var toggle2 = false;

tl2.to('.search', {
	opacity: 1,
	display: 'block'
});

tl2.pause();

btnSearchMobile.addEventListener('click', () => {
    toggle2 = !toggle2;
    if (toggle2 ? tl2.play() : tl2.reverse());
})
</script>